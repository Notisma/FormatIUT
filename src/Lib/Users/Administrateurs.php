<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\Users\Utilisateur;

class Administrateurs extends Personnels
{

    public function getTypeConnecte(): string
    {
        return "Administrateurs";
    }

    public function getMenu(): array
    {
        $menu = parent::getDebutMenu();
        $menu[] = array("image" => "../ressources/images/document.png", "label" => "Mes CSV", "lien" => "?action=afficherVueCSV&controleur=AdminMain");
        $menu[] = parent::getFinMenu();
        return $menu;
    }
}