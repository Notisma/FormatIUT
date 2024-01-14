<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Lib\Users\Personnels;

class Secretariat extends Personnels
{

    /**
     * @return string le type de connexion de l'utilisateur connecté
     */
    public function getTypeConnecte(): string
    {
        return "Secretariat";
    }

    /**
     * @return array le menu présent dans le bandeau latéral du site.
     */
    public function getMenu(): array
    {
        $menu = parent::getDebutMenu();
        $menu[]= array("image" => "../ressources/images/document.png", "label"=> "Liste des conventions", "lien" =>"?action=afficherConventionAValider&controleur=AdminMain");
        $menu[] = array("image" => "../ressources/images/csv.png", "label" => "Mes CSV", "lien" => "?action=afficherVueCSV&controleur=AdminMain");
        $menu[] = parent::getFinMenu();
        return $menu;
    }

}