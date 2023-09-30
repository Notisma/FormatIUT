<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;

class ControleurEntrMain extends ControleurMain
{

    public static function afficherAccueilEntr(){
    self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Entreprise/vueAccueilEntreprise","titrePage"=>"Accueil Entreprise"]);
    }
    public static function getMenu(): array
    {
        return array(
          array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Entreprise","lien"=>"?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"controleurFrontal.php")

        );
    }
}