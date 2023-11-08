<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\Repository\ConnexionLdap;

class ControleurProfMain extends ControleurMain
{

    public static function afficherAccueilProf(){
        self::afficherVue("Accueil Personnels","Prof/vueAccueilProf.php",self::getMenu());
    }

    public static function afficherProfilProf(){
        self::afficherVue("Compte Personnel","Prof/vueCompteProf.php",self::getMenu());
    }

    public static function afficherListeEtudiant(){
        self::afficherVue("Liste Etudiants","Prof/vueListeEtudiants.php",self::getMenu());
    }
    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Personnels", "lien" => "?action=afficherAccueilProf&controleur=ProfMain"),
            array("image" => "../ressources/images/liste.png","label"=>"Liste Etudiants","lien"=>"?action=afficherListeEtudiant&controleur=ProfMain"),
            array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter"),

        );
    }
}