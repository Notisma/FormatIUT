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
use DateTime;
use DateTimeZone;

class ControleurEntrMain extends ControleurMain
{

    private static string $page = "Accueil Entreprise";

    public static function getCleEntreprise(): int
    {
        return ConnexionUtilisateur::getNumEtudiantConnecte();
    }

    /**
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
     */
    public static function getMenu(): array
    {
        $menu =  array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=afficherFormulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&type=Tous&controleur=EntrMain"),
        );

        if (self::$page == "Compte Entreprise") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Compte Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php?action=seDeconnecter");

        return $menu;


    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour l'entreprise connecté
     */
    public static function afficherAccueilEntr(): void
    {
        $listeidFormation = self::getSixMax((new FormationRepository())->listeidFormationEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        $listeOffre = array();
        for ($i = 0; $i < sizeof($listeidFormation); $i++) {
            $listeOffre[] = (new FormationRepository())->getObjectParClePrimaire($listeidFormation[$i]);
        }
        self::afficherVue("Accueil Entreprise", "Entreprise/vueAccueilEntreprise.php", self::getMenu(), ["listeOffre" => $listeOffre]);
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
        $liste = (new FormationRepository())->getListeOffreParEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte(), $_REQUEST["type"], $_REQUEST["etat"]);
        self::afficherVue("Mes Offres", "Entreprise/vueMesOffresEntr.php", self::getMenu(), ["type" => $_REQUEST["type"], "listeOffres" => $liste, "etat" => $_REQUEST["etat"]]);
    }

    /**
     * @return void affiche le profil de l'entreprise connecté
     */
    public static function afficherProfil(): void
    {
        self::$page = "Compte Entreprise";
        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte());
        self::afficherVue("Compte Entreprise", "Entreprise/vueCompteEntreprise.php", self::getMenu(), ["entreprise" => $entreprise]);
    }

    /**
     * @return void affiche le formulaire de Création d'offre
     */
    public static function afficherFormulaireCreationOffre(): void
    {
        self::afficherVue("Créer une offre", "Entreprise/vueFormulaireCreationOffre.php", self::getMenu());
    }

    /**
     * @return void affiche le formulaire de modification d'une offre
     */
    public static function afficherFormulaireModificationOffre(): void
    {
        if (isset($_REQUEST['idFormation'])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            self::afficherVue("Modifier l'offre", "Entreprise/vueFormulaireModificationOffre.php", self::getMenu(), ["offre" => $offre]);
        } else {
            self::afficherErreur("Une offre devrait être renseignée");
        }
    }

    /**
     * @return void affiche le formulaire de modification de l'entreprise connecté
     */
    public static function afficherFormulaireModification(): void
    {
        $entreprise = ((new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        self::afficherVue("Modifier vos informations", "Entreprise/vueMettreAJour.php", self::getMenu(), ["entreprise" => $entreprise]);
    }

    //FONCTIONS D'ACTIONS ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void assigne un étudiant à une offre
     */
    public static function assignerEtudiantOffre(): void
    {
        if (isset($_REQUEST["idEtudiant"], $_REQUEST["idFormation"])) {
            $idFormation = $_REQUEST["idFormation"];
            $offre = ((new FormationRepository())->getObjectParClePrimaire($idFormation));
            $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire($_REQUEST["idEtudiant"]));
            if (!is_null($offre) && !is_null($etudiant)) {
                if (((new FormationRepository())->estFormation($idFormation))) {
                    MessageFlash::ajouter("danger", "L'offre est déjà assignée à un étudiant");
                    header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $idFormation);
                } else {
                    if (((new EtudiantRepository())->aUneFormation($idFormation))) {
                        MessageFlash::ajouter("danger", "Cet étudiant a déjà une formation");
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $idFormation);
                    } else {
                        if (((new EtudiantRepository())->etudiantAPostule($_REQUEST["idEtudiant"], $idFormation))) {
                            (new FormationRepository())->mettreAChoisir($_REQUEST['idEtudiant'], $idFormation);
                            $_REQUEST["action"] = "afficherAccueilEntr()";
                            self::redirectionFlash("afficherAccueilEntr", "success", "Etudiant assigné avec succès");
                        } else {
                            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $idFormation);
                            MessageFlash::ajouter("danger", "Cet étudiant n'a pas postulé à cette offre");
                        }

                    }
                }
            } else {
                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $idFormation);
                MessageFlash::ajouter("danger", "Cet étudiant n'existe pas");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherMesOffres");
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }
    }

    /**
     * @return void permet à l'entreprise connectée de créer une offre
     */
    public static function creerOffre(): void
    {
        if (isset($_REQUEST['nomOffre'], $_REQUEST['anneeMin'], $_REQUEST['anneeMax'], $_REQUEST["sujet"], $_REQUEST["detailProjet"], $_REQUEST["objectifOffre"], $_REQUEST["gratification"], $_REQUEST["uniteGratification"], $_REQUEST["uniteDureeGratification"], $_REQUEST['dureeHeure'], $_REQUEST["joursParSemaine"], $_REQUEST["nbHeuresHebdo"], $_REQUEST["typeOffre"])) {
            $anneeMin = $_REQUEST['anneeMin'];
            $anneeMax = $_REQUEST['anneeMax'];
            if (!($anneeMin < 2 || $anneeMin > 3 || $anneeMax < 2 || $anneeMax > 3 || $anneeMax < $anneeMin)) {
                if ($_REQUEST["gratification"] > $_REQUEST["uniteDureeGratification"] && $_REQUEST["uniteDureeGratification"] > 0 && $_REQUEST["dureeHeure"] > 0 && $_REQUEST["joursParSemaine"] > 0 && $_REQUEST["nbHeuresHebdo"] > 0) {
                    if ($_REQUEST["joursParSemaine"] < 8) {
                        if ($_REQUEST["nbHeuresHebdo"] < 8 * 7 && $_REQUEST["dureeHeure"] > $_REQUEST["nbHeuresHebdo"]) {
                            $listeId = (new FormationRepository())->getListeidFormations();
                            self::autoIncrement($listeId, "idFormation");
                            $_REQUEST["dateCreationOffre"] = (new DateTime("now", new DateTimeZone("Europe/Paris")))->format("Y-d-m");
                            $_REQUEST["estValide"] = 0;
                            $_REQUEST["offreValidee"] = 0;
                            $_REQUEST["validationPedagogique"] = 0;
                            $_REQUEST["idEntreprise"] = ConnexionUtilisateur::getLoginUtilisateurConnecte();
                            $_REQUEST["convention"] = null;
                            $_REQUEST["conventionValidee"] = 0;
                            $_REQUEST["dateCreationConvention"] = null;
                            $_REQUEST["dateTransmissionConvention"] = null;
                            $_REQUEST["dateRetourSigne"] = null;
                            $_REQUEST["assurance"] = null;
                            $_REQUEST["avenant"] = null;
                            $_REQUEST["idEtudiant"] = null;
                            $_REQUEST["idTuteurPro"] = null;
                            $_REQUEST["loginTuteurUM"] = null;
                            $offre = (new FormationRepository())->construireDepuisTableau($_REQUEST);
                            (new FormationRepository())->creerObjet($offre);
                            $_REQUEST["action"] = "afficherMesOffres";
                            MessageFlash::ajouter("success", "Offre créée avec succès");
                            self::afficherMesOffres();
                        } else {
                            header("Location: controleurFrontal.php?action=afficherFormulaireCreationOffre&controleur=EntrMain");
                            MessageFlash::ajouter("danger", "Les heures inscrites ne sont pas correctes");
                        }
                    } else {
                        header("Location: controleurFrontal.php?action=afficherFormulaireCreationOffre&controleur=EntrMain");
                        MessageFlash::ajouter("danger", "Les jours inscrits ne sont pas corrects");
                    }
                } else {
                    header("Location: controleurFrontal.php?action=afficherFormulaireCreationOffre&controleur=EntrMain");
                    MessageFlash::ajouter("danger", "Des données sont erronées");
                }
            } else {
                header("Location: controleurFrontal.php?action=afficherFormulaireCreationOffre&controleur=EntrMain");
                MessageFlash::ajouter("danger", "Erreur sur année min / max (il n'y a que les années 2 et 3 de disponibles)");
            }
        } else {
            //redirectionFlash "éléments manquants
            header("Location: controleurFrontal.php?action=afficherFormulaireCreationOffre&controleur=EntrMain");
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }

    }

    /**
     * @return void supprime une offre de l'entreprise connecté
     */
    public static function supprimerOffre(): void
    {
        if (isset($_REQUEST["idFormation"])) {
            $listeOffre = ((new FormationRepository())->getListeidFormations());
            if (in_array($_REQUEST["idFormation"], $listeOffre)) {
                if (!((new FormationRepository())->estFormation($_REQUEST["idFormation"]))) {
                    $offre = ((new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]));
                    if ($offre->getIdEntreprise() == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                        (new PostulerRepository())->supprimerOffreDansPostuler($_REQUEST["idFormation"]);
                        (new FormationRepository())->supprimer($_REQUEST["idFormation"]);
                        $_REQUEST["action"] = "afficherAccueilEntr()";
                        header("Location: controleurFrontal.php?action=afficherAccueilEntr&controleur=EntrMain");
                        MessageFlash::ajouter("success", "Offre supprimée");
                    } else {
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                        MessageFlash::ajouter("danger", "Cette offre ne vous appartient pas");
                    }
                } else {
                    header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                    MessageFlash::ajouter("danger", "Cette offre a été acceptée par un étudiant");
                }
            } else {
                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                MessageFlash::ajouter("danger", "Cette offre n'existe pas");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }
    }

    /**
     * @return void modifie une offre de l'entreprise connecté
     */
    public static function modifierOffre(): void
    {
        if (isset($_REQUEST["idFormation"], $_REQUEST['nomOffre'], $_REQUEST['anneeMin'], $_REQUEST['anneeMax'], $_REQUEST["dateDebut"], $_REQUEST["dateFin"], $_REQUEST["sujet"], $_REQUEST["detailProjet"], $_REQUEST['objectifOffre'], $_REQUEST["gratification"], $_REQUEST["uniteGratification"], $_REQUEST["uniteDureeGratification"], $_REQUEST['dureeHeure'], $_REQUEST["joursParSemaine"], $_REQUEST["nbHeuresHebdo"], $_REQUEST["typeOffre"])) {
            $anneeMin = $_REQUEST['anneeMin'];
            $anneeMax = $_REQUEST['anneeMax'];
            if (!($anneeMin < 2 || $anneeMin > 3 || $anneeMax < 2 || $anneeMax > 3 || $anneeMax < $anneeMin)) {
                if ($_REQUEST["gratification"] > $_REQUEST["uniteDureeGratification"] && $_REQUEST["uniteDureeGratification"] > 0 && $_REQUEST["dureeHeure"] > 0 && $_REQUEST["joursParSemaine"] > 0 && $_REQUEST["nbHeuresHebdo"] > 0) {
                    $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
                    if ($offre) {
                        if (!(new FormationRepository())->estFormation($offre->getidFormation())) {
                            if ($offre->getIdEntreprise() == ConnexionUtilisateur::getLoginUtilisateurConnecte()) {
                                $offre->setTypeOffre($_REQUEST['typeOffre']);
                                $offre->setNomOffre($_REQUEST['nomOffre']);
                                if (isset($_REQUEST['dateDebut'])) {
                                    $offre->setDateDebut($_REQUEST['dateDebut']);
                                }
                                if (isset($_REQUEST['dateFin'])) {
                                    $offre->setDateFin( $_REQUEST['dateFin']);
                                }
                                $offre->setSujet($_REQUEST['sujet']);
                                $offre->setDetailProjet($_REQUEST['detailProjet']);
                                $offre->setObjectifOffre($_REQUEST["objectifOffre"]);
                                $offre->setGratification($_REQUEST['gratification']);
                                $offre->setUniteGratification($_REQUEST["uniteGratification"]);
                                $offre->setUniteDureeGratification($_REQUEST["uniteDureeGratification"]);
                                $offre->setDureeHeure($_REQUEST['dureeHeure']);
                                $offre->setJoursParSemaine($_REQUEST['joursParSemaine']);
                                $offre->setNbHeuresHebdo($_REQUEST['nbHeuresHebdo']);
                                (new FormationRepository())->modifierObjet($offre);
                                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                                MessageFlash::ajouter("success", "Offre modifiée avec succès");
                            } else {
                                header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                                MessageFlash::ajouter("danger", "Cette offre ne vous appartient pas");
                            }
                        } else {
                            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                            MessageFlash::ajouter("danger", "Cette offre a déjà été acceptée par l'étudiant");
                        }
                    } else {
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                        MessageFlash::ajouter("danger", "Cette offre n'existe pas");
                    }
                } else {
                    header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
                    MessageFlash::ajouter("danger", "Certaines données sont erronnées");
                }
            } else {
                header("Location: controleurFrontal.php?action=afficherFormulaireModificationOffre&controleur=EntrMain&idFormation=" . $_REQUEST["idFormation"]);
                MessageFlash::ajouter("danger", "Erreur sur année min / max (il n'y a que les années 2 et 3 de disponibles)");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $_REQUEST["idFormation"]);
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }
    }

    /**
     * @return void met à jour les informations de l'entreprise connecté
     */
    public static function mettreAJour(): void
    {
        if (isset($_REQUEST['siret'])) {
            if (ConnexionUtilisateur::getTypeConnecte() == "Entreprise" || ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                if (!empty($_FILES['pdp']['name'])) {
                    self::updateImage();
                }
                (new EntrepriseRepository())->mettreAJourInfos($_REQUEST['siret'], $_REQUEST['nom'], $_REQUEST['statutJ'], $_REQUEST['effectif'], $_REQUEST['codeNAF'], $_REQUEST['tel'], $_REQUEST['adresse']);
                self::redirectionFlash("afficherProfil", "success", "Informations enregistrées");
            } else {
                self::redirectionFlash("afficherProfil", "danger", "Vous n'avez pas les droits requis");
            }
        } else {
            self::redirectionFlash("afficherProfil", "warning", "Des données sont manquantes");
        }
    }

    /**
     * @return void télécharge le Cv d'un étudiant sur une offre
     */
    public static function telechargerCV(): void
    {
        $cv = (new PostulerRepository())->recupererCV($_REQUEST['etudiant'], $_REQUEST['idFormation']);
        if (empty($cv))
            self::redirectionFlash("afficherVueDetailOffre", "warning", "Cet étudiant n'a pas fourni de CV.");
        else {
            $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['etudiant']);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=CV_de_' . $etu->getPrenomEtudiant() . '_' . $etu->getNomEtudiant() . '.pdf');
            readfile(Configuration::getUploadPathFromId($cv));
        }
    }

    /**
     * @return void télécharge la lettre de motivation d'un étudiant sur une offre
     */
    public static function telechargerLM(): void
    {
        $lm = (new PostulerRepository())->recupererLettre($_REQUEST['etudiant'], $_REQUEST['idFormation']);
        if (empty($lm))
            self::redirectionFlash("afficherVueDetailOffre", "warning", "Cet étudiant n'a pas fourni de lettre de motivation.");
        else {
            $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['etudiant']);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=Lettre_de_motivation_de_' . $etu->getPrenomEtudiant() . '_' . $etu->getNomEtudiant() . '.pdf');
            readfile(Configuration::getUploadPathFromId($lm));
        }
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void met à jour l'image de profil de l'entreprise connecté
     */
    public static function updateImage(): void
    {
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

        $ancienId = (new UploadsRepository())->imageParEntreprise(ConnexionUtilisateur::getLoginUtilisateurConnecte());

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

    public static function mettreAJourMdp() : void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Entreprise") {
            if (isset($_POST['ancienMdp'], $_POST['nouveauMdp'], $_POST['confirmerMdp'])) {
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getNumEntrepriseConnectee());

                if (MotDePasse::verifier($_POST['ancienMdp'], $entreprise->getMdpHache())) {

                    if ($_POST['nouveauMdp'] === $_POST['confirmerMdp']) {
                        $hashedPassword = MotDePasse::hacher($_POST['nouveauMdp']);
                        $entreprise->setMdpHache($hashedPassword);
                        (new EntrepriseRepository())->modifierObjet($entreprise);
                        self::redirectionFlash("afficherProfil", "success", "Mot de passe mis à jour");
                    } else {
                        self::redirectionFlash("afficherProfil", "warning", "Les mots de passe ne correspondent pas");
                    }
                } else {
                    self::redirectionFlash("afficherProfil", "warning", "Ancien mot de passe incorrect");
                }
            } else {
                self::redirectionFlash("afficherProfil", "danger", "Des données sont manquantes");
            }
        } else {
            self::redirectionFlash("afficherProfil", "danger", "Vous n'avez pas les droits requis");
        }
    }
}
