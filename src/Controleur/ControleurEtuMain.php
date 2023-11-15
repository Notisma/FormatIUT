<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\DataObject\studea;
use App\FormatIUT\Modele\Repository\ConventionRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\Repository\pstageRepository;
use App\FormatIUT\Modele\Repository\RegarderRepository;
use App\FormatIUT\Modele\Repository\ResidenceRepository;
use App\FormatIUT\Modele\Repository\StudeaRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;

class ControleurEtuMain extends ControleurMain
{
    private static int $cleEtudiant = 321444;

    public static function getCleEtudiant(): int
    {
        return self::$cleEtudiant;
    }

    public static function afficherAccueilEtu()
    {
        $listeIdAlternance = self::getTroisMax((new OffreRepository())->ListeIdTypeOffre("Alternance"));
        $listeIdStage = self::getTroisMax((new OffreRepository())->ListeIdTypeOffre("Stage"));
        $listeStage = array();
        for ($i = 0; $i < sizeof($listeIdStage); $i++) {
            $listeStage[] = (new OffreRepository())->getObjectParClePrimaire($listeIdStage[$i]);
        }
        $listeAlternance = array();
        for ($i = 0; $i < sizeof($listeIdAlternance); $i++) {
            $listeAlternance[] = (new OffreRepository())->getObjectParClePrimaire($listeIdAlternance[$i]);
        }
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Etudiant/vueAccueilEtudiant.php", "titrePage" => "Accueil Etudiants", "listeStage" => $listeStage, "listeAlternance" => $listeAlternance]);
    }

    public static function afficherCatalogue()
    {
        $type = $_GET["type"] ?? "Tous";
        $offres = (new OffreRepository())->getListeOffresDispoParType($type);
        self::afficherVueDansCorps("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffre.php", self::getMenu(), ["offres" => $offres, "type" => $type]);
    }

    public static function afficherProfilEtu()
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant));
        self::afficherVue("vueGenerale.php", ["etudiant" => $etudiant, "menu" => self::getMenu(), "chemin" => "Etudiant/vueCompteEtudiant.php", "titrePage" => "Compte étudiant"]);
    }

    public static function afficherMesOffres()
    {
        $listOffre = (new OffreRepository())->listOffreEtu(self::$cleEtudiant);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Etudiant/vueMesOffresEtu.php", "menu" => self::getMenu(), "listOffre" => $listOffre, "numEtu" => self::$cleEtudiant]);
    }

    public static function annulerOffre()
    {
        if (isset($_GET["idOffre"])) {
            $listeId = ((new OffreRepository())->getListeIdOffres());
            if (in_array($_GET["idOffre"], $listeId)) {
                if ((new EtudiantRepository())->aPostuler(self::$cleEtudiant, $_GET["idOffre"])) {
                    (new RegarderRepository())->supprimerOffreEtudiant(self::$cleEtudiant, $_GET['idOffre']);
                    self::afficherMesOffres();
                } else {
                    self::afficherErreur("L'étudiant n'a jamais posutlé à cette offre");
                }
            } else {
                self::afficherErreur("L'offre n'existe pas");
            }
        } else {
            self::afficherErreur("Données manquantes");
        }
    }

    public static function validerOffre()
    {
        if (isset($_GET['idOffre'])) {
            $listeId = ((new OffreRepository())->getListeIdOffres());
            $idOffre = $_GET['idOffre'];
            if (in_array($idOffre, $listeId)) {
                $formation = ((new FormationRepository())->estFormation($idOffre));
                if (!(new EtudiantRepository())->aUneFormation(self::$cleEtudiant)) {
                    if (is_null($formation)) {
                        if ((new RegarderRepository())->getEtatEtudiantOffre(self::$cleEtudiant, $idOffre) == "A Choisir") {
                            (new RegarderRepository())->validerOffreEtudiant(self::$cleEtudiant, $idOffre);
                            $offre = ((new OffreRepository())->getObjectParClePrimaire($idOffre));
                            $idFormation = "F" . self::autoIncrementF(((new FormationRepository())->ListeIdTypeFormation()), "idFormation");
                            $formation = (new FormationRepository())->construireDepuisTableau(["idFormation" => $idFormation, "dateDebut" => date_format($offre->getDateDebut(), "Y-m-d"), "dateFin" => date_format($offre->getDateFin(), 'Y-m-d'), "idEtudiant" => self::$cleEtudiant, "idEntreprise" => $offre->getSiret(), "idOffre" => $idOffre, "idTuteurPro" => null, "idConvention" => null, "idTuteurUM" => null]);
                            (new FormationRepository())->creerObjet($formation);
                            self::afficherMesOffres();
                        } else {
                            self::afficherErreur("Vous n'êtes pas en état de choisir pour cette offre");
                        }
                    } else {
                        self::afficherErreur("Cette Offre est déjà assignée");
                    }
                } else {
                    self::afficherErreur("Vous avez déjà une Offre assignée");
                }
            } else {
                self::afficherErreur("Offre non existante");
            }
        } else {
            self::afficherErreur("Données Manquantes");
        }
    }

    /* public static function annulerOffre(){
         (new RegarderRepository())->supprimerOffreEtudiant(self::$cleEtudiant, $_GET['idOffre']);
         self::afficherMesOffres();
     }*/

    public static function postuler()
    {
        //TODO vérifier les vérifs
        if (isset($_GET['idOffre'])) {
            $liste = ((new OffreRepository())->getListeIdOffres());
            if (in_array($_GET["idOffre"], $liste)) {
                $formation = ((new FormationRepository())->estFormation($_GET['idOffre']));
                if (is_null($formation)) {
                    if (!(new EtudiantRepository())->aUneFormation(self::$cleEtudiant)) {
                        if ((new EtudiantRepository())->aPostuler(self::$cleEtudiant, $_GET['idOffre'])) {
                            self::afficherErreur("Vous avez déjà postulé");
                        } else {
                            (new EtudiantRepository())->EtudiantPostuler(self::$cleEtudiant, $_GET['idOffre']);
                            $_GET['action'] = "afficherVueDetailOffre";
                            self::afficherVueDetailOffre();
                        }
                    } else {
                        self::afficherErreur("Vous avez déjà une formation");
                    }
                } else {
                    if ($formation->getIdEtudiant() == self::getCleEtudiant()) {
                        self::afficherErreur("Vous avez déjà cette Formation");
                    } else {
                        self::afficherErreur("Cette offre est déjà assignée");
                    }
                }
            } else {
                self::afficherErreur("Offre inexistante");
            }
        } else {
            self::afficherErreur("Données Manquantes");
        }
    }

    public static function afficherImporterCSV(): void
    {
        self::afficherVueDansCorps("importer CSV", "Etudiant/vueImportCSV.php", self::getMenu());
    }

    public static function afficherExporterCSV(){
        self::afficherVueDansCorps("exporter CSV", "Etudiant/vueExportCSV.php", self::getMenu());
    }

    public static function ajouterCSV(): void
    {

        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        fgetcsv($csvFile);

        while (($ligne = fgetcsv($csvFile)) !== FALSE) {
            if (sizeof($ligne) == 82) {
                $pstage = (new pstageRepository())->construireDepuisTableau($ligne);
                (new pstageRepository())->callProcedure($pstage);
            }
            else if (sizeof($ligne) == 143){
                $studea = (new StudeaRepository())->construireDepuisTableau($ligne);
                (new StudeaRepository())->callProcedure($studea);
            }
        }
        fclose($csvFile);

        self::afficherAccueilEtu();
    }

    public static function exporterCSV(){
        $tab = (new pstageRepository())->exportCSV();

        $delimiter = ",";
        $filename = "sae-data_" . date('Y-m-d') . ".csv";
        $f = fopen('php://memory', 'w');

        $champs = array('numEtudiant', 'prenomEtudiant', 'nomEtudiant', 'sexeEtu', 'mailUniversitaire', 'mailPerso', 'telephone', 'groupe', 'parcours', 'nomOffre', 'sujet');
        fputcsv($f, $champs, $delimiter);

        foreach ($tab as $ligne){

            fputcsv($f, $ligne, $delimiter);
        }
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
        fclose($f);
    }

    public static function updateImage()
    {
        $id = self::autoIncrement((new ImageRepository())->listeID(), "img_id");
        //TODO vérif de doublons d'image
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant));
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
        $estPasse = parent::insertImage($nom);
        if (!$estPasse) self::afficherProfilEtu();
        $ancienId = (new ImageRepository())->imageParEtudiant(self::$cleEtudiant);
        (new EtudiantRepository())->updateImage(self::$cleEtudiant, $id);
        if ($ancienId["img_id"] != 1 && $ancienId["img_id"] != 0) (new ImageRepository())->supprimer($ancienId["img_id"]);
        self::afficherProfilEtu();
    }

    public static function getMenu(): array
    {
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Etudiants", "lien" => "?action=afficherAccueilEtu&controleur=EtuMain"),
            //array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/stage.png", "label" => "Offres de Stage/Alternance", "lien" => "?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/signet.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&controleur=EtuMain"),

        );
        $convention = (new ConventionRepository())->aUneConvention(self::$cleEtudiant);
        if (!$convention) {
            $offreValidee = (new RegarderRepository())->getOffreValider(self::$cleEtudiant);
            if ($offreValidee) {
                $offre = (new OffreRepository())->getObjectParClePrimaire($offreValidee->getIdOffre());
                if ($offre->getTypeOffre() == "Stage")
                    $menu[] = array("image" => "", "label" => "Ma convention stage", "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionStage");
                else if ($offre->getTypeOffre() == "Alternance")
                    $menu[] = array("image" => "", "label" => "Ma convention alternance", "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionAlternance");
            }
        } else {
            $menu[] = array("image" => "", "label" => "Ma convention", "lien" => "?controleur=EtuMain&action=afficherMaConvention");
        }

        $formation = (new EtudiantRepository())->aUneFormation(self::$cleEtudiant);
        if ($formation) {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idOffre=" . $formation['idOffre']);
        }
        $menu[] = array("image" => "", "label" => "importer CSV", "lien" => "?controleur=EtuMain&action=afficherImporterCSV");
        $menu[] = array("image"=>"", "label"=>"exporter CSV", "lien"=> "?controleur=EtuMain&action=afficherExporterCSV");
        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php");
        return $menu;
    }

    public static function afficherMaConvention(): void
    {
        $convention = (new ConventionRepository())->aUneConvention(self::$cleEtudiant);
        if ($convention) {
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant);
            $residenceEtu = (new ResidenceRepository())->getResidenceParEtu(self::$cleEtudiant);
            $villeEtu = (new VilleRepository())->getVilleParIdResidence($residenceEtu->getIdResidence());
            $entreprise = (new EntrepriseRepository())->trouverEntrepriseDepuisForm(self::$cleEtudiant);
            $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entreprise->getSiret());
            $offre = (new OffreRepository())->trouverOffreDepuisForm(self::$cleEtudiant);
            $convention = (new ConventionRepository())->trouverConventionDepuisForm(self::$cleEtudiant);
            self::afficherVueDansCorps("Ma convention", "Etudiant/afficherConvention.php", self::getMenu(),
                ["etudiant" => $etudiant, "residenceEtu" => $residenceEtu, "villeEtu" => $villeEtu, "entreprise" => $entreprise, "villeEntr" => $villeEntr,
                    "offre" => $offre, "convention" => $convention]);
        } else {
            self::afficherErreur("Ne possède pas de convention");
        }
    }

    public static function afficherFormulaireConventionStage(): void
    {


        $offre = (new OffreRepository())->trouverOffreValide(self::$cleEtudiant, "Stage");
        if ($offre) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant);
            $residence = (new ResidenceRepository())->getResidenceParEtu(self::$cleEtudiant);
            $ville = (new VilleRepository())->getVilleParIdResidence($residence->getIdResidence());
            self::afficherVueDansCorps("Convention Stage", "Etudiant/formConventionStage.php", self::getMenu(), ["etudiant" => $etudiant, "residence" => $residence, "ville" => $ville, "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
        } else {
            self::afficherErreur("offre non valide");
        }
    }

    public static function afficherFormulaireConventionAlternance(): void
    {
//        $offreVerif = (new RegarderRepository())->getOffreValider(self::$cleEtudiant);
        $offre = (new OffreRepository())->trouverOffreValide(self::$cleEtudiant, "Alternance");
        if ($offre) {

            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant);
            $residence = (new ResidenceRepository())->getResidenceParEtu(self::$cleEtudiant);
            $ville = (new VilleRepository())->getVilleParIdResidence($residence->getIdResidence());
            self::afficherVueDansCorps("Convention Alternance", "Etudiant/formConventionAlternance.php", self::getMenu(), ["etudiant" => $etudiant, "residence" => $residence, "ville" => $ville, "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
        } else {
            self::afficherErreur("offre non valide");
        }
    }


    public static function creationConvention()
    {
        if ($_POST['idOff'] != "aucune") {
            if ($_POST['codePostalEntr'] > 0 && $_POST['siret'] > 0) {
                $entrepriseVerif = (new EntrepriseRepository())->getObjectParClePrimaire($_POST['siret']);
                if (isset($entrepriseVerif)) {
                    $offreVerif = (new OffreRepository())->getObjectParClePrimaire($_POST['idOff']);
                    if ($entrepriseVerif->getSiret() == $offreVerif->getSiret()) {
                        $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entrepriseVerif->getSiret());
                        if ((trim($entrepriseVerif->getNomEntreprise()) == trim($_POST['nomEntreprise'])) && (trim($entrepriseVerif->getAdresse()) == trim($_POST['adresseEntr'])) && (trim($villeEntr->getNomVille()) == trim($_POST['villeEntr'])) && ($villeEntr->getCodePostal() == $_POST['codePostalEntr'])) {
                            if ($offreVerif->getDateDebut() == new \DateTime($_POST['dateDebut']) && $offreVerif->getDateFin() == new \DateTime($_POST['dateFin'])) {
                                $clefPrimConv = 'C' . (new ConventionRepository())->getNbConvention() + 1;
                                $convention = (new ConventionRepository())->construireDepuisTableau(["idConvention" => $clefPrimConv,
                                    "conventionValidee" => 0, "dateCreation" => $_POST['dateCreation'], "dateTransmission" => $_POST['dateCreation'],
                                    "retourSigne" => 1, "assurance" => $_POST['assurance'], "objectifOffre" => $_POST['objfOffre'], "typeConvention" => $offreVerif->getTypeOffre()]);
                                (new ConventionRepository())->creerObjet($convention);
                                if (!(new EtudiantRepository())->aUneFormation(self::$cleEtudiant)) {
                                    $formation = (new FormationRepository())->construireDepuisTableau(['idFormation' => ('F' . $offreVerif->getIdOffre()), "dateDebut" => date_format($offreVerif->getDateDebut(), "Y-m-d"),
                                        "dateFin" => date_format($offreVerif->getDateFin(), "Y-m-d"), "idEtudiant" => self::$cleEtudiant, "idTuteurPro" => null, "idEntreprise" => $entrepriseVerif->getSiret(), "idConvention" => $convention->getIdConvention(), "idTuteurUM" => null,
                                        "idOffre" => $offreVerif->getIdOffre()]);
                                    (new FormationRepository())->creerObjet($formation);
                                } else {
                                    (new FormationRepository())->ajouterConvention(self::$cleEtudiant, $convention->getIdConvention());
                                }
                                self::afficherAccueilEtu();
                            } else {
                                self::afficherErreur("Erreur sur les dates");
                            }
                        } else {
                            self::afficherErreur("Erreur sur les informations de l'entreprise");
                        }
                    } else {
                        self::afficherErreur("L'entreprise n'a jamais créé cette offre");
                    }
                } else {
                    self::afficherErreur("Erreur l'entreprise n'existe pas");
                }
            } else {
                self::afficherErreur("Erreur nombre(s) négatif(s) présent(s)");
            }
        } else {
            self::afficherErreur("Aucune offre est liée à votre convention");
        }
    }


}