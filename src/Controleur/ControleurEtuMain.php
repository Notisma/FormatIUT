<?php

namespace App\FormatIUT\Controleur;

class ControleurEtuMain extends ControleurMain
{
    public static function afficherAccueilEtu(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Etudiant/vueAccueilEtudiant.php","titrePage"=>"Accueil Etudiants"]);
    }
    public static function afficherCatalogue(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Etudiant/vueCatalogueOffre.php","titrePage"=>"Liste des Offres"]);
    }

    public static function getMenu(): array
    {
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Etudiants","lien"=>"?action=afficherAccueilEtu&controleur=EtuMain"),
            array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/stage.png","label"=>"Offres de Stage","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"controleurFrontal.php")
        );
    }

}