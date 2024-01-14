<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Modele\Repository\ConventionEtat;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use App\FormatIUT\Service\ServiceConvention;
use App\FormatIUT\Service\ServiceEtudiant;
use App\FormatIUT\Service\ServiceFichier;
use App\FormatIUT\Service\ServicePostuler;

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
        $convention = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
        self::$titrePageActuelleEtu = "Accueil Etudiants";
        self::afficherVue("Accueil Etudiants", "Etudiant/vueAccueilEtudiant.php", [
            "listeStage" => $listeOffres,
            "listeAlternance" => $listeOffres,
            "convention" => $convention,
        ]);
    }

    /**
     * @return void affiche le catalogue des offres
     */
    public static function afficherCatalogue(): void
    {
        $type = $_REQUEST["type"] ?? "Tous";
        $offres = (new FormationRepository())->getListeOffresDispoParType($type);
        self::$titrePageActuelleEtu = "Offres de Stage/Alternance";
        self::afficherVue("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffres.php", ["offres" => $offres, "type" => $type]);
    }

    /**
     * @return void affiche le profil de l'étudiant connecté
     */
    public static function afficherProfil(): void
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::$titrePageActuelleEtu = "Mon Compte";
        self::afficherVue("Mon Compte", "Etudiant/vueCompteEtudiant.php", ["etudiant" => $etudiant]);
    }

    /**
     * @return void affiche les offres concernées par l'étudiant connecté
     */
    public static function afficherMesOffres(): void
    {
        $listOffre = (new FormationRepository())->listeOffresEtu(self::getCleEtudiant());
        self::$titrePageActuelleEtu = "Mes Offres";
        self::afficherVue("Mes Offres", "Etudiant/vueMesOffresEtu.php", ["listOffre" => $listOffre, "numEtu" => self::getCleEtudiant()]);
    }

    /**
     * @return void affiche la convention de l'étudiant connecté
     */
    public static function afficherMaConvention(): void
    {
        $offre = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());

        if (ConnexionUtilisateur::getTypeConnecte() == "Etudiants" && $offre != null && $offre != false && $offre->getDateCreationConvention() != null) {

            $offre = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            $entreprise = (new EntrepriseRepository())->trouverEntrepriseDepuisForm(self::getCleEtudiant());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            //$convention = (new FormationRepository())->trouverConventionDepuisForm(self::getCleEtudiant());
            self::afficherVue("Ma convention", "Etudiant/vueConvention.php", [
                "etudiant" => $etudiant,
                "entreprise" => $entreprise,
                "villeEntr" => $villeEntr,
                "offre" => $offre,
                "etat" => ConventionEtat::VisuEtudiant
            ]);
        } else {
            self::redirectionFlash("afficherAccueilEtu", "danger", "Vous ne possèdez pas de convention");
        }
    }

    /**
     * @return void affiche le formulaire de convention (alternance / stage)
     */
    public static function afficherFormulaireConvention(): void
    {
        $offre = (new FormationRepository())->trouverFormationValidee(self::getCleEtudiant());
        if (is_null($offre)) {
            self::redirectionFlash("afficherAccueilEtu", "danger", "Vous n'avez pas d'offre de stage");
            return;
        }
        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
        $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
        self::afficherVue("Remplir ma convention", "Etudiant/vueConvention.php", [
            "etudiant" => $etudiant,
            "offre" => $offre,
            "entreprise" => $entreprise,
            "villeEntr" => $villeEntr,
            "etat" => ConventionEtat::Creation
        ]);
    }

    /**
     * @return void affiche le formulaire pour modifier la convention de l'étudiant
     */
    public static function afficherFormulaireModifierConvention(): void
    {
        $formation = (new FormationRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
        if ($formation->getDateCreationConvention() != null) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($formation->getIdEntreprise());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            self::afficherVue("Modifier Convention", "Etudiant/vueConvention.php", [
                "etudiant" => $etudiant,
                "offre" => $formation,
                "entreprise" => $entreprise,
                "villeEntr" => $villeEntr,
                "etat" => ConventionEtat::Modification
            ]);
        } else {
            self::afficherErreur("Convention inexistante");
        }
    }

    /**
     * @return void affiche le formulaire de modification de l'étudiant connecté
     */
    public static function afficherFormulaireModification(): void
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::afficherVue("Modifier vos informations", "Etudiant/vueMettreAJour.php", ["etudiant" => $etudiant]);
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
                $liste = (new FormationRepository())->getListeidFormations();
                if ($idFormation || isset($_REQUEST["idFormation"])) {
                    if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
                    if (in_array($idFormation, $liste)) {
                        $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                        $client = "Etudiant";
                        $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                        self::afficherVue("Détails de l'offre", $chemin, ["offre" => $offre, "entreprise" => $entreprise]);
                    } else {
                        self::redirectionFlash("afficherCatalogue", "danger", "Cette offre n'existe pas");
                    }
                } else {
                    self::redirectionFlash("afficherCatalogue", "danger", "L'offre n'est pas renseignée");
                }
            } else {
                self::redirectionFlash("afficherCatalogue", "danger", "Vous n'avez pas le droit de voir cette offre");
            }
        } else {
            self::redirectionFlash("afficherCatalogue", "danger", "Vous n'avez pas le droit de voir cette offre");
        }
    }

    /**
     * @return void renvoie sur le formulaire convention une entreprise n'est pas inscrite sur le site
     */
    public static function afficherFormulaireConventionSansEntreprise()
    {
        $formation = (new FormationRepository())->getObjectParClePrimaire(self::getCleEtudiant());
        if ($formation == null && ConnexionUtilisateur::getTypeConnecte() == "Etudiants") {
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            self::afficherVue("Remplir convention", "Etudiant/vueFormulaireCreationConventionQuandPasEntreprise.php", ['etudiant' => $etudiant]);
        } else {
            self::redirectionFlash("afficherAccueilEtu", "warning", "Vous avez déjà une formation");
        }
    }

    //APPELS AUX SERVICES -------------------------------------------------------------------------------------------------------------------------------------------------

    public static function postuler(): void
    {
        ServicePostuler::postuler();
    }

    public static function mettreAJour(): void
    {
        ServiceEtudiant::mettreAJour();
    }

    public static function creerConvention(): void
    {
        ServiceConvention::creerConvention();
    }

    public static function modifierConvention(): void
    {
        ServiceConvention::modifierConvention();
    }

    public static function modifierFichiers(): void
    {
        ServiceFichier::modifierFichiers();
    }

    public static function faireValiderConvention(): void
    {
        ServiceConvention::faireValiderConvention();
    }

    public static function creerConventionSansEntreprise(): void
    {
        ServiceConvention::creerConventionSansEntreprise();
    }

    public static function annulerOffre(): void
    {
        ServicePostuler::annulerOffre();
    }

    public static function validerOffre(): void
    {
        ServicePostuler::validerOffre();
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void met à jour l'image de profil d'un étudiant
     */
    public static function updateImage(): void
    {
        //si un fichier a été passé en paramètre
        if (!empty($_FILES['pdp']['name'])) {

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
            }
        } else {
            if (isset($_REQUEST['estPremiereCo'])) {
                self::redirectionFlash("afficherAccueilEtu", "success", "Informations enregistrées");
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
