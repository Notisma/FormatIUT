<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\Users\Utilisateur;

class Personnels extends Utilisateur
{

    public function getRecherche(): array
    {
        return array(
            "Formation",
            "Entreprise",
            "Etudiant",
            "Prof"
        );
    }

    public function getControleur(): string
    {
        return "AdminMain";
    }

    public function getImageProfil()
    {
        return "../ressources/images/admin.png";
    }

    public function getTypeConnecte(): string
    {
        return "Personnels";
    }

        public function getMenu(): array
    {
        $menu=$this->getDebutMenu();
        $menu[]=$this->getFinMenu();
        return $menu;
    }

    protected function getDebutMenu()
    {
        $accueil = ConnexionUtilisateur::getTypeConnecte();
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil $accueil", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/liste.png", "label" => "Liste des Offres", "lien" => "?action=afficherListeOffres&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),
        );
        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain");
        }

        if (ControleurAdminMain::getPageActuelleAdmin() == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
        }

        if (ControleurAdminMain::getPageActuelleAdmin() == "Détails d'un Étudiant") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Détails d'un Étudiant", "lien" => "?action=afficherDetailEtudiant&numEtudiant=$_GET[numEtudiant]");
        }

        if (ControleurAdminMain::getPageActuelleAdmin() == "Détails d'une Entreprise") {
            $menu[] = array("image" => "../ressources/images/equipe.png", "label" => "Détails d'une Entreprise", "lien" => "?action=afficherDetailEntreprise&siret=$_GET[idEntreprise]");
        }
        return $menu;
    }
    protected function getFinMenu()
    {
        return array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter&controleur=Main");
    }

    /**
     * @return array[] retourne l'ensemble des filtres appliquables pour un admin, rangés par éléments recherchables
     */

    public function getFiltresRecherche(): array
    {
        return array(

            "Entreprise"=>array(
                "filtre1"=>array("label"=>"Entreprises Validées","value"=>"entreprise_validee"),
                "filtre2"=>array("label"=>"Entreprises Non Validées","value"=>"entreprise_non_validee"),
            ),
            "Etudiant"=>array(
                "filtre3"=>array("label"=>"Etudiants A1","value"=>"etudiant_A1"),
                "filtre4"=>array("label"=>"Etudiants A2","value"=>"etudiant_A2"),
                "filtre5"=>array("label"=>"Etudiants A3","value"=>"etudiant_A3"),
                "filtre6"=>array("label"=>"Etudiants Avec Formation","value"=>"etudiant_avec_formation"),
                "filtre7"=>array("label"=>"Etudiants Sans Formation","value"=>"etudiant_sans_formation"),
                "filtre8"=>array("label"=>"Stagiaires","value"=>"etudiant_stage"),
                "filtre9"=>array("label"=>"Alternants","value"=>"etudiant_alternance"),
            ),
            "Formation"=>array(
                "filtre10"=>array("label"=>"Stages","value"=>"formation_stage"),
                "filtre11"=>array("label"=>"Alternances","value"=>"formation_alternance"),
                "filtre12"=>array("label"=>"Formations Validées","value"=>"formation_validee"),
                "filtre13"=>array("label"=>"Formations Non Validées","value"=>"formation_non_validee"),
                "filtre17"=>array("label"=>"Formations Disponibles","value"=>"formation_disponible"),
                "filtre18"=>array("label"=>"Formations Non Disponibles","value"=>"formation_non_disponible")
            ),
            "Prof"=>array(
                "filtre14"=>array("label"=>"Profs","value"=>"personnel_prof"),
                "filtre15"=>array("label"=>"Administrateurs","value"=>"personnel_admin"),
                "filtre16"=>array("label"=>"Secretariat","value"=>"personnel_secretariat")
            )
        );
    }
}