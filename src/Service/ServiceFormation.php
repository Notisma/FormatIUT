<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;

class ServiceFormation
{


    /**
     * @return void permet à l'admin connecté de valider une offre
     */
    public static function accepterFormation(): void
    {
        if (isset($_REQUEST["idFormation"])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            if (!is_null($offre)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$offre->getEstValide()) {
                        $offre->setEstValide(true);
                        (new FormationRepository())->modifierObjet($offre);
                        header("Location: ?action=afficherAccueilAdmin&controleur=AdminMain&idFormation=" . $offre->getidFormation());
                        MessageFlash::ajouter("success", "L'offre a bien été validée");
                    } else ControleurAdminMain::redirectionFlash("afficherVueDetailOffre", "warning", "L'offre est déjà valider");
                } else ControleurAdminMain::redirectionFlash("afficherVueDetailOffre", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeOffres", "warning", "L'offre n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeOffres", "danger", "L'offre n'est pas renseignée");
    }
    /**
     * @return void permet à l'admin connecté de refuser une offre
     */
    public static function rejeterFormation(): void
    {
        if (isset($_REQUEST["idFormation"])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            if (!is_null($offre)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$offre->getEstValide()) {
                        (new FormationRepository())->supprimer($offre->getidFormation());
                        ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été rejetée");
                    } else ControleurAdminMain::redirectionFlash("afficherVueDetailOffre", "warning", "L'offre est déjà accepter");
                } else ControleurAdminMain::redirectionFlash("afficherVueDetailOffre", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeOffres", "warning", "L'offre n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeOffres", "danger", "L'offre n'est pas renseignée");
    }

    /**
     * @return void permet à l'admin connecté de supprimer(archiver) une offre
     */
    public static function supprimerFormation(): void
    //TODO doublon de fonction avec supprimerOffre
    {
        if (isset($_REQUEST["idFormation"])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            if (!is_null($offre)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    (new FormationRepository())->supprimer($_REQUEST['idFormation']);
                    ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été supprimée");
                } else ControleurAdminMain::redirectionFlash("afficherVueDetailOffre", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeOffres", "warning", "L'offre n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeOffres", "danger", "L'offre n'est pas renseignée");
    }


    /**
     * @return void permet à l'entreprise connecté de créer une offre
     */
    public static function creerFormation(): void
    {
        if (isset($_REQUEST['nomOffre'], $_REQUEST['anneeMin'], $_REQUEST['anneeMax'], $_REQUEST["sujet"], $_REQUEST["detailProjet"], $_REQUEST["objectifOffre"], $_REQUEST["gratification"], $_REQUEST["uniteGratification"], $_REQUEST["uniteDureeGratification"], $_REQUEST['dureeHeure'], $_REQUEST["joursParSemaine"], $_REQUEST["nbHeuresHebdo"], $_REQUEST["typeOffre"])) {
            $anneeMin = $_REQUEST['anneeMin'];
            $anneeMax = $_REQUEST['anneeMax'];
            if (!($anneeMin < 2 || $anneeMin > 3 || $anneeMax < 2 || $anneeMax > 3 || $anneeMax < $anneeMin)) {
                if ($_REQUEST["gratification"] > $_REQUEST["uniteDureeGratification"] && $_REQUEST["uniteDureeGratification"] > 0 && $_REQUEST["dureeHeure"] > 0 && $_REQUEST["joursParSemaine"] > 0 && $_REQUEST["nbHeuresHebdo"] > 0) {
                    if ($_REQUEST["joursParSemaine"] < 8) {
                        if ($_REQUEST["nbHeuresHebdo"] < 8 * 7 && $_REQUEST["dureeHeure"] > $_REQUEST["nbHeuresHebdo"]) {
                            $offre=Formation::creerFormation($_REQUEST);
                            (new FormationRepository())->creerObjet($offre);
                            $_REQUEST["action"] = "afficherMesOffres";
                            MessageFlash::ajouter("success", "Offre créée avec succès");
                            ControleurEntrMain::afficherMesOffres();
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
        //TODO à revoir (SOLID)
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
                                    $offre->setDateDebut(date_create_from_format("Y-m-d", $_REQUEST['dateDebut']));
                                }
                                if (isset($_REQUEST['dateFin'])) {
                                    $offre->setDateFin(date_create_from_format("Y-m-d", $_REQUEST['dateFin']));
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



}