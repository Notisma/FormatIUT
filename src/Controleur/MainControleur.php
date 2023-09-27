<?php

namespace App\FormatIUT\Controleur;

class MainControleur
{

    public static function afficherAccueilEtu(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"vueAccueilEtudiant.php"]);
    }

    public static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function getMenu() :array{
        return array(
            "Menu"=>"lien",
            "About"=>"lien",
            "Blogs"=>"lien",
            "Portfolio"=>"lien",
            "Contact"=>"lien"
        );
    }
}