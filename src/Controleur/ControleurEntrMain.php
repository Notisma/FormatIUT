<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
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
        self::afficherVue("Accueil Entreprise", "Entreprise/vueAccueilEntreprise.php", self::getMenu(), ["listeOffre" => $listeOffre]);
    }

    public static function mesOffres(): void
    {
        if (!isset($_REQUEST["type"])) {
            $_REQUEST["type"] = "Tous";
        }
        if (!isset($_REQUEST["Etat"])) {
            $_REQUEST["Etat"] = "Tous";
        }
        $liste = (new OffreRepository())->getListeOffreParEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte(), $_REQUEST["type"], $_REQUEST["Etat"]);
        self::afficherVue("Mes Offres", "Entreprise/vueMesOffresEntr.php", self::getMenu(), ["type" => $_REQUEST["type"], "listeOffres" => $liste, "Etat" => $_REQUEST["Etat"]]);
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
        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        self::afficherVue("Compte Entreprise", "Entreprise/vueCompteEntreprise.php", self::getMenu(), ["entreprise" => $entreprise]);
    }

    public static function formulaireCreationOffre(): void
    {
        self::afficherVue("Créer une offre", "Entreprise/vueFormulaireCreationOffre.php", self::getMenu());
    }

    public static function afficherFormulaireModificationOffre(): void
    {
        if (isset($_REQUEST['idOffre'])) {
            $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
            self::afficherVue("Modifier l'offre", "Entreprise/vueFormulaireModificationOffre.php", self::getMenu(), ["offre" => $offre]);
        } else {
            self::afficherErreur("Une offre devrait être renseignée");
        }
    }


    public static function assignerEtudiantOffre(): void
    {
        if (isset($_REQUEST["idEtudiant"], $_REQUEST["idOffre"])) {
            $idOffre = $_REQUEST["idOffre"];
            $offre = ((new OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]));
            $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire($_REQUEST["idEtudiant"]));
            if (!is_null($offre) && !is_null($etudiant)) {
                if (((new FormationRepository())->estFormation($_REQUEST["idOffre"]))) {
                    MessageFlash::ajouter("danger", "L'offre est déjà assignée à un étudiant");
                    header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_REQUEST["idOffre"]);
                } else {
                    if (((new EtudiantRepository())->aUneFormation($_REQUEST["idOffre"]))) {
                        MessageFlash::ajouter("danger", "Cet étudiant a déjà une formation");
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_REQUEST["idOffre"]);
                    } else {
                        if (((new EtudiantRepository())->EtudiantAPostuler($_REQUEST["idEtudiant"], $_REQUEST["idOffre"]))) {
                            (new OffreRepository())->mettreAChoisir($_REQUEST['idEtudiant'], $_REQUEST["idOffre"]);
                            $_REQUEST["action"] = "afficherAccueilEntr()";
                            self::redirectionFlash("afficherAccueilEntr", "success", "Etudiant assigné avec succès");
                        } else {
                            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_REQUEST["idOffre"]);
                            MessageFlash::ajouter("danger", "Cet étudiant n'a pas postulé à cette offre");
                        }

                    }
                }
            } else {
                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_REQUEST["idOffre"]);
                MessageFlash::ajouter("danger", "Cet étudiant n'existe pas");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_REQUEST["idOffre"]);
            MessageFlash::ajouter("danger", "Des données sont manquantes");

        }

    }

    public static function updateImage(): void
    {
        $id = self::autoIncrement((new ImageRepository())->listeID(), "img_id");
        $entreprise = ((new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        $nom = "";
        $nomEntreprise = $entreprise->getNomEntreprise();
        for ($i = 0; $i < strlen($entreprise->getNomEntreprise()); $i++) {
            if ($nomEntreprise[$i] == ' ') {
                $nom .= "_";
            } else {
                $nom .= $nomEntreprise[$i];
            }
        }
        $nom .= "_logo";
        parent::insertImage($nom);
        $ancienId = (new ImageRepository())->imageParEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        (new EntrepriseRepository())->updateImage(ConnexionUtilisateur::getLoginUtilisateurConnecte(), $id);
        if ($ancienId["img_id"] != 0) {
            (new ImageRepository())->supprimer($ancienId["img_id"]);
        }
        $_REQUEST["action"] = "afficherProfilEntr()";
        MessageFlash::ajouter("success", "Image modifiée avec succès.");
        self::afficherProfilEntr();
    }

    // ---- CRUD de l'offre ----
    public static function creerOffre(): void
    {
        if (isset($_REQUEST['nomOffre'],$_REQUEST['anneeMin'], $_REQUEST['anneeMax'], $_REQUEST["dateDebut"], $_REQUEST["dateFin"], $_REQUEST["sujet"], $_REQUEST["detailProjet"], $_REQUEST["gratification"], $_REQUEST['dureeHeures'], $_REQUEST["joursParSemaine"], $_REQUEST["nbHeuresHebdo"], $_REQUEST["typeOffre"])) {
            //if (strtotime($_REQUEST["dateDebut"]) > strtotime($_REQUEST["dateFin"])){
            if ($_REQUEST["gratification"] > 0 && $_REQUEST["dureeHeures"] > 0 && $_REQUEST["joursParSemaine"] > 0 && $_REQUEST["nbHeuresHebdo"] > 0) {
                if ($_REQUEST["joursParSemaine"] < 8) {
                    if ($_REQUEST["nbHeuresHebdo"] < 8 * 7 && $_REQUEST["dureeHeures"] > $_REQUEST["nbHeuresHebdo"]) {
                        $listeId = (new OffreRepository())->getListeIdOffres();
                        self::autoIncrement($listeId, "idOffre");
                        $_REQUEST["idEntreprise"] = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                        $offre = (new OffreRepository())->construireDepuisTableau($_REQUEST);
                        (new OffreRepository())->creerObjet($offre);
                        $_REQUEST["action"] = "mesOffres";
                        MessageFlash::ajouter("success", "Offre créée avec succès");
                        self::mesOffres();
                    } else {
                        header("Location: controleurFrontal.php?action=formulaireCreationOffre&controleur=EntrMain");
                        MessageFlash::ajouter("danger", "Les heures inscrites ne sont pas correctes");
                    }
                } else {
                    header("Location: controleurFrontal.php?action=formulaireCreationOffre&controleur=EntrMain");
                    MessageFlash::ajouter("danger", "Les jours inscrits ne sont pas corrects");
                }
            } else {
                header("Location: controleurFrontal.php?action=formulaireCreationOffre&controleur=EntrMain");
                MessageFlash::ajouter("danger", "Des données sont erronées");
            }
            /*}else {
                //redirectionFlash "Concordance des dates
                echo "dates";
                self::formulaireCreationOffre();
            }*/
        } else {
            //redirectionFlash "éléments manquants
            header("Location: controleurFrontal.php?action=formulaireCreationOffre&controleur=EntrMain");
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }

    }

    public static function supprimerOffre(): void
    {
        if (isset($_REQUEST["idOffre"])) {
            $listeOffre = ((new OffreRepository())->getListeIdOffres());
            if (in_array($_REQUEST["idOffre"], $listeOffre)) {
                if (!((new FormationRepository())->estFormation($_REQUEST["idOffre"]))) {
                    $offre = ((new OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]));
                    if ($offre->getSiret() == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                        (new RegarderRepository())->supprimerOffreDansRegarder($_REQUEST["idOffre"]);
                        (new OffreRepository())->supprimer($_REQUEST["idOffre"]);
                        $_REQUEST["action"] = "afficherAccueilEntr()";
                        header("Location: controleurFrontal.php?action=afficherAccueilEntr&controleur=EntrMain");
                        MessageFlash::ajouter("success", "Offre supprimée");
                    } else {
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                        MessageFlash::ajouter("danger", "Cette offre ne vous appartient pas");
                    }
                } else {
                    header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                    MessageFlash::ajouter("danger", "Cette offre a été acceptée par un étudiant");
                }
            } else {
                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                MessageFlash::ajouter("danger", "Cette offre n'existe pas");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }
    }

    public static function modifierOffre(): void
    {
        if (isset($_POST["idOffre"], $_POST['nomOffre'], $_POST["dateDebut"], $_POST["dateFin"], $_POST["sujet"], $_POST["detailProjet"], $_POST["gratification"], $_POST['dureeHeures'], $_POST["joursParSemaine"], $_POST["nbHeuresHebdo"], $_POST["typeOffre"])) {
            if ($_POST["joursParSemaine"] <= 7 && $_POST["gratification"] > 0 && $_POST["dureeHeures"] > 0 && $_POST["joursParSemaine"] > 0 && $_POST["nbHeuresHebdo"] > 0 && $_POST["nbHeuresHebdo"] < 8 * 7 && $_POST["dureeHeures"] > $_POST["nbHeuresHebdo"]) {
                $offre = (new OffreRepository())->getObjectParClePrimaire($_POST["idOffre"]);
                if ($offre) {
                    if (!(new FormationRepository())->estFormation($offre->getIdOffre())) {
                        if ($offre->getSiret() == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
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
                            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                            MessageFlash::ajouter("success", "Offre modifiée avec succès");
                        } else {
                            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                            MessageFlash::ajouter("danger", "Cette offre ne vous appartient pas");
                        }
                    } else {
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                        MessageFlash::ajouter("danger", "Cette offre a déjà été acceptée par l'étudiant");
                    }
                } else {
                    header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                    MessageFlash::ajouter("danger", "Cette offre n'existe pas");
                }
            } else {
                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
                MessageFlash::ajouter("danger", "Certaines données sont erronnées");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $_POST["idOffre"]);
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }
    }

    public static function afficherFormulaireModification(): void
    {
        $entreprise = ((new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        self::afficherVue("Modifier vos informations", "Entreprise/vueMettreAJour.php", self::getMenu(), ["entreprise" => $entreprise]);
    }

    public static function mettreAJour(): void
    {
        (new EntrepriseRepository())->mettreAJourInfos($_REQUEST['siret'], $_REQUEST['nom'], $_REQUEST['statutJ'], $_REQUEST['effectif'], $_REQUEST['codeNAF'], $_REQUEST['tel'], $_REQUEST['adresse']);
        self::afficherProfilEntr();
    }
    public static function telechargerCV(): void{
        $cv = (new RegarderRepository())->recupererCV($_REQUEST['etudiant'],$_REQUEST['idOffre']);
        $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['etudiant']);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=CV de '. $etu->getPrenomEtudiant().' '.$etu->getNomEtudiant().'.pdf');
        echo $cv;
    }

    public static function telechargerLettre(): void{
        $lettre = (new RegarderRepository())->recupererLettre($_REQUEST['etudiant'],$_REQUEST['idOffre']);
        $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['etudiant']);
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename=Lettre de motivation de '. $etu->getPrenomEtudiant().' '.$etu->getNomEtudiant().'.pdf');
        echo $lettre;
    }

}
