<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Modele\DataObject\Postuler;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\ConventionRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Modele\Repository\ResidenceRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
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
        if ($formation) {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=" . $formation['idFormation']);
        }
        if (self::$titrePageActuelleEtu == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfil&controleur=EtuMain");
        }

        $convention = (new ConventionRepository())->aUneConvention(self::getCleEtudiant());
        if (!$convention) {
            $offreValidee = (new PostulerRepository())->getOffreValider(self::getCleEtudiant());
            if ($offreValidee) {
                $offre = (new FormationRepository())->getObjectParClePrimaire($offreValidee->getidFormation());
                if ($offre->getTypeOffre() == "Stage")
                    $menu[] = array("image" => "", "label" => "Ma convention stage", "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionStage");
                else if ($offre->getTypeOffre() == "Alternance")
                    $menu[] = array("image" => "", "label" => "Ma convention alternance", "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionAlternance");
            }
        } else {
            $menu[] = array("image" => "", "label" => "Ma convention", "lien" => "?controleur=EtuMain&action=afficherMaConvention");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter&service=Connexion");
        return $menu;
    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour un étudiant
     */
    public static function afficherAccueilEtu(): void
    {
        $listeIdAlternance = self::getTroisMax((new FormationRepository())->listeIdTypeOffre("Alternance"));
        $listeIdStage = self::getTroisMax((new FormationRepository())->listeIdTypeOffre("Stage"));
        $listeStage = array();
        for ($i = 0; $i < sizeof($listeIdStage); $i++) {
            $listeStage[] = (new FormationRepository())->getObjectParClePrimaire($listeIdStage[$i]);
        }
        $listeAlternance = array();
        for ($i = 0; $i < sizeof($listeIdAlternance); $i++) {
            $listeAlternance[] = (new FormationRepository())->getObjectParClePrimaire($listeIdAlternance[$i]);
        }
        self::$titrePageActuelleEtu = "Accueil Etudiants";
        self::afficherVue("Accueil Etudiants", "Etudiant/vueAccueilEtudiant.php", self::getMenu(), ["listeStage" => $listeStage, "listeAlternance" => $listeAlternance]);
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
        $convention = (new ConventionRepository())->aUneConvention(self::getCleEtudiant());
        if ($convention) {
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            $residenceEtu = (new ResidenceRepository())->getResidenceParEtu(self::getCleEtudiant());
            $villeEtu = false;
            if ($residenceEtu) {
                $villeEtu = (new VilleRepository())->getVilleParIdResidence($residenceEtu->getIdResidence());
            }
            $entreprise = (new EntrepriseRepository())->trouverEntrepriseDepuisForm(self::getCleEtudiant());
            $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entreprise->getSiret());
            $offre = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
            $convention = (new ConventionRepository())->trouverConventionDepuisForm(self::getCleEtudiant());
            self::afficherVue("Ma convention", "Etudiant/vueAfficherConvention.php", self::getMenu(),
                ["etudiant" => $etudiant, "residenceEtu" => $residenceEtu, "villeEtu" => $villeEtu, "entreprise" => $entreprise, "villeEntr" => $villeEntr,
                    "offre" => $offre, "convention" => $convention]);
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
            $residence = (new ResidenceRepository())->getResidenceParEtu(self::getCleEtudiant());
            $ville = false;
            if ($residence) {
                $ville = (new VilleRepository())->getVilleParIdResidence($residence->getIdResidence());
            }
            self::afficherVue("Convention Stage", "Etudiant/vueFormulaireConventionStage.php", self::getMenu(), ["etudiant" => $etudiant, "residence" => $residence, "ville" => $ville, "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
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
            $residence = (new ResidenceRepository())->getResidenceParEtu(self::getCleEtudiant());
            $ville = false;
            if ($residence) {
                $ville = (new VilleRepository())->getVilleParIdResidence($residence->getIdResidence());
            }
            self::afficherVue("Convention Alternance", "Etudiant/vueFormulaireConventionAlternance.php", self::getMenu(), ["etudiant" => $etudiant, "residence" => $residence, "ville" => $ville, "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
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
        header("Location : ?controleur=EtuMain&action=$action");
    }

}
