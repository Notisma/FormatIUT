<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\CV;
use App\FormatIUT\Modele\DataObject\LM;
use App\FormatIUT\Modele\DataObject\Postuler;
use App\FormatIUT\Modele\Repository\CVRepository;
use App\FormatIUT\Configuration\ConfigurationLdap;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Lib\InsertionCSV;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\DataObject\studea;
use App\FormatIUT\Modele\Repository\ConventionRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\LMRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\Repository\pstageRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Modele\Repository\ResidenceRepository;
use App\FormatIUT\Modele\Repository\StudeaRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;

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
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idOffre=" . $formation['idOffre']);
        }
        if (self::$titrePageActuelleEtu == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilEtu&controleur=EtuMain");
        }

        $convention = (new ConventionRepository())->aUneConvention(self::getCleEtudiant());
        if (!$convention) {
            $offreValidee = (new PostulerRepository())->getOffreValider(self::getCleEtudiant());
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

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter");
        return $menu;
    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour un étudiant
     */
    public static function afficherAccueilEtu()
    {
        $listeIdAlternance = self::getTroisMax((new OffreRepository())->listeIdTypeOffre("Alternance"));
        $listeIdStage = self::getTroisMax((new OffreRepository())->listeIdTypeOffre("Stage"));
        $listeStage = array();
        for ($i = 0; $i < sizeof($listeIdStage); $i++) {
            $listeStage[] = (new OffreRepository())->getObjectParClePrimaire($listeIdStage[$i]);
        }
        $listeAlternance = array();
        for ($i = 0; $i < sizeof($listeIdAlternance); $i++) {
            $listeAlternance[] = (new OffreRepository())->getObjectParClePrimaire($listeIdAlternance[$i]);
        }
        self::$titrePageActuelleEtu = "Accueil Etudiants";
        self::afficherVue("Accueil Etudiants", "Etudiant/vueAccueilEtudiant.php", self::getMenu(), ["listeStage" => $listeStage, "listeAlternance" => $listeAlternance]);
    }

    /**
     * @return void affiche le catalogue des offres
     */
    public static function afficherCatalogue()
    {
        $type = $_REQUEST["type"] ?? "Tous";
        $offres = (new OffreRepository())->getListeOffresDispoParType($type);
        self::$titrePageActuelleEtu = "Offres de Stage/Alternance";
        self::afficherVue("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffres.php", self::getMenu(), ["offres" => $offres, "type" => $type]);
    }

    /**
     * @return void affiche le profil de l'étudiant connecté
     */
    public static function afficherProfilEtu()
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::$titrePageActuelleEtu = "Mon Compte";
        self::afficherVue("Mon Compte", "Etudiant/vueCompteEtudiant.php", self::getMenu(), ["etudiant" => $etudiant]);
    }

    /**
     * @return void affiche les offres concernées par l'étudiant connecté
     */
    public static function afficherMesOffres()
    {
        $listOffre = (new OffreRepository())->listeOffresEtu(self::getCleEtudiant());
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
            if ($residenceEtu != false) {
                $villeEtu = (new VilleRepository())->getVilleParIdResidence($residenceEtu->getIdResidence());
            }
            $entreprise = (new EntrepriseRepository())->trouverEntrepriseDepuisForm(self::getCleEtudiant());
            $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entreprise->getSiret());
            $offre = (new OffreRepository())->trouverOffreDepuisForm(self::getCleEtudiant());
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
        $offre = (new OffreRepository())->trouverOffreValide(self::getCleEtudiant(), "Stage");
        if ($offre) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            $residence = (new ResidenceRepository())->getResidenceParEtu(self::getCleEtudiant());
            $ville = false;
            if ($residence != false) {
                $ville = (new VilleRepository())->getVilleParIdResidence($residence->getIdResidence());
            }
            self::afficherVue("Convention Stage", "Etudiant/vueFormulaireConventionStage.php", self::getMenu(), ["etudiant" => $etudiant, "residence" => $residence, "ville" => $ville, "offre" => $offre, "entreprise" => $entreprise, "villeEntr" => $villeEntr]);
        } else {
            self::afficherErreur("offre non valide");
        }
    }

    /**
     * @return void affiche le formulaire de convention d'alternance
     */
    public static function afficherFormulaireConventionAlternance(): void
    {
//        $offreVerif = (new PostulerRepository())->getOffreValider(self::self::getCleEtudiant());
        $offre = (new OffreRepository())->trouverOffreValide(self::getCleEtudiant(), "Alternance");
        if ($offre) {

            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
            $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant());
            $residence = (new ResidenceRepository())->getResidenceParEtu(self::getCleEtudiant());
            $ville = false;
            if ($residence != false) {
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

    //FONCTIONS D'ACTIONS ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void permet à l'étudiant connecté d'annuler sa postulation à une offre
     */
    public static function annulerOffre()
    {
        if (isset($_REQUEST["idOffre"])) {
            $listeId = ((new OffreRepository())->getListeIdOffres());
            if (in_array($_REQUEST["idOffre"], $listeId)) {
                if ((new EtudiantRepository())->aPostule(self::getCleEtudiant(), $_REQUEST["idOffre"])) {
                    (new PostulerRepository())->supprimerOffreEtudiant(self::getCleEtudiant(), $_REQUEST['idOffre']);
                    self::redirectionFlash("afficherMesOffres", "success", "Offre annulée");
                } else {
                    self::redirectionFlash("afficherMesOffres", "warning", "Vous n'avez pas postulé à cette offre");
                }
            } else {
                self::afficherErreur("L'offre n'existe pas");
                self::redirectionFlash("afficherMesOffres", "danger", "L'offre n'existe pas");
            }
        } else {
            self::redirectionFlash("afficherMesOffres", "danger", "Des données sont manquantes");
        }
    }

    /**
     * @return void permet à l'étudiant connecté de valider une offre
     */
    public static function validerOffre()
    {
        if (isset($_REQUEST['idOffre'])) {
            $listeId = ((new OffreRepository())->getListeIdOffres());
            $idOffre = $_REQUEST['idOffre'];
            if (in_array($idOffre, $listeId)) {
                $formation = ((new FormationRepository())->estFormation($idOffre));
                if (!(new EtudiantRepository())->aUneFormation(self::getCleEtudiant())) {
                    if (is_null($formation)) {
                        if ((new PostulerRepository())->getEtatEtudiantOffre(self::getCleEtudiant(), $idOffre) == "A Choisir") {
                            (new PostulerRepository())->validerOffreEtudiant(self::getCleEtudiant(), $idOffre);
                            $offre = ((new OffreRepository())->getObjectParClePrimaire($idOffre));
                            $idFormation = "F" . self::autoIncrementF(((new FormationRepository())->listeIdTypeFormation()), "idFormation");
                            $formation = (new FormationRepository())->construireDepuisTableau(["idFormation" => $idFormation, "dateDebut" => date_format($offre->getDateDebut(), "Y-m-d"), "dateFin" => date_format($offre->getDateFin(), 'Y-m-d'), "idEtudiant" => self::getCleEtudiant(), "idEntreprise" => $offre->getSiret(), "idOffre" => $idOffre, "idTuteurPro" => null, "idConvention" => null, "idTuteurUM" => null]);
                            (new FormationRepository())->creerObjet($formation);
                            self::redirectionFlash("afficherMesOffres", "success", "Offre validée");
                        } else {
                            self::redirectionFlash("afficherMesOffres", "danger", "Vous n'êtes pas en état de choisir pour cette offre");
                        }
                    } else {
                        self::redirectionFlash("afficherMesOffres", "danger", "Cette Offre est déjà assignée");
                    }
                } else {
                    self::redirectionFlash("afficherMesOffres", "danger", "Vous avez déjà une Offre assignée");
                }
            } else {
                self::redirectionFlash("afficherMesOffres", "danger", "Offre non existante");
            }
        } else {
            self::redirectionFlash("afficherMesOffres", "danger", "Des données sont manquantes");
        }
    }

    /**
     * @return void permet à l'utilisateur connecté de postuler à une offre
     */
    public static function postuler(): void
    {
        $anneeEtu = (new EtudiantRepository())->getAnneeEtudiant((new EtudiantRepository())->getObjectParClePrimaire(ControleurEtuMain::getCleEtudiant()));
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]);
        if (($anneeEtu >= $offre->getAnneeMin()) && $anneeEtu <= $offre->getAnneeMax()) {
            $cvData = null;
            $lmData = null;
            if ($_FILES["fic"]["tmp_name"] != null) {
                $cvData = file_get_contents($_FILES["fic"]["tmp_name"]);
            }
            if ($_FILES["ficLM"]["tmp_name"] != null) {
                $lmData = file_get_contents($_FILES["ficLM"]["tmp_name"]);
            }
            //TODO vérifier les vérifs
            if (isset($_REQUEST['idOffre'])) {
                $liste = ((new OffreRepository())->getListeIdOffres());
                if (in_array($_REQUEST["idOffre"], $liste)) {
                    $formation = ((new FormationRepository())->estFormation($_REQUEST['idOffre']));
                    if (is_null($formation)) {
                        if (!(new EtudiantRepository())->aUneFormation(self::getCleEtudiant())) {
                            if ((new EtudiantRepository())->aPostule(self::getCleEtudiant(), $_REQUEST['idOffre'])) {
                                self::redirectionFlash("afficherMesOffres", "warning", "Vous avez déjà postulé");
                            } else {
                                $postuler = new Postuler(self::getCleEtudiant(), $_REQUEST["idOffre"], "En attente", $cvData, $lmData);
                                (new PostulerRepository())->creerObjet($postuler);
                                $_REQUEST['action'] = "afficherMesOffres";
                                self::redirectionFlash("afficherMesOffres", "success", "Candidature effectuée");
                            }
                        } else {
                            self::redirectionFlash("afficherMesOffres", "danger", "Vous avez déjà une formation");
                        }
                    } else {
                        if ($formation->getIdEtudiant() == self::getCleEtudiant()) {
                            self::redirectionFlash("afficherMesOffres", "danger", "Vous avez déjà cette Formation");
                        } else {
                            self::redirectionFlash("afficherMesOffres", "danger", "Cette offre est déjà assignée");
                        }
                    }
                } else {
                    self::redirectionFlash("afficherMesOffres", "danger", "Offre inexistante");
                }
            } else {
                self::redirectionFlash("afficherMesOffres", "danger", "Données Manquantes");
            }
        } else {
            self::redirectionFlash("afficherMesOffres", "danger", "Vous ne pouvez pas postuler à cette offre");
        }
    }

    /**
     * @return void permet à l'étudiant connecté de créer sa convention
     * @throws \Exception
     */
    public static function   creationConvention()
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
                                if (!(new EtudiantRepository())->aUneFormation(self::getCleEtudiant())) {
                                    $formation = (new FormationRepository())->construireDepuisTableau(['idFormation' => ('F' . $offreVerif->getIdOffre()), "dateDebut" => date_format($offreVerif->getDateDebut(), "Y-m-d"),
                                        "dateFin" => date_format($offreVerif->getDateFin(), "Y-m-d"), "idEtudiant" => self::getCleEtudiant(), "idTuteurPro" => null, "idEntreprise" => $entrepriseVerif->getSiret(), "idConvention" => $convention->getIdConvention(), "idTuteurUM" => null,
                                        "idOffre" => $offreVerif->getIdOffre()]);
                                    (new FormationRepository())->creerObjet($formation);
                                } else {
                                    (new FormationRepository())->ajouterConvention(self::getCleEtudiant(), $convention->getIdConvention());
                                }
                                self::redirectionFlash("afficherAccueilEtu", "success", "Convention créée");
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

    /**
     * @return void modifie les Cv et Lettres de motivations de l'étudiant connecté pour une offre
     */
    public static function modifierFichiers()
    {
        $cvData = null;
        $lmData = null;
        if ($_FILES["fic"]["tmp_name"] != null) {
            $cvData = file_get_contents($_FILES["fic"]["tmp_name"]);
        }
        if ($_FILES["ficLM"]["tmp_name"] != null) {
            $lmData = file_get_contents($_FILES["ficLM"]["tmp_name"]);
        }
        (new PostulerRepository())->modifierObjet(new Postuler(self::getCleEtudiant(), $_REQUEST["idOffre"], "En attente", $cvData, $lmData));
        self::redirectionFlash("afficherMesOffres", "success", "Fichiers modifiés");
    }

    /**
     * @return void modifie le numéroEtudiant et le sexe lors de la Première Connexion
     */
    public static function setnumEtuSexe(): void
    {
        $ancienNumEtu = $_REQUEST['oldNumEtu'];
        $numEtu = $_REQUEST['numEtu'];
        $sexe = $_REQUEST['sexe'];

        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($ancienNumEtu);
        $etudiant->setNumEtudiant($numEtu);
        $etudiant->setSexeEtu($sexe);
        (new EtudiantRepository())->modifierNumEtuSexe($etudiant, $ancienNumEtu);
        self::afficherAccueilEtu();
        echo "<script>afficherPopupPremiereCo(2)</script>";
    }

    /**
     * @return void modifie le téléphone et le mail perso lors de la Première Connexion
     */
    public static function setTelMailPerso(): void
    {
        $numEtu = $_REQUEST['numEtu'];
        $tel = $_REQUEST['telephone'];
        $mailPerso = $_REQUEST['mailPerso'];

        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($numEtu);
        $etudiant->setTelephone($tel);
        $etudiant->setMailPerso($mailPerso);
        (new EtudiantRepository())->modifierTelMailPerso($etudiant);
        self::afficherAccueilEtu();
        echo "<script>afficherPopupPremiereCo(3)</script>";
    }

    /**
     * @return void modifie le groupe et le parcours lors de la Première Connexion
     */
    public static function setGroupeParcours(): void
    {
        $numEtu = $_REQUEST['numEtu'];
        $groupe = $_REQUEST['groupe'];
        $parcours = $_REQUEST['parcours'];
        echo "BlaBla";
        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($numEtu);
        $etudiant->setGroupe($groupe);
        $etudiant->setParcours($parcours);
        (new EtudiantRepository())->modifierGroupeParcours($etudiant);
        self::afficherAccueilEtu();
        echo "<script>afficherPopupPremiereCo(4)</script>";
    }

    /**
     * @return void met à jour les informations de l'étudiant connecté
     */
    public static function mettreAJour(): void
    {
        (new EtudiantRepository())->mettreAJourInfos($_REQUEST['mailPerso'], $_REQUEST['numTel'], $_REQUEST['numEtu']);
        self::afficherProfilEtu();
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void met à jour l'image de profil d'un étudiant
     */
    public static function updateImage(): void
    {
        //si un fichier a été passé en paramètre
        if (!empty($_FILES['pdp']['name'])) {

            $id = self::autoIncrement((new ImageRepository())->listeID(), "img_id");
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
            $estPasse = parent::insertImage($nom);
            $ancienId = (new ImageRepository())->imageParEtudiant(self::getCleEtudiant());
            (new EtudiantRepository())->updateImage(self::getCleEtudiant(), $id);
            if ($ancienId["img_id"] != 1 && $ancienId["img_id"] != 0) (new ImageRepository())->supprimer($ancienId["img_id"]);

            if (isset($_REQUEST['estPremiereCo'])) {
                self::redirectionFlash("afficherAccueilEtu", "success", "Informations enregistrées");
            } else {
                self::redirectionFlash("afficherProfilEtu", "success", "Image modifiée");
            }
        } else {
            if (isset($_REQUEST['estPremiereCo'])) {
                self::redirectionFlash("afficherAccueilEtu", "success", "Informations enregistrées");
            } else {
                self::redirectionFlash("afficherProfilEtu", "warning", "Aucune image selectionnée");
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

}
