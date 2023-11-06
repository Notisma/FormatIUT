<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;

class ControleurProfMain extends ControleurMain
{

    public static function afficherAccueilProf(){
        self::afficherVue("Accueil Personnels","Prof/vueAccueilProf.php",self::getMenu());
    }
    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Personnels", "lien" => "?action=afficherAccueilProf&controleur=ProfMain"),
            array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter"),

        );
    }
}