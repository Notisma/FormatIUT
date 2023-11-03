<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\ConfigurationLdap;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
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
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Etudiant/vueAccueilEtudiant.php", "titrePage" => "Accueil Etudiants", "listeStage" => $listeStage, "listeAlternance" => $listeAlternance]);
    }

    public static function afficherCatalogue()
    {
        $type = $_REQUEST["type"] ?? "Tous";
        $offres = (new OffreRepository())->getListeOffresDispoParType($type);
        self::afficherVueDansCorps("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffre.php", self::getMenu(), ["offres" => $offres, "type" => $type]);
    }

    public static function afficherProfilEtu()
    {
        $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire(self::getCleEtudiant()));
        self::afficherVue("vueGenerale.php", ["etudiant" => $etudiant, "menu" => self::getMenu(), "chemin" => "Etudiant/vueCompteEtudiant.php", "titrePage" => "Compte étudiant"]);
    }

    public static function afficherMesOffres()
    {
        $listOffre = (new OffreRepository())->listOffreEtu(self::getCleEtudiant());
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Etudiant/vueMesOffresEtu.php", "menu" => self::getMenu(), "listOffre" => $listOffre, "numEtu" => self::getCleEtudiant()]);
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
         (new RegarderRepository())->supprimerOffreEtudiant(self::getCleEtudiant(), $_REQUEST['idOffre']);
         self::afficherMesOffres();
     }*/

    public static function postuler()
    {
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
                            (new EtudiantRepository())->EtudiantPostuler(self::getCleEtudiant(), $_REQUEST['idOffre']);
                            $_REQUEST['action'] = "afficherVueDetailOffre";
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

    public static function updateImage()
    {
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
        if (!$estPasse) self::afficherProfilEtu();
        $ancienId = (new ImageRepository())->imageParEtudiant(self::getCleEtudiant());
        (new EtudiantRepository())->updateImage(self::getCleEtudiant(), $id);
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
        $formation = (new EtudiantRepository())->aUneFormation(self::getCleEtudiant());
        if ($formation) {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idOffre=" . $formation['idOffre']);
        }
        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter");
        return $menu;
    }


    public static function setnumEtuSexe(): void
    {
        $ancienNumEtu = $_REQUEST['oldNumEtu'];
        $numEtu = $_REQUEST['numEtu'];
        $sexe = $_REQUEST['sexe'];

        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($ancienNumEtu);
        $etudiant->setNumEtudiant($numEtu);
        $etudiant->setSexeEtu($sexe);
        (new EtudiantRepository())->modifierNumEtuSexe($etudiant,$ancienNumEtu);
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