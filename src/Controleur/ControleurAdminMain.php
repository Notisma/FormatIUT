<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurAdminMain extends ControleurMain
{

    public static function afficherAccueilAdmin(){
        $listeEntreprises=(new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres=(new OffreRepository())->offresNonValides();
        self::afficherVue("Accueil Administrateurs","Admin/vueAccueilAdmin.php",self::getMenu(),["listeEntreprises"=>$listeEntreprises,"listeOffres"=>$listeOffres]);
    }

    public static function afficherProfilAdmin(){
        self::afficherVue("Compte Personnel","Admin/vueCompteAdmin.php",self::getMenu());
    }

    public static function afficherListeEtudiant(){
        self::afficherVue("Liste Étudiants","Admin/vueListeEtudiants.php",self::getMenu());
    }
    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Administrateurs", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png","label"=>"Liste Étudiants","lien"=>"?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png","label"=>"Liste Entreprises","lien"=>"?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter"),

        );
    }
}