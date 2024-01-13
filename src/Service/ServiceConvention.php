<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use Exception;


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
                                ControleurEtuMain::redirectionFlash("afficherMaConvention", "success", "Convention créée");
                            } else {
                                ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Erreur sur les dates");
                            }
                        } else {
                            ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Erreur sur les informations de l'entreprise");
                        }
                    } else {
                        ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'entreprise n'a jamais créée cette offre");
                    }
                } else {
                    ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Erreur l'entreprise n'existe pas");
                }
            } else {
                ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Erreur nombre(s) négatif(s) présent(s)");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Aucune offre est liée à votre convention");
        }
    }

    /**
     * @return void permet à l'étudiant de modifier sa convention
     * @throws Exception
     */
    public static function modifierConvention(): void
    {
        if (!isset($_REQUEST['numEtudiant'])) {
            ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Il faut renseigner un étudiant");
            return;
        }
        $numEtu = $_REQUEST['numEtudiant'];
        if ($numEtu == ConnexionUtilisateur::getNumEtudiantConnecte()) {
            $formation = (new FormationRepository())->trouverOffreDepuisForm($numEtu);
            if ($formation) {
                if ($formation->getDateCreationConvention() != null) {
                    if (isset($_REQUEST["assurance"])) {
                        $formation->setAssurance($_REQUEST['assurance']);
                        $formation->setDateCreationConvention($_REQUEST['dateCreation']);
                        if($formation->getDateTransmissionConvention() != null){
                            $formation->setDateTransmissionConvention(null);
                        }
                        (new FormationRepository())->modifierObjet($formation);
                        ControleurEtuMain::redirectionFlash("afficherMaConvention", "success", "Convention modifiée");
                    } else {
                        ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur n'a changé l'assurance");
                    }
                } else {
                    ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur n'a pas de convention");
                }
            } else {
                ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur n'a pas de formation");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "L'utilisateur ne correspond pas");
        }
    }


    /**
     * @return void
     * Permet au secréteriat ou aux admins de valider une convention
     */

    public static function validerConvention(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs" || ConnexionUtilisateur::getTypeConnecte() == "Secretariat") {
            $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtudiant']);
            if (!$formation->getConventionValidee()) {
                $formation->setConventionValidee(true);
                $formation->setDateTransmissionConvention(date("d-m-Y"));
                (new FormationRepository())->modifierObjet($formation);
                ControleurAdminMain::redirectionFlash("afficherConventionAValider", "success", "Convention validée");
            } else {
                ControleurAdminMain::redirectionFlash("afficherConventionAValider", "danger", "Cette convention est déjà validée");
            }
        } else {
            ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "danger", "Vous n'êtes ni du secrétariat ni du côté administrateur");
        }
    }

    /**
     * @return void
     * Permet au secréteriat de rejeter une convention
     */
    public static function rejeterConvention(): void
    {
        if(ConnexionUtilisateur::getTypeConnecte() == "Administrateurs" || ConnexionUtilisateur::getTypeConnecte() == "Secretariat"){
            $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtudiant']);
            if($formation->getConventionValidee() == false){
                $formation->setDateTransmissionConvention($_REQUEST['dateTransmission']);
                (new FormationRepository())->modifierObjet($formation);
                ControleurAdminMain::redirectionFlash("afficherConventionAValider", "success", "Convention rejetée");
            }else{
                ControleurAdminMain::redirectionFlash("afficherConventionAValider", "danger", "Cette convention a été validée");
            }
        }else{
              ControleurAdminMain::redirectionFlash("afficherAccueilAdmin","danger","Vous n'êtes ni du secrétariat ni du côté administrateur");
        }
    }

    /** Envoie un mail de demande de validation à tous les admins (pour l'instant) */
    public static function faireValiderConvention(): void
    {
        $numEtu = ConnexionUtilisateur::getNumEtudiantConnecte();
        $worked = VerificationEmail::envoiEmailValidationDeConventionAuxAdmins((new EtudiantRepository())->getObjectParClePrimaire($numEtu));
        if ($worked) ControleurEtuMain::redirectionFlash("afficherMaConvention", "success", "Demande envoyée !");
        else ControleurEtuMain::redirectionFlash("afficherMaConvention", "warning", "Échec de l'envoi... Contacter un administrateur.");
    }

}
