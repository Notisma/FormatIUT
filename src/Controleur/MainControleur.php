<?php

namespace App\FormatIUT\Controleur;

class MainControleur
{


    public static function afficherIndex(){
        self::afficherVue('vueGenerale.php',["menu"=>self::getMenu(),"chemin"=>"vueIndex.php"]);
    }

    public static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function getMenu() :array{
        return array(
            "Menu 1"=>"lien",
            "Menu 2"=>"lien",
            "Menu 3"=>"lien",
            "Menu 4"=>"lien",
            "Menu 5"=>"lien"
        );
    }
}