<?php

namespace App\FormatIUT\Controleur;

class ControleurEtuMain extends ControleurMain
{
    public static function afficherAccueilEtu(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"vueAccueilEtudiant.php","titrePage"=>"Accueil"]);
    }

    public static function getMenu(): array
    {
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil","lien"=>"?action=afficherAccueilEtu&controleur=EtuMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"controleurFrontal.php")
        );
    }

}