<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\InsertionCSV;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\pstageRepository;

class ControleurAdminMain extends ControleurMain
{
    private static string $pageActuelleAdmin = "Accueil Admin";

    /**
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
     */
    public static function getMenu(): array
    {
        $accueil = "";
        if (ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
            $accueil = "Personnels";
        } else if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            $accueil = "Administrateurs";
        }
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil $accueil", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/liste.png", "label" => "Liste des Offres", "lien" => "?action=afficherListeOffres&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),
        );
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            $menu[] = array("image" => "../ressources/images/document.png", "label" => "Mes CSV", "lien" => "?action=afficherVueCSV&controleur=AdminMain");
        }

        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain");
        }

        if (self::$pageActuelleAdmin == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
        }

        if (self::$pageActuelleAdmin == "Détails d'un Étudiant") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Détails d'un Étudiant", "lien" => "?action=afficherDetailEtudiant");
        }

        if (self::$pageActuelleAdmin == "Détails d'une Entreprise") {
            $menu[] = array("image" => "../ressources/images/equipe.png", "label" => "Détails d'une Entreprise", "lien" => "?action=afficherDetailEntreprise");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter&service=Connexion");

        return $menu;
    }


    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour un Administrateur connecté
     */
    public static function afficherAccueilAdmin(): void
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsSansOffres();
        $listeEntreprises = (new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres = (new FormationRepository())->offresNonValides();
        $accueil = "Administrateurs";
        if (ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
            $accueil = "Personnels";
        }
        self::$pageActuelleAdmin = "Accueil Administrateurs";
        self::afficherVue("Accueil $accueil", "Admin/vueAccueilAdmin.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises, "listeOffres" => $listeOffres, "listeEtudiants" => $listeEtudiants]);
    }


    /**
     * @return void affiche le profil de l'administrateur connecté
     */
    public static function afficherProfilAdmin(): void
    {
        self::$pageActuelleAdmin = "Mon Compte";
        self::afficherVue("Mon Compte", "Admin/vueCompteAdmin.php", self::getMenu());
    }

    /**
     * @return void affiche les informations d'un étudiant
     */
    public static function afficherDetailEtudiant(): void
    {
        self::$pageActuelleAdmin = "Détails d'un Étudiant";
        self::afficherVue("Détails d'un Étudiant", "Admin/vueDetailEtudiant.php", self::getMenu());
    }

    /**
     * @return void affiche la liste des étudiants
     */
    public static function afficherListeEtudiant(): void
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsEtats();
        self::$pageActuelleAdmin = "Liste Étudiants";
        self::afficherVue("Liste Étudiants", "Admin/vueListeEtudiants.php", self::getMenu(), ["listeEtudiants" => $listeEtudiants]);
    }

    /**
     * @return void affiche les informations d'une entreprise
     */
    public static function afficherDetailEntreprise(): void
    {
        self::$pageActuelleAdmin = "Détails d'une Entreprise";
        self::afficherVue("Détails d'une Entreprise", "Admin/vueDetailEntreprise.php", self::getMenu());
    }

    /**
     * @return void affiche la liste des entreprises
     */
    public static function afficherListeEntreprises(): void
    {
        $listeEntreprises = (new EntrepriseRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste Entreprises";
        self::afficherVue("Liste Entreprises", "Admin/vueListeEntreprises.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises]);
    }

    /**
     * @return void affiche la page d'importation et d'exportation des csv
     */
    public static function afficherVueCSV(): void
    {
        self::$pageActuelleAdmin = "Mes CSV";
        self::afficherVue("Mes CSV", "Admin/vueCSV.php", self::getMenu());
    }

    public static function afficherListeOffres(): void
    {
        $listeOffres = (new FormationRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste des Offres";
        self::afficherVue("Liste des Offres", "Admin/vueListeOffres.php", self::getMenu(), ["listeOffres" => $listeOffres]);
    }

    /**
     * @return void affiche la page d'ajout d'un étudiant
     */

    public static function afficherFormulaireCreationEtudiant(): void
    {
        self::$pageActuelleAdmin = "Ajouter un étudiant";
        self::afficherVue("Ajouter un étudiant", "Admin/vueFormulaireCreationEtudiant.php", self::getMenu());
    }



    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @param string $action le nom de la fonction sur laquelle rediriger
     * @param string $type le type de message Flash
     * @param string $message le message à envoyer
     * @return void redirige en envoyant un messageFlash
     */
    public static function redirectionFlash(string $action, string $type, string $message): void
    {
        MessageFlash::ajouter($type, $message);
        header("Location : ?controleur=AdminMain&action=$action");
    }
}
