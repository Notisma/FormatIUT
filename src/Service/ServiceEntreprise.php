<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
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
    public static function mettreAJour(): void
    {
        //TODO vérifier utilité fonction mettreAJourInfos
        (new EntrepriseRepository())->mettreAJourInfos($_REQUEST['siret'], $_REQUEST['nom'], $_REQUEST['statutJ'], $_REQUEST['effectif'], $_REQUEST['codeNAF'], $_REQUEST['tel'], $_REQUEST['adresse']);
        ControleurEntrMain::afficherProfil();
    }
}