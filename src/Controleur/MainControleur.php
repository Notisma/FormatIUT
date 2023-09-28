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
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil","lien"=>"afficherOffresAlternance"),
            array("image"=>"../ressources/images/profil.png","label"=>"Se Connecter","lien"=>"afficherAccueilEtu")
        );
    }
}