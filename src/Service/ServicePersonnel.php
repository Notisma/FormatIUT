<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\FormationRepository;

class ServicePersonnel
{
    public static function promouvoirProf(): void
    {
        if (isset($_REQUEST["loginProf"])) {
            $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($_REQUEST['loginProf']);
            if (!is_null($prof)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$prof->isEstAdmin()) {
                        $prof->setEstAdmin(true);
                        (new \App\FormatIUT\Modele\Repository\ProfRepository())->modifierObjet($prof);
                        ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "success", "Permissions mises à jour");
                    } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur est déjà administrateur");
                } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Le professeur n'est pas renseigné");
    }


    public static function retrograderProf(): void
    {
        if (isset($_REQUEST["loginProf"])) {
            $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($_REQUEST['loginProf']);
            if (!is_null($prof)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if ($prof->isEstAdmin()) {
                        $prof->setEstAdmin(false);
                        (new \App\FormatIUT\Modele\Repository\ProfRepository())->modifierObjet($prof);
                        ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "success", "Permissions mises à jour");
                    } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'est pas administrateur");
                } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Le professeur n'est pas renseigné");
    }

    public static function devenirTuteur(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs" || ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
            $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtu']);
            if ($formation) {
                if ($formation->getloginTuteurUM() == null) {
                    $formation->setloginTuteurUM(ConnexionUtilisateur::getLoginUtilisateurConnecte());
                    (new FormationRepository())->modifierObjet($formation);
                    ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "success", "Vous êtes bien tuteur de cet élève");
                } else {
                    ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "warning", "Cet étudiant a déjà un tuteur de l'UM");
                }
            } else {
                ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "warning", "Cet étudiant n'a pas de formation");
            }
        } else {
            ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "danger", "Vous n'êtes pas un enseignant");
        }
    }
}