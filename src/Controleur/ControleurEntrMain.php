<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use DateTime;
use DateTimeZone;

class ControleurEntrMain extends ControleurMain
{

    private static string $page = "Accueil Entreprise";


    /**
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
     */
    public static function getMenu(): array
    {
        $menu =  array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=afficherFormulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&type=Tous&controleur=EntrMain"),

        );

        if (self::$page == "Compte Entreprise") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Compte Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php?action=seDeconnecter&service=Connexion");

        return $menu;


    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour l'entreprise connecté
     */
    public static function afficherAccueilEntr(): void
    {
        $listeidFormation = self::getSixMax((new FormationRepository())->listeidFormationEntreprise(ConnexionUtilisateur::getUtilisateurConnecte()->getSiret()));
        $listeOffre = array();
        for ($i = 0; $i < sizeof($listeidFormation); $i++) {
            $listeOffre[] = (new FormationRepository())->getObjectParClePrimaire($listeidFormation[$i]);
        }
        self::afficherVue("Accueil Entreprise", "Entreprise/vueAccueilEntreprise.php", self::getMenu(), ["listeOffre" => $listeOffre]);
    }

    /**
     * @return void affiche la liste des offres de l'entreprise connecté
     */
    public static function afficherMesOffres(): void
    {
        if (!isset($_REQUEST["type"])) {
            $_REQUEST["type"] = "Tous";
        }
        if (!isset($_REQUEST["etat"])) {
            $_REQUEST["etat"] = "Tous";
        }
        $liste = (new FormationRepository())->getListeOffreParEntreprise(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin(), $_REQUEST["type"], $_REQUEST["etat"]);
        self::afficherVue("Mes Offres", "Entreprise/vueMesOffresEntr.php", self::getMenu(), ["type" => $_REQUEST["type"], "listeOffres" => $liste, "etat" => $_REQUEST["etat"]]);
    }

    /**
     * @return void affiche le profil de l'entreprise connecté
     */
    public static function afficherProfil(): void
    {
        self::$page = "Compte Entreprise";
        $entreprise = ConnexionUtilisateur::getUtilisateurConnecte();
        self::afficherVue("Compte Entreprise", "Entreprise/vueCompteEntreprise.php", self::getMenu(), ["entreprise" => $entreprise]);
    }

    /**
     * @return void affiche le formulaire de Création d'offre
     */
    public static function afficherFormulaireCreationOffre(): void
    {
        self::afficherVue("Créer une offre", "Entreprise/vueFormulaireCreationOffre.php", self::getMenu());
    }

    /**
     * @return void affiche le formulaire de modification d'une offre
     */
    public static function afficherFormulaireModificationOffre(): void
    {
        if (isset($_REQUEST['idFormation'])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            self::afficherVue("Modifier l'offre", "Entreprise/vueFormulaireModificationOffre.php", self::getMenu(), ["offre" => $offre]);
        } else {
            self::afficherErreur("Une offre devrait être renseignée");
        }
    }

    /**
     * @return void affiche le formulaire de modification de l'entreprise connecté
     */
    public static function afficherFormulaireModification(): void
    {
        $entreprise = ConnexionUtilisateur::getUtilisateurConnecte();
        self::afficherVue("Modifier vos informations", "Entreprise/vueMettreAJour.php", self::getMenu(), ["entreprise" => $entreprise]);
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void met à jour l'image de profil de l'entreprise connecté
     */
    public static function updateImage(): void
    {
        $entreprise = ConnexionUtilisateur::getUtilisateurConnecte();
        $nom = "";
        $nomEntreprise = $entreprise->getNomEntreprise();
        for ($i = 0; $i < strlen($entreprise->getNomEntreprise()); $i++) {
            if ($nomEntreprise[$i] == ' ') {
                $nom .= "_";
            } else {
                $nom .= $nomEntreprise[$i];
            }
        }

        $ancienId = (new UploadsRepository())->imageParEntreprise($entreprise->getImg());

        $ai_id = TransfertImage::transfert();
        $entreprise->setImg($ai_id);
        (new EntrepriseRepository())->modifierObjet($entreprise);

        if ($ancienId["img_id"] != 0) {
            (new UploadsRepository())->supprimer($ancienId["img_id"]);
        }
        $_REQUEST["action"] = "afficherProfil()";
        MessageFlash::ajouter("success", "Image modifiée avec succès.");
        self::afficherProfil();
    }

    /**
     * @param string $action le nom de la fonction sur laquelle rediriger
     * @param string $type le type de message Flash
     * @param string $message le message à envoyer
     * @return void redirige en envoyant un messageFlash
     */
    public static function redirectionFlash(string $action, string $type, string $message): void
    {
        MessageFlash::ajouter($type, $message);
        self::$action();
    }
}
