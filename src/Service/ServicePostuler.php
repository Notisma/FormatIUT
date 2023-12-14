<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\DataObject\Postuler;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;

class ServicePostuler
{
    /**
     * @return void assigne un étudiant à une offre
     */
    public static function assignerEtudiantFormation(): void
    {
        //vérif si l'offre est bien à l'entreprise
        if (isset($_REQUEST["idEtudiant"], $_REQUEST["idFormation"])) {
            $idFormation = $_REQUEST["idFormation"];
            $offre = ((new FormationRepository())->getObjectParClePrimaire($idFormation));
            $etudiant = ((new EtudiantRepository())->getObjectParClePrimaire($_REQUEST["idEtudiant"]));
            if (!is_null($offre) && !is_null($etudiant)) {
                if (((new FormationRepository())->estFormation($idFormation))) {
                    ControleurEntrMain::redirectionFlash("afficherVueDetailOffre","danger","L'offre est déjà assignée à un étudiant");
                } else {
                    if (((new EtudiantRepository())->aUneFormation($idFormation))) {
                        MessageFlash::ajouter("danger", "Cet étudiant a déjà une formation");
                        header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $idFormation);
                    } else {
                        if (((new EtudiantRepository())->etudiantAPostule($_REQUEST["idEtudiant"], $idFormation))) {
                            (new FormationRepository())->mettreAChoisir($_REQUEST['idEtudiant'], $idFormation);
                            $_REQUEST["action"] = "afficherAccueilEntr()";
                            ControleurEntrMain::redirectionFlash("afficherAccueilEntr", "success", "Etudiant assigné avec succès");
                        } else {
                            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $idFormation);
                            MessageFlash::ajouter("danger", "Cet étudiant n'a pas postulé à cette offre");
                        }

                    }
                }
            } else {
                ControleurEntrMain::redirectionFlash("afficherVueDetailOffre","danger","Cet étudiant n'existe pas");
            }
        } else {
            header("Location: controleurFrontal.php?controleur=EntrMain&action=afficherMesOffres");
            MessageFlash::ajouter("danger", "Des données sont manquantes");
        }
    }

    /**
     * @return void permet à l'utilisateur connecté de postuler à une offre
     */
    public static function postuler(): void
    {
        $anneeEtu = (new EtudiantRepository())->getAnneeEtudiant((new EtudiantRepository())->getObjectParClePrimaire(ControleurEtuMain::getCleEtudiant()));
        $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
        if (($anneeEtu >= $offre->getAnneeMin()) && $anneeEtu <= $offre->getAnneeMax()) {
            //TODO vérifier les vérifs
            if (isset($_REQUEST['idFormation'])) {
                $liste = ((new FormationRepository())->getListeidFormations());
                if (in_array($_REQUEST["idFormation"], $liste)) {
                    $formation = ((new FormationRepository())->estFormation($_REQUEST['idFormation']));
                    if (is_null($formation)) {
                        if (!(new EtudiantRepository())->aUneFormation(ControleurEtuMain::getCleEtudiant())) {
                            if ((new EtudiantRepository())->aPostule(ControleurEtuMain::getCleEtudiant(), $_REQUEST['idFormation'])) {
                                ControleurEtuMain::redirectionFlash("afficherMesOffres", "warning", "Vous avez déjà postulé");
                            } else {
                                $ids = ControleurEtuMain::uploadFichiers(['cv', 'lm'], "afficherMesOffres");

                                $postuler = new Postuler(ControleurEtuMain::getCleEtudiant(), $_REQUEST["idFormation"], "En attente", $ids['cv'], $ids['lm']);
                                (new PostulerRepository())->creerObjet($postuler);

                                $_REQUEST['action'] = "afficherMesOffres";
                                ControleurEtuMain::redirectionFlash("afficherMesOffres", "success", "Candidature effectuée");
                            }
                        } else {
                            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Vous avez déjà une formation");
                        }
                    } else {
                        if ($formation->getIdEtudiant() == ControleurEtuMain::getCleEtudiant()) {
                            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Vous avez déjà cette Formation");
                        } else {
                            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Cette offre est déjà assignée");
                        }
                    }
                } else {
                    ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Offre inexistante");
                }
            } else {
                ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Données Manquantes");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Vous ne pouvez pas postuler à cette offre");
        }
    }

    /**
     * @return void permet à l'étudiant connecté d'annuler sa postulation à une offre
     */
    public static function annulerOffre(): void
    {
        if (isset($_REQUEST["idFormation"])) {
            $listeId = ((new FormationRepository())->getListeidFormations());
            if (in_array($_REQUEST["idFormation"], $listeId)) {
                if ((new EtudiantRepository())->aPostule(ControleurEtuMain::getCleEtudiant(), $_REQUEST["idFormation"])) {
                    (new PostulerRepository())->supprimerOffreEtudiant(ControleurEtuMain::getCleEtudiant(), $_REQUEST['idFormation']);
                    ControleurEtuMain::redirectionFlash("afficherMesOffres", "success", "Offre annulée");
                } else {
                    ControleurEtuMain::redirectionFlash("afficherMesOffres", "warning", "Vous n'avez pas postulé à cette offre");
                }
            } else {
                ControleurEtuMain::afficherErreur("L'offre n'existe pas");
                ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "L'offre n'existe pas");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Des données sont manquantes");
        }
    }


    /**
     * @return void permet à l'étudiant connecté de valider une offre
     */
    public static function validerOffre(): void
    {
        if (isset($_REQUEST['idFormation'])) {
            $listeId = ((new FormationRepository())->getListeidFormations());
            $idFormation = $_REQUEST['idFormation'];
            if (in_array($idFormation, $listeId)) {
                $formation = ((new FormationRepository())->estFormation($idFormation));
                if (!(new EtudiantRepository())->aUneFormation(ControleurEtuMain::getCleEtudiant())) {
                    if (is_null($formation)) {
                        if ((new PostulerRepository())->getEtatEtudiantOffre(ControleurEtuMain::getCleEtudiant(), $idFormation) == "A Choisir") {
                            (new PostulerRepository())->validerOffreEtudiant(ControleurEtuMain::getCleEtudiant(), $idFormation);
                            $offre = ((new FormationRepository())->getObjectParClePrimaire($idFormation));
                            $offre->setIdEtudiant(ControleurEtuMain::getCleEtudiant());
                            (new FormationRepository())->modifierObjet($offre);
                            ControleurEtuMain::redirectionFlash("afficherMesOffres", "success", "Offre validée");
                        } else {
                            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Vous n'êtes pas en état de choisir pour cette offre");
                        }
                    } else {
                        ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Cette Offre est déjà assignée");
                    }
                } else {
                    ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Vous avez déjà une Offre assignée");
                }
            } else {
                ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Offre non existante");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherMesOffres", "danger", "Des données sont manquantes");
        }
    }

}