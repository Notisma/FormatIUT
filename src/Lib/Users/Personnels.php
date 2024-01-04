<?php

namespace App\FormatIUT\Lib\Users;

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

    public function getFiltresRecherche(): array
    {
        return array(
            "filtre1"=>array("label"=>"Entreprises Validées","value"=>"entreprise_validee"),
            "filtre2"=>array("label"=>"Entreprises Non Validées","value"=>"entreprise_non_validee"),
            "filtre3"=>array("label"=>"Etudiants A1","value"=>"etudiant_A1"),
            "filtre4"=>array("label"=>"Etudiants A2","value"=>"etudiant_A2"),
            "filtre5"=>array("label"=>"Etudiants A3","value"=>"etudiant_A3"),
            "filtre6"=>array("label"=>"Etudiants Avec Formation","value"=>"etudiant_avec_formation"),
            "filtre7"=>array("label"=>"Etudiants Sans Formation","value"=>"etudiant_sans_formation"),
            "filtre8"=>array("label"=>"Stagiaires","value"=>"etudiant_stage"),
            "filtre9"=>array("label"=>"Alternants","value"=>"etudiant_alternance"),
            "filtre10"=>array("label"=>"Stages","value"=>"formation_stage"),
            "filtre11"=>array("label"=>"Alternances","value"=>"formation_alternance"),
            "filtre12"=>array("label"=>"Formations Validées","value"=>"formation_validee"),
            "filtre13"=>array("label"=>"Formations Non Validées","value"=>"formation_non_validee"),
            "filtre14"=>array("label"=>"Profs","value"=>"personnel_prof"),
            "filtre15"=>array("label"=>"Administrateurs","value"=>"personnel_admin"),
            "filtre16"=>array("label"=>"Secretariat","value"=>"personnel_secretariat")
        );
    }
}