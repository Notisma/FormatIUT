<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\EntrepriseFake;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\DataObject\Postuler;
use App\FormatIUT\Modele\DataObject\TuteurPro;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\EntrepriseFakeRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Modele\Repository\TuteurProRepository;
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
                        if ($formation->getDateTransmissionConvention() != null) {
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
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs" || ConnexionUtilisateur::getTypeConnecte() == "Secretariat") {
            $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtudiant']);
            if ($formation->getConventionValidee() == false) {
                $formation->setDateTransmissionConvention($_REQUEST['dateTransmission']);
                (new FormationRepository())->modifierObjet($formation);
                ControleurAdminMain::redirectionFlash("afficherConventionAValider", "success", "Convention rejetée");
            } else {
                ControleurAdminMain::redirectionFlash("afficherConventionAValider", "danger", "Cette convention a été validée");
            }
        } else {
            ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "danger", "Vous n'êtes ni du secrétariat ni du côté administrateur");
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

    /**
     * @return void creer une convention où l'entreprise n'est pas présente dans la bd
     */
    public static function creerConventionSansEntreprise()
    {
        /* echo '<pre>';
         print_r($_REQUEST);
         echo '</pre>';*/

        if (ConnexionUtilisateur::getTypeConnecte() == "Etudiants") {
            $login = ConnexionUtilisateur::getNumEtudiantConnecte();
            if (
                isset($_REQUEST['typeOffre']) && $_REQUEST['typeOffre'] != "" &&
                isset($_REQUEST['siret']) && $_REQUEST['siret'] != "" &&
                isset($_REQUEST['nomEntreprise']) && $_REQUEST['nomEntreprise'] != "" &&
                isset($_REQUEST['adresseEntr']) && $_REQUEST['adresseEntr'] != "" &&
                isset($_REQUEST['villeEntr']) && $_REQUEST['villeEntr'] != "" &&
                isset($_REQUEST['telEntreprise']) && $_REQUEST['telEntreprise'] != "" &&
                isset($_REQUEST['emailEntreprise']) && $_REQUEST['emailEntreprise'] != "" &&
                isset($_REQUEST['offreSujet']) && $_REQUEST['offreSujet'] != "" &&
                isset($_REQUEST['offreDateDebut']) && $_REQUEST['offreDateDebut'] != "" &&
                isset($_REQUEST['offreDateFin']) && $_REQUEST['offreDateFin'] != "" &&
                isset($_REQUEST['etudiantAnneeEtu']) && $_REQUEST['etudiantAnneeEtu'] != "" &&
                isset($_REQUEST['etudiantParcours']) && $_REQUEST['etudiantParcours'] != "" &&
                isset($_REQUEST['offreDureeHeure']) && $_REQUEST['offreDureeHeure'] != "" &&
                isset($_REQUEST['offreGratification']) && $_REQUEST['offreGratification'] != "" &&
                isset($_REQUEST['assurance']) && $_REQUEST['assurance'] != "" &&
                isset($_REQUEST['nomTuteurPro']) && $_REQUEST['nomTuteurPro'] != "" &&
                isset($_REQUEST['prenomTuteurPro']) && $_REQUEST['prenomTuteurPro'] != ""
            ) {
                $formation = (new FormationRepository())->trouverOffreDepuisForm($login);
                if (!$formation) {
                    $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
                    if (!$entreprise) {

                        $villeEntr = (new VilleRepository())->getVilleParNom2($_REQUEST['villeEntr']);
                        if (!$villeEntr) {
                            $listeVille = (new VilleRepository())->getListeObjet();
                            $villeEntr = new Ville(sizeof($listeVille) + 1, $_REQUEST['villeEntr'], null);
                            (new VilleRepository())->creerObjet($villeEntr);
                        }

                        $idville = strval($villeEntr->getIdVille());
                        $entrepriseFake = new EntrepriseFake($_REQUEST['siret'], $_REQUEST['nomEntreprise'], null, null
                            , null, $_REQUEST['telEntreprise'], $_REQUEST['adresseEntr'], $idville, $_REQUEST['emailEntreprise']);
                        $entrepriseFakeVerif = (new EntrepriseFakeRepository())->getObjectParClePrimaire($entrepriseFake->getSiret());
                        if (!$entrepriseFakeVerif) {
                            (new EntrepriseFakeRepository())->creerObjet($entrepriseFake);
                        }
                        $tuteurliste = (new TuteurProRepository())->getListeObjet();
                        $idTuteur = "TP" . sizeof($tuteurliste) + 1;
                        $tuteurInserer = new TuteurPro($idTuteur, "", "", "", $_REQUEST['nomTuteurPro'], $_REQUEST['prenomTuteurPro'], $_REQUEST['siret']);
                        (new TuteurProRepository())->creerObjet($tuteurInserer);
                        $postuler = new Postuler($login, $_REQUEST['siret'], "Validée", null, null);
                        (new PostulerRepository())->creerObjet($postuler);
                        $formation = new Formation(null, "", $_REQUEST['offreDateDebut'], $_REQUEST['offreDateFin'], $_REQUEST['offreSujet'], $_REQUEST['etudiantAnneeEtu'],
                            $_REQUEST['offreDureeHeure'], null, $_REQUEST['offreGratification'], "euros", null, null, true, "", $_REQUEST['dateCreation'],
                            $_REQUEST['typeOffre'], $_REQUEST['etudiantAnneeEtu'], $_REQUEST['etudiantAnneeEtu'], true, false, null, false, $_REQUEST['dateCreation'],
                            null, false, $_REQUEST['assurance'], null, $login, $idTuteur, $_REQUEST['siret'], null, false);
                        (new FormationRepository())->creerObjet($formation);
                        ControleurEtuMain::redirectionFlash("afficherMaConvention", "success", "Vous avez créé votre convention");

                    } else {
                        ControleurEtuMain::redirectionFlash("afficherFormulaireConventionSansEntreprise", "warning", "Cette entreprise a déjà un compte");
                    }

                } else {
                    ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Vous ne pouvez pas créer une convention alors que vous avez déjà une formation");
                }

            } else {
                ControleurEtuMain::redirectionFlash("afficherFormulaireConventionSansEntreprise", "warning", "Vous n'avez pas rempli tout les champs du formulaire");
            }
        } else {
            ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "danger", "Erreur vous n'êtes pas un étudiant");
        }
    }

}
