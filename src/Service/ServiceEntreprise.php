<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;

class ServiceEntreprise
{

    /**
     * @return void permet à l'admin connecté de refuser une entreprise
     */
    public static function refuserEntreprise(): void
    {
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$entreprise->isEstValide()) {
                        (new EntrepriseRepository())->supprimer($entreprise->getSiret());
                        ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "success", "L'entreprise a bien été refusée");
                    } else ControleurAdminMain::redirectionFlash("afficherDetailEntreprise", "warning", "L'entreprise est déjà validé");
                } else ControleurAdminMain::redirectionFlash("afficherDetailEntreprise", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "warning", "L'entreprise n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "danger", "L'entreprise n'est pas renseignée");

    }


    /**
     * @return void permet à l'admin connecté de valider une entreprise
     */
    public static function validerEntreprise(): void
    {
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$entreprise->isEstValide()) {
                        $entreprise->setEstValide(true);
                        (new EntrepriseRepository())->modifierObjet($entreprise);
                        ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "success", "L'entreprise a bien été validée");
                    } else ControleurAdminMain::redirectionFlash("afficherDetailEntreprise", "warning", "L'entreprise est déjà valider");
                } else ControleurAdminMain::redirectionFlash("afficherDetailEntreprise", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "warning", "L'entreprise n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "danger", "L'entreprise n'est pas renseignée");
    }

    /**
     * @return void permet à l'entreprise de supprimer (archiver) une entreprise
     */
    public static function supprimerEntreprise(): void
    {
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    (new EntrepriseRepository())->supprimer($_REQUEST['siret']);
                    ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "success", "L'entreprise a bien été supprimé");
                } else ControleurAdminMain::redirectionFlash("afficherDetailEntreprise", "danger", "Vous n'avez pas les drois requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "warning", "L'entreprise n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "danger", "L'entreprise n'est pas renseignée");
    }

    /**
     * @return void met à jour les informations de l'entreprise connecté
     */
    public static function mettreAJourEntreprise(): void
    {
        if (isset($_REQUEST["siret"], $_REQUEST["nom"], $_REQUEST["statutJ"], $_REQUEST["effectif"], $_REQUEST['codeNAF'], $_REQUEST["tel"], $_REQUEST["adresse"])) {
            if (ConnexionUtilisateur::getTypeConnecte() == "Entreprise") {
                if ($_REQUEST["siret"] == ConnexionUtilisateur::getNumEntrepriseConnectee()) {
                    ControleurEntrMain::updateImage();
                    (new EntrepriseRepository())->mettreAJourInfos($_REQUEST['siret'], $_REQUEST['nom'], $_REQUEST['statutJ'], $_REQUEST['effectif'], $_REQUEST['codeNAF'], $_REQUEST['tel'], $_REQUEST['adresse']);
                    ControleurEntrMain::redirectionFlash("afficherProfil", "success", "Les informations ont bien été modifiées");
                } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Vous ne pouvez pas modifier les informations d'autres entreprises");
            } else ControleurMain::redirectionFlash("afficherIndex", "danger", "Vous n'avez pas les droits requise");
        } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Les informations ne sont pas renseignées");
    }


    /**
     * @return void créeer une entreprise dans la BD et envoie un mail de validation
     */
    public static function creerCompteEntreprise(): void
    {
        //vérification des nombres négatifs
        if ($_REQUEST["siret"] > 0 && $_REQUEST["codePostal"] > 0 && $_REQUEST["tel"] > 0 && $_REQUEST["effectif"] > 0) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["siret"]);
            //vérification de doublon de Siret
            if (is_null($entreprise)) {
                $liste = ((new EntrepriseRepository())->getListeObjet());
                $listeMail = null;
                foreach ($liste as $entreprise) {
                    $listeMail[] = $entreprise->getEmail();
                }
                //vérification de doublon de mail
                if (!in_array($_REQUEST["email"], $listeMail)) {
                    //concordance des mots de passe
                    if ($_REQUEST["mdp"] == $_REQUEST["mdpConf"]) {
                        if (strlen($_REQUEST["mdp"]) >= 8) {
                            $entreprise = Entreprise::construireDepuisFormulaire($_REQUEST);
                            (new EntrepriseRepository())->creerObjet($entreprise);
                            VerificationEmail::envoiEmailValidation($entreprise);
                            ControleurMain::redirectionFlash("afficherPageConnexion", "info", "Un email de validation vous a été envoyé");
                        } else {
                            ControleurMain::redirectionFlash("afficherVuePresentation", "warning", "Le mot de passe doit faire plus de 7 caractères");
                        }
                    } else {
                        ControleurMain::redirectionFlash("afficherVuePresentation", "warning", "Les mots de passes doivent corréler");
                    }
                } else {
                    ControleurMain::redirectionFlash("afficherVuePresentation", "warning", "L'adresse mail est déjà utilisée");
                }
            } else {
                ControleurMain::redirectionFlash("afficherVuePresentation", "danger", "Le SIRET est déjà utilisé");
            }
        } else {
            ControleurMain::redirectionFlash("afficherVuePresentation", "danger", "Des données sont érronées");
        }
    }

    public static function modifierEntreprise(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            if ((new EntrepriseRepository())->getObjectParClePrimaire($_GET['siret']) == null) {
                ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "danger", "L'entreprise n'existe pas");
            } else {
                $entr = (new EntrepriseRepository())->getObjectParClePrimaire($_GET['siret']);
                /** @var Entreprise $entr */
                $entr->setNomEntreprise($_REQUEST['nomEntreprise']);
                $entr->setAdresseEntreprise($_REQUEST['adresseEntreprise']);
                $entr->setEmail($_REQUEST["email"]);
                $entr->setTel($_REQUEST["tel"]);
                $entr->setStatutJuridique($_REQUEST["statutJuridique"]);
                $entr->setEffectif($_REQUEST["effectif"]);
                $entr->setCodeNAF($_REQUEST["codeNAF"]);
                $_REQUEST['img'] = $entr->getImg();
                $_REQUEST['mdpHache'] = $entr->getMdpHache();
                $_REQUEST['emailAValider'] = $entr->getEmailAValider();
                $_REQUEST['nonce'] = $entr->getNonce();
                $_REQUEST['dateCreationCompte'] = $entr->getDateCreationCompte();
                if ((new VilleRepository())->getVilleParNom($_REQUEST["ville"]) == null) {
                    (new VilleRepository())->creerObjet(new Ville(null, $_REQUEST["ville"], $_REQUEST["codePostal"]));
                }
                $entr->setIdVille((new VilleRepository())->getVilleParNom($_REQUEST["ville"]));
                (new EntrepriseRepository())->modifierObjet($entr);
                ControleurAdminMain::redirectionFlash("afficherDetailEntreprise", "success", "L'entreprise a bien été modifiée");
            }
        } else {
            ControleurAdminMain::redirectionFlash("afficherListeEntreprises", "danger", "Vous ne pouvez pas effectuer cette action" );
        }
    }


    /**
     * @return void crée un tuteur dans la BD
     */
    public static function creerTuteur() {
        if (isset($_REQUEST["siret"], $_REQUEST["nomTuteur"], $_REQUEST["prenomTuteur"], $_REQUEST["emailTuteur"], $_REQUEST["telTuteur"], $_REQUEST["fonctionTuteur"])) {
            if (ConnexionUtilisateur::getTypeConnecte() == "Entreprise") {
                if ($_REQUEST["siret"] == ConnexionUtilisateur::getNumEntrepriseConnectee()) {
                    $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["siret"]);
                    if (!is_null($entreprise)) {
                            if (strlen($_REQUEST["telTuteur"]) == 10) {
                                $entreprise->ajouterTuteur($_REQUEST["nomTuteur"], $_REQUEST["prenomTuteur"], $_REQUEST["emailTuteur"], $_REQUEST["telTuteur"], $_REQUEST["fonctionTuteur"]);
                                (new EntrepriseRepository())->modifierObjet($entreprise);
                                ControleurEntrMain::redirectionFlash("afficherProfil", "success", "Le tuteur a bien été ajouté");
                            } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Le numéro de téléphone doit faire 10 caractères");
                    } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "L'entreprise n'existe pas");
                } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Vous ne pouvez pas modifier les informations d'autres entreprises");
            } else ControleurMain::redirectionFlash("afficherIndex", "danger", "Vous n'avez pas les droits requise");
        } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Les informations ne sont pas renseignées");
    }
}