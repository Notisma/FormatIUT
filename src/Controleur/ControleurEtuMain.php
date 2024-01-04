<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Modele\DataObject\Postuler;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Modele\Repository\ResidenceRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use App\FormatIUT\Service\ServiceConvention;
use App\FormatIUT\Service\ServiceEtudiant;
use App\FormatIUT\Service\ServiceFichier;
use App\FormatIUT\Service\ServicePostuler;
use DateTime;
use Exception;

class ControleurEtuMain extends ControleurMain
{
    private static string $titrePageActuelleEtu = "Accueil Etudiants";

    public static function getCleEtudiant(): int
    {
        return ConnexionUtilisateur::getNumEtudiantConnecte();
    }

    public static function getTitrePageActuelleEtu(): string
    {
        return self::$titrePageActuelleEtu;
    }

    /**
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
     */
    public static function getMenu(): array
    {
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Etudiants", "lien" => "?action=afficherAccueilEtu&controleur=EtuMain"),
            array("image" => "../ressources/images/stage.png", "label" => "Offres de Stage/Alternance", "lien" => "?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/signet.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&controleur=EtuMain"),
        );

        $formation = (new EtudiantRepository())->aUneFormation(self::getCleEtudiant());
        if ($formation && ControleurMain::getPageActuelle() != "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=" . $formation['idFormation']);
        }
        if (self::$titrePageActuelleEtu == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfil&controleur=EtuMain");
        }

        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => "Détails de l'offre", "lien" => "?afficherVueDetailOffre&controleur=EtuMain&idFormation=".$_REQUEST['idFormation']);
        }

        $offre = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
        if ($offre && $offre->getDateCreationConvention() == null) {
            $offreValidee = (new PostulerRepository())->getOffreValider(self::getCleEtudiant());
            if ($offreValidee) {
                $offre = (new FormationRepository())->getObjectParClePrimaire($offreValidee->getidFormation());
                if ($offre->getTypeOffre() == "Stage")
                    $menu[] = array("image" => "../ressources/images/document.png", "label" => "Remplir ma convention"
                    , "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionStage");
                else if ($offre->getTypeOffre() == "Alternance")
                    $menu[] = array("image" => "../ressources/images/document.png", "label" => "Ma convention alternance", "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionAlternance");
            }
        } else if ($offre!= false && $offre->getDateCreationConvention() != null) {
            $menu[] = array("image" => "../ressources/images/document.png", "label" => "Ma convention", "lien" => "?controleur=EtuMain&action=afficherMaConvention");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter&controleur=Main");
        return $menu;
    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour un étudiant
     */
    public static function afficherAccueilEtu(): void
    {
        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
        $listeIdOffres = self::getSixMax((new FormationRepository())->getListeIDFormationsPourEtudiant("all", $etudiant));
        $listeOffres = array();
        for ($i = 0; $i < sizeof($listeIdOffres); $i++) {
            $listeOffres[] = (new FormationRepository())->getObjectParClePrimaire($listeIdOffres[$i]);
        }
        self::$titrePageActuelleEtu = "Accueil Etudiants";
        self::afficherVue("Accueil Etudiants", "Etudiant/vueAccueilEtudiant.php", self::getMenu(), ["listeStage" => $listeOffres, "listeAlternance" => $listeOffres]);
    }

    /**
     * @return void affiche le catalogue des offres
     */
    public static function afficherCatalogue(): void
    {
        $type = $_REQUEST["type"] ?? "Tous";
        $offres = (new FormationRepository())->getListeOffresDispoParType($type);
        self::$titrePageActuelleEtu = "Offres de Stage/Alternance";
        self::afficherVue("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffres.php", self::getMenu(), ["offres" => $offres, "type" => $type]);
    }

    /**
     * @return void affiche le profil de l'étudiant connecté
     */
    public static function afficherProfil(): void
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::$titrePageActuelleEtu = "Mon Compte";
        self::afficherVue("Mon Compte", "Etudiant/vueCompteEtudiant.php", self::getMenu(), ["etudiant" => $etudiant]);
    }

    /**
     * @return void affiche les offres concernées par l'étudiant connecté
     */
    public static function afficherMesOffres(): void
    {
        $listOffre = (new FormationRepository())->listeOffresEtu(self::getCleEtudiant());
        self::$titrePageActuelleEtu = "Mes Offres";
        self::afficherVue("Mes Offres", "Etudiant/vueMesOffresEtu.php", self::getMenu(), ["listOffre" => $listOffre, "numEtu" => self::getCleEtudiant()]);
    }

    /**
     * @return void affiche la convention de l'étudiant connecté
     */
    public static function afficherMaConvention(): void
    {
        $offre = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());

        if ($offre != false && $offre->getDateCreationConvention() != null) {

            $offre = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            $entreprise = (new EntrepriseRepository())->trouverEntrepriseDepuisForm(self::getCleEtudiant());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
          //$convention = (new FormationRepository())->trouverConventionDepuisForm(self::getCleEtudiant());
            self::afficherVue("Ma convention", "Etudiant/vueAfficherConvention.php", self::getMenu(),
                ["etudiant" => $etudiant, "entreprise" => $entreprise, "villeEntr" => $villeEntr,
                    "offre" => $offre]);
        } else {
            self::redirectionFlash("afficherAccueilEtu", "danger", "Vous ne possèdez pas de convention");
        }
    }

    /**
     * @return void affiche le formulaire de convention de stage
     */
    public static function afficherFormulaireConventionStage(): void
    {
        $offre = (new FormationRepository())->trouverOffreValide(self::getCleEtudiant(), "Stage");
        if (is_null($offre)) {
            self::afficherErreur("offre non valide");
        } else {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            self::afficherVue("Convention Stage", "Etudiant/vueFormulaireConventionStage.php", self::getMenu(), ["etudiant" => $etudiant,  "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
        }
    }

    /**
     * @return void affiche le formulaire de convention d'alternance
     */
    public static function afficherFormulaireConventionAlternance(): void
    {
//        $offreVerif = (new PostulerRepository())->getOffreValider(self::self::getCleEtudiant());
        $offre = (new FormationRepository())->trouverOffreValide(self::getCleEtudiant(), "Alternance");
        if ($offre) {

            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            self::afficherVue("Convention Alternance", "Etudiant/vueFormulaireConventionAlternance.php", self::getMenu(), ["etudiant" => $etudiant, "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
        } else {
            self::afficherErreur("offre non valide");
        }
    }

    /**
     * @return void affiche le formulaire de modification de l'étudiant connecté
     */
    public static function afficherFormulaireModification(): void
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::afficherVue("Modifier vos informations", "Etudiant/vueMettreAJour.php", self::getMenu(), ["etudiant" => $etudiant]);
    }

    /**
     * @param string|null $idFormation l'id de la formation dont on affiche le detail
     * @return void affiche le détail d'une offre
     */

    public static function afficherVueDetailOffre(string $idFormation = null): void
    {
        if (!isset($_REQUEST['idFormation']) && is_null($idFormation))
            self::afficherErreur("Il faut préciser la formation");
        $anneeEtu = (new EtudiantRepository())->getAnneeEtudiant((new EtudiantRepository())->getObjectParClePrimaire(ControleurEtuMain::getCleEtudiant()));
        $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
        if (($anneeEtu >= $offre->getAnneeMin()) && $anneeEtu <= $offre->getAnneeMax()) {
            if ($offre->getEstValide()) {
                self::$titrePageActuelleEtu = "Détails de l'offre";
                /** @var ControleurMain $menu */
                $menu = Configuration::getCheminControleur();
                $liste = (new FormationRepository())->getListeidFormations();
                if ($idFormation || isset($_REQUEST["idFormation"])) {
                    if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
                    if (in_array($idFormation, $liste)) {
                        $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                        $client = "Etudiant";
                        $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                        self::afficherVue("Détails de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
                    } else {
                        self::redirectionFlash("afficherPageConnexion", "danger", "Cette offre n'existe pas");
                    }
                } else {
                    self::redirectionFlash("afficherPageConnexion", "danger", "L'offre n'est pas renseignée");
                }
            } else {
                self::redirectionFlash("afficherCatalogue", "danger", "Vous n'avez pas le droit de voir cette offre");
            }
        } else {
            self::redirectionFlash("afficherCatalogue", "danger", "Vous n'avez pas le droit de voir cette offre");
        }
    }

    //APPELS AUX SERVICES -------------------------------------------------------------------------------------------------------------------------------------------------

    public static function postuler(): void{
        ServicePostuler::postuler();
    }

    public static function mettreAJour(): void{
        ServiceEtudiant::mettreAJour();
    }
    public static function creerConvention(): void{
        ServiceConvention::creerConvention();
    }

    public static function modifierFichiers(): void{
        ServiceFichier::modifierFichiers();
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void met à jour l'image de profil d'un étudiant
     */
    public static function updateImage(): void
    {
        //si un fichier a été passé en paramètre
        if (!empty($_FILES['pdp']['name'])) {
            //TODO vérif de doublons d'image
            $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
            $nom = "";
            $nomEtudiant = $etudiant->getLogin();
            for ($i = 0; $i < strlen($etudiant->getLogin()); $i++) {
                if ($nomEtudiant[$i] == ' ') {
                    $nom .= "_";
                } else {
                    $nom .= $nomEtudiant[$i];
                }
            }
            $nom .= "_logo";

            $ancienneImage = (new UploadsRepository())->imageParEtudiant(self::getCleEtudiant());

            $ai_id = TransfertImage::transfert();

            $etu = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            $etu->setImg($ai_id);
            (new EtudiantRepository())->modifierObjet($etu);

            if ($ancienneImage["img_id"] != 1 && $ancienneImage["img_id"] != 0) (new UploadsRepository())->supprimer($ancienneImage["img_id"]);

            if (isset($_REQUEST['estPremiereCo'])) {
                self::redirectionFlash("afficherAccueilEtu", "success", "Informations enregistrées");
            } else {
                self::redirectionFlash("afficherProfil", "success", "Image modifiée");
            }
        } else {
            if (isset($_REQUEST['estPremiereCo'])) {
                self::redirectionFlash("afficherAccueilEtu", "success", "Informations enregistrées");
            } else {
                self::redirectionFlash("afficherProfil", "warning", "Aucune image selectionnée");
            }
        }
    }

    /**
     * @return void
     */
    public static function ajouterDansMenu(): void
    {
        self::updateImage();
        self::redirectionFlash("afficherAcueilEtu", "success", "Informations enregistrées");
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
