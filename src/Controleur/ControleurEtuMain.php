<?php

namespace App\FormatIUT\Controleur;

class ControleurEtuMain extends ControleurMain
{
    public static function afficherAccueilEtu(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"vueAccueilEtudiant.php"]);
    }

    public static function getMenu(): array
    {
        return array();
    }

}