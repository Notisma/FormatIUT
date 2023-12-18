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
        if ($_REQUEST['idOff'] != "aucune") {
            if ($_REQUEST['codePostalEntr'] > 0 && $_REQUEST['siret'] > 0) {
                $entrepriseVerif = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
                if (isset($entrepriseVerif)) {
                    $offreVerif = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idOff']);
                    if ($entrepriseVerif->getSiret() == $offreVerif->getIdEntreprise()) {
                        $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entrepriseVerif->getSiret());
                        if ((trim($entrepriseVerif->getNomEntreprise()) == trim($_REQUEST['nomEntreprise'])) && (trim($entrepriseVerif->getAdresseEntreprise()) == trim($_REQUEST['adresseEntr'])) && (trim($villeEntr->getNomVille()) == trim($_REQUEST['villeEntr'])) && ($villeEntr->getCodePostal() == $_REQUEST['codePostalEntr'])) {
                            if ($offreVerif->getDateDebut() == $_REQUEST['dateDebut'] && $offreVerif->getDateFin() == $_REQUEST['dateFin']) {
                                $offreVerif->setAssurance($_REQUEST['assurance']);
                                $offreVerif->setDateCreationConvention($_REQUEST['dateCreation']);
                                $offreVerif->setDateTransmissionConvention($_REQUEST['dateCreation']);
                                $offreVerif->setAssurance($_REQUEST['assurance']);
                                (new FormationRepository())->modifierObjet($offreVerif);
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

    public static function modifierConvention(): void
    {

        if (isset($_REQUEST['numEtudiant']) == ConnexionUtilisateur::getNumEtudiantConnecte()) {
            $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtudiant']);
            if($formation){
                if($formation->getDateCreationConvention() != null){
                    if(isset($_REQUEST["assurance"])){
                        $formation->setAssurance($_REQUEST['assurance']);
                        $formation->setDateCreationConvention($_REQUEST['dateCreation']);
                        (new FormationRepository())->modifierObjet($formation);
                        ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "success", "Convention modifiée");
                    }
                    else{
                        ControleurEtuMain::redirectionFlash("AfficherAccueilEtu", "danger", "L'utilisateur n'a changé l'assurance");
                    }
                }
                else{
                    ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur n'a pas de convention");
                }
            }
            else{
                ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur n'a pas de formation");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur ne correspond pas");
        }
    }

}