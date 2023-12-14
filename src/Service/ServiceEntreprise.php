<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

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
        //TODO vérifier utilité fonction mettreAJourInfos
        //TODO faire les vérifs
        if (isset($_REQUEST["siret"],$_REQUEST["nom"],$_REQUEST["statutJ"],$_REQUEST["effectif"],$_REQUEST['codeNAF'],$_REQUEST["tel"],$_REQUEST["adresse"])) {
            if (ConnexionUtilisateur::getTypeConnecte()=="Entreprises") {
                if ($_REQUEST["siret"] == ConnexionUtilisateur::getNumEntrepriseConnectee()) {
                    (new EntrepriseRepository())->mettreAJourInfos($_REQUEST['siret'], $_REQUEST['nom'], $_REQUEST['statutJ'], $_REQUEST['effectif'], $_REQUEST['codeNAF'], $_REQUEST['tel'], $_REQUEST['adresse']);
                    ControleurEntrMain::afficherProfil();
                } else ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Vous ne pouvez pas modifier les informations d'autres entreprises");
            } else ControleurMain::redirectionFlash("afficherIndex","danger","Vous n'avez pas les droits requis");
        }else ControleurEntrMain::redirectionFlash("afficherProfil","danger","Les informations ne sont pas renseignées");
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
}