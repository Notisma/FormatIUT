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
            "Etudiant"
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
}