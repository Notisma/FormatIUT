<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurAdminMain extends ControleurMain
{

    private static string $pageActuelleAdmin = "Accueil Admin";

    public static function afficherAccueilAdmin()
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsSansOffres();
        $listeEntreprises = (new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres = (new OffreRepository())->offresNonValides();
        self::$pageActuelleAdmin = "Accueil Administrateurs";
        self::afficherVue("Accueil Administrateurs", "Admin/vueAccueilAdmin.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises, "listeOffres" => $listeOffres, "listeEtudiants" => $listeEtudiants]);
    }

    public static function afficherProfilAdmin()
    {
        self::$pageActuelleAdmin = "Mon Compte";
        self::afficherVue("Mon Compe", "Admin/vueCompteAdmin.php", self::getMenu());
    }

    public static function afficherDetailEtudiant()
    {
        self::$pageActuelleAdmin = "Détails d'un Étudiant";
        self::afficherVue("Détails d'un Étudiant", "Admin/vueDetailEtudiant.php", self::getMenu());
    }

    public static function afficherListeEtudiant()
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsEtats();
        self::$pageActuelleAdmin = "Liste Étudiants";
        self::afficherVue("Liste Étudiants", "Admin/vueListeEtudiants.php", self::getMenu(), ["listeEtudiants" => $listeEtudiants]);
    }

    public static function afficherDetailEntreprise(/* String $mailEntreprise */)
    {
        self::$pageActuelleAdmin = "Détails d'une Entreprise";
        self::afficherVue("Détails d'une Entreprise", "Admin/vueDetailEntreprise.php", self::getMenu());
    }

    public static function afficherListeEntreprises(): void
    {
        self::$pageActuelleAdmin = "Liste Entreprises";
        self::afficherVue("Liste Entreprises", "Admin/vueListeEntreprises.php", self::getMenu());
    }

    public static function afficherVueCSV(): void {
        self::$pageActuelleAdmin = "Mes CSV";
        self::afficherVue("Mes CSV", "Admin/vueCSV.php", self::getMenu());
    }


    public static function getMenu(): array
    {
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Administrateurs", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/liste.png", "label" => "Liste des Offres", "lien" => "?action=afficherListeOffres&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),
            array("image" => "../ressources/images/document.png", "label" => "Mes CSV", "lien" => "?action=afficherVueCSV&controleur=AdminMain"),


        );

        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain");
        }

        if (self::$pageActuelleAdmin == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/mon-compte.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
        }

        if (self::$pageActuelleAdmin == "Détails d'un Étudiant") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Détails d'un Étudiant", "lien" => "?action=afficherDetailEtudiant");
        }


        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter");


        return $menu;
    }


    public static function accepterOffre(): void
    {
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
        $offre->setEstValide(true);
        (new OffreRepository())->modifierObjet($offre);
        header("Location: ?action=afficherVueDetailOffre&controleur=AdminMain&idOffre=" . $offre->getIdOffre());
        MessageFlash::ajouter("success", "L'offre a bien été validée");
    }


    public static function rejeterOffre(): void
    {
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
        (new OffreRepository())->supprimer($offre->getIdOffre());
        self::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été rejetée");
    }

    public static function supprimerOffre() : void {
        //TODO : FAIRE LES VERIFICATIONS
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
        (new OffreRepository())->supprimer($_REQUEST['idOffre']);
        self::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été supprimée");
    }
}