<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurAdminMain extends ControleurMain
{

    private static string $pageActuelleAdmin = "Accueil Admin";

    public static function afficherAccueilAdmin()
    {
        $listeEtudiants=(new EtudiantRepository())->etudiantsSansOffres();
        $listeEntreprises = (new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres = (new OffreRepository())->offresNonValides();
        self::$pageActuelleAdmin = "Accueil Administrateurs";
        self::afficherVue("Accueil Administrateurs", "Admin/vueAccueilAdmin.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises, "listeOffres" => $listeOffres,"listeEtudiants"=>$listeEtudiants]);
    }

    public static function afficherProfilAdmin()
    {
        self::$pageActuelleAdmin = "Mon Compte";
        self::afficherVue("Mon Compe", "Admin/vueCompteAdmin.php", self::getMenu());
    }

    public static function afficherListeEtudiant()
    {
        self::$pageActuelleAdmin = "Liste Étudiants";
        self::afficherVue("Liste Étudiants", "Admin/vueListeEtudiants.php", self::getMenu());
    }

    public static function afficherDetailOffre(/* string $idOffre = null */): void
    {
        self::$pageActuelleAdmin = "Détails d'une Offre";
        self::afficherVue("Détails d'une Offre", "Admin/vueDetailOffre.php", self::getMenu());
    }

    public static function afficherListeEntreprises(): void
    {
        self::$pageActuelleAdmin = "Liste Entreprises";
        self::afficherVue("Liste Entreprises", "Admin/vueListeEntreprises.php", self::getMenu());
    }


    public static function getMenu(): array
    {
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Administrateurs", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),


        );

        if (self::$pageActuelleAdmin == "Détails d'une Offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails d'une Offre", "lien" => "?action=afficherDetailOffre");
        }

        if (self::$pageActuelleAdmin == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/mon-compte.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
        }


        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter");


        return $menu;
    }
}