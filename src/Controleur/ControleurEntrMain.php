<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\Repository\ConnexionBaseDeDonnee;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\Repository\RegarderRepository;


class ControleurEntrMain extends ControleurMain
{
    public static function afficherAccueilEntr()
    {
        $listeIDOffre = self::getTroisMax((new OffreRepository())->ListeIdOffreEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        $listeOffre = array();
        for ($i = 0; $i < sizeof($listeIDOffre); $i++) {
            $listeOffre[] = (new OffreRepository())->getObjectParClePrimaire($listeIDOffre[$i]);
        }
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Entreprise/vueAccueilEntreprise.php", "titrePage" => "Accueil Entreprise", "listeOffre" => $listeOffre]);
    }


    public static function creerOffre()
    {
        //TODO faire toutes les vérif liés à la BD, se référencier aux td de web
        if (isset($_REQUEST['nomOffre'],$_REQUEST["dateDebut"],$_REQUEST["dateFin"],$_REQUEST["sujet"],$_REQUEST["detailProjet"],$_REQUEST["gratification"],$_REQUEST['dureeHeures'],$_REQUEST["joursParSemaine"],$_REQUEST["nbHeuresHebdo"],$_REQUEST["typeOffre"])){
            //if (strtotime($_REQUEST["dateDebut"]) > strtotime($_REQUEST["dateFin"])){
                //TODO vérif que début après aujourd'hui
            if ($_REQUEST["gratification"]>0 && $_REQUEST["dureeHeures"]>0 && $_REQUEST["joursParSemaine"]>0 && $_REQUEST["nbHeuresHebdo"]>0) {
                if ($_REQUEST["joursParSemaine"]<8) {
                    if ($_REQUEST["nbHeuresHebdo"]<8*7 && $_REQUEST["dureeHeures"]>$_REQUEST["nbHeuresHebdo"]) {
                        $listeId = (new OffreRepository())->getListeIdOffres();
                        self::autoIncrement($listeId, "idOffre");
                        $_REQUEST["idEntreprise"] = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                        $offre = (new OffreRepository())->construireDepuisTableau($_REQUEST);
                        (new OffreRepository())->creerObjet($offre);
                        $_REQUEST["action"] = "mesOffres";
                        self::mesOffres();
                    }else {
                        self::afficherErreur("Concordance des heures");
                    }
                }else {
                    self::afficherErreur("Concordance des jours");
                }
            }else {
                self::afficherErreur("Des données sont érronées");
            }
            /*}else {
                //redirectionFlash "Concordance des dates
                echo "dates";
                self::formulaireCreationOffre();
            }*/
        }else {
            //redirectionFlash "éléments manquants
            self::afficherErreur("Des données sont manquantes");
        }

    }

    public static function mesOffres(): void
    {
        if (!isset($_REQUEST["type"])) {
            $_REQUEST["type"] = "Tous";
        }
        if (!isset($_REQUEST["Etat"])){
            $_REQUEST["Etat"]= "Tous";
        }
        $liste = (new OffreRepository())->getListeOffreParEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte(), $_REQUEST["type"],$_REQUEST["Etat"]);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Entreprise/vueMesOffres.php", "menu" => self::getMenu(), "type" => $_REQUEST["type"], "listeOffres" => $liste,"Etat"=>$_REQUEST["Etat"]]);
    }

    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=mesOffres&type=Tous&controleur=EntrMain"),
            array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php?action=seDeconnecter")

        );
    }

    // ---- AFFICHAGES ----
    public static function afficherProfilEntr(): void
    {
            $entreprise=(new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte());
            self::afficherVue("vueGenerale.php", ["entreprise"=>$entreprise,"menu" => self::getMenu(), "chemin" => "Entreprise/vueCompteEntreprise.php", "titrePage" => "Compte Entreprise"]);
    }

    public static function formulaireCreationOffre(): void
    {
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Entreprise/formulaireCreationOffre.php", "titrePage", "titrePage" => "Créer une offre"]);
    }

    public static function afficherFormulaireModificationOffre(): void
    {
        if (isset($_GET['idOffre'])) {
            $offre = (new OffreRepository())->getObjectParClePrimaire($_GET['idOffre']);
            self::afficherVueDansCorps("Modifier l'offre", "Entreprise/formulaireModificationOffre.php", self::getMenu(), ["offre" => $offre]);
        }
    }


    public static function assignerEtudiantOffre(): void
    {
        //TODO vérifs que l'offre et l'étudiant existent
        if (isset($_REQUEST["idEtudiant"],$_REQUEST["idOffre"])){
            $offre=((new OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]));
            $etudiant =((new EtudiantRepository())->getObjectParClePrimaire($_REQUEST["idEtudiant"]));
            if (!is_null($offre) && !is_null($etudiant)) {
                if (((new FormationRepository())->estFormation($_REQUEST["idOffre"]))) {
                    self::afficherErreur("L'offre est déjà prise");
                } else {
                    if (((new EtudiantRepository())->aUneFormation($_REQUEST["idOffre"]))) {
                        self::afficherErreur("L'étudiant a déjà une formation");
                    } else {
                        if (((new EtudiantRepository())->EtudiantAPostuler($_REQUEST["idEtudiant"], $_REQUEST["idOffre"]))) {
                            (new OffreRepository())->mettreAChoisir($_REQUEST['idEtudiant'], $_REQUEST["idOffre"]);
                            $_REQUEST["action"] = "afficherAccueilEntr()";
                            self::afficherAccueilEntr();
                        } else {
                            self::afficherErreur("L'étudiant n'es pas en Attente");
                        }

                    }
                }
            } else {
                self::afficherErreur("L'étudiant ou l'offre n'existe pas");
            }
        } else {
            self::afficherErreur("Données Manquantes pour assigner un étudiant");
        }

    }

    public static function updateImage(): void
    {
        $id = self::autoIncrement((new ImageRepository())->listeID(), "img_id");
        //TODO vérif de doublons d'image
        $entreprise=((new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        $nom="";
        $nomEntreprise=$entreprise->getNomEntreprise();
        for ($i=0;$i<strlen($entreprise->getNomEntreprise());$i++){
            if ($nomEntreprise[$i]==' '){
                $nom.="_";
            }else {
                $nom.=$nomEntreprise[$i];
            }
        }
        $nom .= "_logo";
        parent::insertImage($nom);
        $ancienId=(new ImageRepository())->imageParEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        (new EntrepriseRepository())->updateImage(ConnexionUtilisateur::getLoginUtilisateurConnecte(),$id);
        if ($ancienId["img_id"]!=0) {
            (new ImageRepository())->supprimer($ancienId["img_id"]);
        }
        $_REQUEST["action"]="afficherProfilEntr()";
        self::afficherProfilEntr();
    }

    // ---- CRUD de l'offre ----
    public static function creerOffre(): void
    {
        //TODO faire toutes les vérif liés à la BD, se référencier aux td de web
        if (isset($_POST['nomOffre'], $_POST["dateDebut"], $_POST["dateFin"], $_POST["sujet"], $_POST["detailProjet"], $_POST["gratification"], $_POST['dureeHeures'], $_POST["joursParSemaine"], $_POST["nbHeuresHebdo"], $_POST["typeOffre"])) {
            //if (strtotime($_POST["dateDebut"]) > strtotime($_POST["dateFin"])){
            //TODO vérif que début après aujourd'hui
            if ($_POST["gratification"] > 0 && $_POST["dureeHeures"] > 0 && $_POST["joursParSemaine"] > 0 && $_POST["nbHeuresHebdo"] > 0) {
                if ($_POST["joursParSemaine"] < 8) {
                    if ($_POST["nbHeuresHebdo"] < 8 * 7 && $_POST["dureeHeures"] > $_POST["nbHeuresHebdo"]) {
                        $listeId = (new OffreRepository())->getListeIdOffres();
                        self::autoIncrement($listeId, "idOffre");
                        $_POST["idEntreprise"] = self::$cleEntreprise;
                        $offre = (new OffreRepository())->construireDepuisTableau($_POST);
                        (new OffreRepository())->creerObjet($offre);
                        $_GET["action"] = "mesOffres";
                        self::mesOffres();
                    } else {
                        self::afficherErreur("Concordance des heures");
                    }
                } else {
                    self::afficherErreur("Concordance des jours");
                }
            } else {
                self::afficherErreur("Des données sont érronées");
            }
            /*}else {
                //redirectionFlash "Concordance des dates
                echo "dates";
                self::formulaireCreationOffre();
            }*/
        } else {
            //redirectionFlash "éléments manquants
            self::afficherErreur("Des données sont manquantes");
        }

    }

    public static function supprimerOffre(): void
    {
        //TODO vérifs
        if (isset($_REQUEST["idOffre"])) {
            $listeOffre=((new OffreRepository())->getListeIdOffres());
            if (in_array($_REQUEST["idOffre"],$listeOffre)) {
                if (!((new FormationRepository())->estFormation($_REQUEST["idOffre"]))) {
                    $offre = ((new OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]));
                    if ($offre->getSiret()==ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                        (new RegarderRepository())->supprimerOffreDansRegarder($_REQUEST["idOffre"]);
                        (new OffreRepository())->supprimer($_REQUEST["idOffre"]);
                        $_REQUEST["action"] = "afficherAccueilEntr()";
                        self::afficherAccueilEntr();
                    } else {
                        self::afficherErreur("Cette offre ne vous appartient pas");
                    }
                } else {
                    self::afficherErreur("Cette offre a été admise par un étudiant");
                }
            } else {
                self::afficherErreur("Cette offre n'existe pas");
            }
        } else {
            self::afficherErreur("Données Manquantes");
        }
    }

    public static function modifierOffre(): void
    {
        if (isset($_POST["idOffre"], $_POST['nomOffre'], $_POST["dateDebut"], $_POST["dateFin"], $_POST["sujet"], $_POST["detailProjet"], $_POST["gratification"], $_POST['dureeHeures'], $_POST["joursParSemaine"], $_POST["nbHeuresHebdo"], $_POST["typeOffre"])) {
            if ($_POST["joursParSemaine"] <= 7 && $_POST["gratification"] > 0 && $_POST["dureeHeures"] > 0 && $_POST["joursParSemaine"] > 0 && $_POST["nbHeuresHebdo"] > 0 && $_POST["nbHeuresHebdo"] < 8 * 7 && $_POST["dureeHeures"] > $_POST["nbHeuresHebdo"]) {
                $offre = (new OffreRepository())->getObjectParClePrimaire($_POST["idOffre"]);
                if ($offre) {
                    if (!(new FormationRepository())->estFormation($offre->getIdOffre())) {
                        if ($offre->getSiret() == self::$cleEntreprise) {
                            $offre->setTypeOffre($_POST['typeOffre']);
                            $offre->setNomOffre($_POST['nomOffre']);
                            $offre->setDateDebut(date_create_from_format("Y-m-d", $_POST['dateDebut']));
                            $offre->setDateFin(date_create_from_format("Y-m-d", $_POST['dateFin']));
                            $offre->setSujet($_POST['sujet']);
                            $offre->setDetailProjet($_POST['detailProjet']);
                            $offre->setGratification($_POST['gratification']);
                            $offre->setDureeHeures($_POST['dureeHeures']);
                            $offre->setJoursParSemaine($_POST['joursParSemaine']);
                            $offre->setNbHeuresHebdo($_POST['nbHeuresHebdo']);
                            (new OffreRepository())->modifierObjet($offre);
                            self::afficherVueDetailOffre($offre->getIdOffre());
                        } else {
                            self::afficherErreur("Cette offre ne vous appartient pas");
                        }
                    } else {
                        self::afficherErreur("Cette offre a déjà été admise par un étudiant");
                    }
                } else {
                    self::afficherErreur("Cette offre n'existe pas");
                }
            } else {
                self::afficherErreur("Certaines données renseignées sont erronnées");
            }
        } else {
            self::afficherErreur("Données manquantes");
        }
    }




}
