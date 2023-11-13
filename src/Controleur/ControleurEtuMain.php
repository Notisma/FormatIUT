<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\CV;
use App\FormatIUT\Modele\DataObject\LM;
use App\FormatIUT\Modele\DataObject\Regarder;
use App\FormatIUT\Modele\Repository\CVRepository;
use App\FormatIUT\Configuration\ConfigurationLdap;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\LMRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\Repository\RegarderRepository;

class ControleurEtuMain extends ControleurMain
{

    public static function getCleEtudiant(): int
    {
        return ConnexionUtilisateur::getNumEtudiantConnecte();
    }

    //TODO Se déconnecter, connecter à la BD
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
        self::afficherVue("Accueil Etudiants", "Etudiant/vueAccueilEtudiant.php", self::getMenu(), ["listeStage" => $listeStage, "listeAlternance" => $listeAlternance]);
    }

    public static function afficherCatalogue()
    {
        $type = $_REQUEST["type"] ?? "Tous";
        $offres = (new OffreRepository())->getListeOffresDispoParType($type);
        self::afficherVue("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffres.php", self::getMenu(), ["offres" => $offres, "type" => $type]);
    }

    public static function afficherProfilEtu()
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::afficherVue("Compte étudiant", "Etudiant/vueCompteEtudiant.php", self::getMenu(), ["etudiant" => $etudiant]);
    }

    public static function afficherMesOffres()
    {
        $listOffre = (new OffreRepository())->listOffreEtu(self::getCleEtudiant());
        self::afficherVue("Mes Offres", "Etudiant/vueMesOffresEtu.php", self::getMenu(), ["listOffre" => $listOffre, "numEtu" => self::getCleEtudiant()]);
    }

    public static function annulerOffre()
    {
        if (isset($_REQUEST["idOffre"])) {
            $listeId = ((new OffreRepository())->getListeIdOffres());
            if (in_array($_REQUEST["idOffre"], $listeId)) {
                if ((new EtudiantRepository())->aPostuler(self::getCleEtudiant(), $_REQUEST["idOffre"])) {
                    (new RegarderRepository())->supprimerOffreEtudiant(self::getCleEtudiant(), $_REQUEST['idOffre']);
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
        if (isset($_REQUEST['idOffre'])) {
            $listeId = ((new OffreRepository())->getListeIdOffres());
            $idOffre = $_REQUEST['idOffre'];
            if (in_array($idOffre, $listeId)) {
                $formation = ((new FormationRepository())->estFormation($idOffre));
                if (!(new EtudiantRepository())->aUneFormation(self::getCleEtudiant())) {
                    if (is_null($formation)) {
                        if ((new RegarderRepository())->getEtatEtudiantOffre(self::getCleEtudiant(), $idOffre) == "A Choisir") {
                            (new RegarderRepository())->validerOffreEtudiant(self::getCleEtudiant(), $idOffre);
                            $offre = ((new OffreRepository())->getObjectParClePrimaire($idOffre));
                            $idFormation = "F" . self::autoIncrementF(((new FormationRepository())->ListeIdTypeFormation()), "idFormation");
                            $formation = (new FormationRepository())->construireDepuisTableau(["idFormation" => $idFormation, "dateDebut" => date_format($offre->getDateDebut(), "Y-m-d"), "dateFin" => date_format($offre->getDateFin(), 'Y-m-d'), "idEtudiant" => self::getCleEtudiant(), "idEntreprise" => $offre->getSiret(), "idOffre" => $idOffre, "idTuteurPro" => null, "idConvention" => null, "idTuteurUM" => null]);
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

    public static function postuler(): void
    {
        $cvData = null;
        $lmData = null;
        if($_FILES["fic"]["tmp_name"] != null){
            $cvData = file_get_contents($_FILES["fic"]["tmp_name"]);
        }
        if($_FILES["ficLM"]["tmp_name"] != null){
            $lmData = file_get_contents($_FILES["ficLM"]["tmp_name"]);
        }
        //TODO vérifier les vérifs
        if (isset($_REQUEST['idOffre'])) {
            $liste = ((new OffreRepository())->getListeIdOffres());
            if (in_array($_REQUEST["idOffre"], $liste)) {
                $formation = ((new FormationRepository())->estFormation($_REQUEST['idOffre']));
                if (is_null($formation)) {
                    if (!(new EtudiantRepository())->aUneFormation(self::getCleEtudiant())) {
                        if ((new EtudiantRepository())->aPostuler(self::getCleEtudiant(), $_REQUEST['idOffre'])) {
                            self::afficherErreur("Vous avez déjà postulé");
                        } else {
                            $regarder = new Regarder(self::$cleEtudiant, $_REQUEST["idOffre"], "En attente", $cvData, $lmData);
                            (new RegarderRepository())->creerObjet($regarder);
                            $_REQUEST['action'] = "afficherMesOffres";
                            self::afficherMesOffres();
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

    public static function updateImage(): void
    {
        //si un fichier a été passé en paramètre
        if (!empty($_FILES['fic']['name'])) {

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

    public static function getMenu(): array
    {
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Etudiants", "lien" => "?action=afficherAccueilEtu&controleur=EtuMain"),
            //array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/stage.png", "label" => "Offres de Stage/Alternance", "lien" => "?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/signet.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&controleur=EtuMain"),

        );
        $formation = (new EtudiantRepository())->aUneFormation(self::getCleEtudiant());
        if ($formation) {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idOffre=" . $formation['idOffre']);
        }
        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter");
        return $menu;
    }

    public static function modifierFichiers(){
        $cvData = null;
        $lmData = null;
        if($_FILES["fic"]["tmp_name"] != null){
            $cvData = file_get_contents($_FILES["fic"]["tmp_name"]);
        }
        if($_FILES["ficLM"]["tmp_name"] != null){
            $lmData = file_get_contents($_FILES["ficLM"]["tmp_name"]);
        }
        (new RegarderRepository())->modifierFichiers(self::$cleEtudiant, $_GET["idOffre"], $cvData, $lmData);
        self::afficherMesOffres();
    }

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

    public static function setGroupeParcours(): void
    {
        $numEtu = $_REQUEST['numEtu'];
        $groupe = $_REQUEST['groupe'];
        $parcours = $_REQUEST['parcours'];

        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($numEtu);
        $etudiant->setGroupe($groupe);
        $etudiant->setParcours($parcours);
        (new EtudiantRepository())->modifierGroupeParcours($etudiant);
        self::afficherAccueilEtu();
        echo "<script>afficherPopupPremiereCo(4)</script>";
    }

    public static function photoInitiale(): void
    {
        self::updateImage();
        self::redirectionFlash("afficherAcueilEtu", "success", "Informations enregistrées");
    }


}