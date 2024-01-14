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
use App\FormatIUT\Service\ServiceEntreprise;
use App\FormatIUT\Service\ServiceFichier;
use App\FormatIUT\Service\ServiceFormation;
use App\FormatIUT\Service\ServiceMdp;
use DateTime;
use DateTimeZone;

class ControleurEntrMain extends ControleurMain
{

    private static string $page = "Accueil Entreprise";

    /**
     * @return string
     */
    public static function getPage(): string
    {
        return self::$page;
    }


    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour l'entreprise connecté
     */
    public static function afficherAccueilEntr(): void
    {
        $listeidFormation = ControleurMain::getSixMax((new FormationRepository())->listeidFormationEntreprise(ConnexionUtilisateur::getNumEntrepriseConnectee()));
        $listeOffre = array();
        for ($i = 0; $i < sizeof($listeidFormation); $i++) {
            $listeOffre[] = (new FormationRepository())->getObjectParClePrimaire($listeidFormation[$i]);
        }
        self::afficherVue("Accueil Entreprise", "Entreprise/vueAccueilEntreprise.php", ["listeOffre" => $listeOffre]);
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
        $liste = (new FormationRepository())->getListeOffreParEntreprise(ConnexionUtilisateur::getNumEntrepriseConnectee(), $_REQUEST["type"], $_REQUEST["etat"]);
        self::afficherVue("Mes Offres", "Entreprise/vueMesOffresEntr.php", ["type" => $_REQUEST["type"], "listeOffres" => $liste, "etat" => $_REQUEST["etat"]]);
    }

    /**
     * @return void affiche le profil de l'entreprise connecté
     */
    public static function afficherProfil(): void
    {
        self::$page = "Compte Entreprise";
        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        self::afficherVue("Compte Entreprise", "Entreprise/vueCompteEntreprise.php", ["entreprise" => $entreprise]);
    }

    /**
     * @return void affiche le formulaire de Création d'offre
     */
    public static function afficherFormulaireCreationOffre(): void
    {
        self::afficherVue("Créer une offre", "Entreprise/vueFormulaireCreationOffre.php");
    }

    /**
     * @return void affiche le formulaire de modification d'une offre
     */
    public static function afficherFormulaireModificationOffre(): void
    {
        if (isset($_REQUEST['idFormation'])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            self::afficherVue("Modifier l'offre", "Entreprise/vueFormulaireModificationOffre.php", ["offre" => $offre]);
        } else {
            self::afficherErreur("Une offre devrait être renseignée");
        }
    }

    /**
     * @return void affiche une vue dédiée aux détails d'un étudiant pour les entreprises
     */
    public static function afficherVueDetailEtudiant(): void
    {
        if (isset($_REQUEST['idEtudiant'])) {
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['idEtudiant']);
            self::$page = "Détails d'un Étudiant";
            self::afficherVue("Détails d'un Étudiant", "Entreprise/vueDetailEtudiant.php", ["etudiant" => $etudiant]);
        } else {
            self::redirectionFlash("afficherAccueilEntr","danger", "Un étudiant devrait être renseigné");
        }
    }

    /**
     * @return void affiche le formulaire de modification de l'entreprise connecté
     */
    public static function afficherFormulaireModification(): void
    {
        $entreprise = ((new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        self::afficherVue("Modifier vos informations", "Entreprise/vueMettreAJour.php", ["entreprise" => $entreprise]);
    }

    /**
     * @param string|null $idFormation l'id de la formation dont on affiche le detail
     * @return void affiche le détail d'une offre
     */

    public static function afficherVueDetailOffre(string $idFormation = null): void
    {
        if (!isset($_REQUEST['idFormation']) && is_null($idFormation))
            self::afficherErreur("Il faut préciser la formation");

        $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
        
        //if offre existe
        if ($offre->getIdEntreprise() == ConnexionUtilisateur::getNumEntrepriseConnectee()) {
            self::$page = "Détails de l'offre";
            /** @var ControleurMain $menu */
            $menu = Configuration::getCheminControleur();
            $liste = (new FormationRepository())->getListeidFormations();
            if ($idFormation || isset($_REQUEST["idFormation"])) {
                if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
                if (in_array($idFormation, $liste)) {
                    $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                    $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                    $client = "Entreprise";
                    $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                    self::afficherVue("Détails de l'offre", $chemin, ["offre" => $offre, "entreprise" => $entreprise]);
                } else {
                    self::redirectionFlash("afficherMesOffres", "danger", "Cette offre n'existe pas");
                }
            } else {
                self::redirectionFlash("afficherMesOffres", "danger", "L'offre n'est pas renseignée");
            }
        } else {
            self::redirectionFlash("afficherMesOffres", "danger", "Vous ne pouvez pas accéder à cette offre");
        }
    }

    //APPELS AUX SERVICES -------------------------------------------------------------------------------------------------------------------------------------------------

    public static function creerCompteEntreprise(): void
    {
        ServiceEntreprise::creerCompteEntreprise();
    }
    
    public static function mettreAJour(): void
    {
        ServiceEntreprise::mettreAJourEntreprise();
    }

    public static function resetMDP(): void
    {
        ServiceMdp::resetMdp();
    }

    public static function supprimerFormation(): void
    {
        ServiceFormation::supprimerFormation();
    }

    public static function mettreAJourEntreprise(): void
    {
        ServiceEntreprise::mettreAJourEntreprise();
    }

    public static function telechargerCV(): void
    {
        ServiceFichier::telechargerCV();
    }

    public static function telechargerLM(): void
    {
        ServiceFichier::telechargerLM();
    }

    public static function mettreAJourMdp(): void
    {
        ServiceMdp::mettreAJourMdp();
    }

    public static function creerFormation(): void
    {
        ServiceFormation::creerFormation();
    }

    public static function modifierOffre(): void
    {
        ServiceFormation::modifierOffre();
    }

    public static function ajouterTuteur(): void
    {
        ServiceEntreprise::creerTuteur();
    }

    public static function supprimerTuteur()
    {
        ServiceEntreprise::supprimerTuteur();
    }

    public static function modifierFonctionTuteur()
    {
        ServiceEntreprise::modifierFonctionTuteur();
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void met à jour l'image de profil de l'entreprise connecté
     */
    public static function updateImage(): void
    {
        $entreprise = ((new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getNumEntrepriseConnectee()));
        $nom = "";
        $nomEntreprise = $entreprise->getNomEntreprise();
        for ($i = 0; $i < strlen($entreprise->getNomEntreprise()); $i++) {
            if ($nomEntreprise[$i] == ' ') {
                $nom .= "_";
            } else {
                $nom .= $nomEntreprise[$i];
            }
        }

        $ancienId = (new UploadsRepository())->imageParEntreprise(ConnexionUtilisateur::getNumEntrepriseConnectee());

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
