<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;

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
                            self::redirectionFlash("afficherAccueilEntr", "success", "Etudiant assigné avec succès");
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
}