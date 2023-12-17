<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Convention;
use App\FormatIUT\Modele\Repository\ConventionRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use DateTime;

class ServiceConvention
{
    /**
     * @return void permet à l'étudiant connecté de créer sa convention
     * @throws Exception
     */
    public static function creerConvention(): void
    {
        if (isset($_REQUEST['idFormation'])) {
            $listeId = ((new FormationRepository())->getListeidFormations());
            $idFormation = $_REQUEST['idFormation'];
            if (in_array($idFormation, $listeId)) {
                $formation = ((new FormationRepository())->estFormation($idFormation));
                if (!(new EtudiantRepository())->aUneFormation(self::getCleEtudiant())) {
                    if (is_null($formation)) {
                        if ((new PostulerRepository())->getEtatEtudiantOffre(self::getCleEtudiant(), $idFormation) == "A Choisir") {
                            (new PostulerRepository())->validerOffreEtudiant(self::getCleEtudiant(), $idFormation);
                            $offre = ((new FormationRepository())->getObjectParClePrimaire($idFormation));
                            $idFormation = "F" . self::autoIncrementF(((new FormationRepository())->listeIdTypeFormation()), "idFormation");
                            $formation = (new FormationRepository())->construireDepuisTableau([
                                "idFormation" => $idFormation, "dateDebut" => $offre->getDateDebut(), "dateFin" => $offre->getDateFin(), "idEtudiant" => self::getCleEtudiant(), "idEntreprise" => $offre->getIdEntreprise(), "idTuteurPro" => null, "idConvention" => null, "idTuteurUM" => null]);
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

    public static function modifierConvention(): void{
        if(isset($_REQUEST['numEtudiant']) == ConnexionUtilisateur::getNumEtudiantConnecte()){

        }
    }

}