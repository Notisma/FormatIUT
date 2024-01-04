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
            "filtre1"=>"entreprise_validee",
            "filtre2"=>"entreprise_non_validee",
            "filtre3"=>"etudiant_A1",
            "filtre4"=>"etudiant_A2",
            "filtre5"=>"etudiant_A3",
            "filtre6"=>"etudiant_avec_formation",
            "filtre7"=>"etudiant_sans_formation",
            "filtre8"=>"etudiant_stage",
            "filtre9"=>"etudiant_alternance",
            "filtre10"=>"formation_stage",
            "filtre11"=>"formation_alternance",
            "filtre12"=>"formation_validee",
            "filtre13"=>"formation_non_validee",
            "filtre14"=>"personnel_prof",
            "filtre15"=>"personnel_admin",
            "filtre16"=>"personnel_secretariat"
        );
    }
}