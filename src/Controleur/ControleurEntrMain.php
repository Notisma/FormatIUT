<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;

class ControleurEntrMain extends ControleurMain
{

    public static function afficherAccueilEntr(){
    self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Entreprise/vueAccueilEntreprise.php","titrePage"=>"Accueil Entreprise"]);
    }

    public static function formulaireCreationOffre(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Entreprise/formulaireCreationOffre.php","titrePage","titrePage"=>"Créer une offre"]);
    }

    public static function creerOffre(){
        echo "Fonction en cours de création";
        self::afficherAccueilEntr();
    }
    public static function getMenu(): array
    {
        return array(
          array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Entreprise","lien"=>"?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image"=>"","label"=>"Créer une offre","lien"=>"?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"ControleurFrontal.php")

        );
    }
}