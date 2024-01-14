<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;

class ServicePersonnel
{
    /**
     * @return void permet à un admin de promouvoir un prof
     */
    public static function promouvoirProf(): void
    {
        if (isset($_REQUEST["loginProf"])) {
            $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($_REQUEST['loginProf']);
            if (!is_null($prof)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$prof->isEstAdmin()) {
                        $prof->setEstAdmin(true);
                        (new \App\FormatIUT\Modele\Repository\ProfRepository())->modifierObjet($prof);
                        ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "success", "Permissions mises à jour");
                    } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur est déjà administrateur");
                } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Le professeur n'est pas renseigné");
    }

    /**
     * @return void permet à un admin de rétrograder un prof
     */
    public static function retrograderProf(): void
    {
        if (isset($_REQUEST["loginProf"])) {
            $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($_REQUEST['loginProf']);
            if (!is_null($prof)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if ($prof->isEstAdmin()) {
                        $prof->setEstAdmin(false);
                        (new \App\FormatIUT\Modele\Repository\ProfRepository())->modifierObjet($prof);
                        ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "success", "Permissions mises à jour");
                    } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'est pas administrateur");
                } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherProfilAdmin", "danger", "Le professeur n'est pas renseigné");
    }

    /**
     * @return void permet à un prof de se proposer en tant que tuteur sur une formation
     */
    public static function seProposerEnTuteurUM(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs" || ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
            $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtu']);
            if ($formation) {
                if ($formation->getloginTuteurUM() == null) {
                    $formation->setloginTuteurUM(ConnexionUtilisateur::getLoginUtilisateurConnecte());
                    (new FormationRepository())->modifierObjet($formation);
                    ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "success", "Vous vous êtes bien proposé en tuteur.");
                } else {
                    ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "warning", "Cet étudiant a déjà un tuteur de l'UM");
                }
            } else {
                ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "warning", "Cet étudiant n'a pas de formation");
            }
        } else {
            ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "danger", "Vous n'êtes pas un enseignant");
        }
    }

    /**
     * @return void
     * <br><br>
     * Passe l'attribut TuteurUMvalide à true;
     */
    public static function validerTuteurUM(): void
    {
        if (!isset($_GET['eleveId'])) {
            ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "danger", "L'élève ID n'est pas renseigné.");
            return;
        }
        $etuID = $_GET['eleveId'];

        if (ConnexionUtilisateur::getTypeConnecte() != "Administrateurs") {
            ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "danger", "Vous n'avez pas les droits nécessaires. Cet incident sera reporté.");
            return;
        }

        /** @var Formation $offreValide */
        $offreValide = (new EtudiantRepository())->getOffreValidee($etuID);
        if (is_null($offreValide)) {
            ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "danger", "L'élève n'existe pas,, ou n'a pas d'offre valide.");
            return;
        }

        $offreValide->setTuteurUMvalide(true);
        (new FormationRepository())->modifierObjet($offreValide);

        ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "success", "Le tuteur est désormais validé !");
    }

    /**
     * @return void
     */
    public static function refuserTuteurUM(): void
    {
        if (!isset($_GET['eleveId'])) {
            ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "danger", "L'élève ID n'est pas renseigné.");
            return;
        }
        $etuID = $_GET['eleveId'];

        /** @var Formation $offreValide */
        $offreValide = (new EtudiantRepository())->getOffreValidee($etuID);
        if (is_null($offreValide)) {
            ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "danger", "L'élève n'existe pas,, ou n'a pas d'offre valide.");
            return;
        }

        $offreValide->setloginTuteurUM(null);
        (new FormationRepository())->modifierObjet($offreValide);

        ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "success", "Le tuteur a été refusé avec succès.");
    }

    /**
     * @return array
     * Retourne un array contenant toutes les valeurs nécessaires pour la vue statistiques d'admin
     */
    public static function recupererStats(): array
    {
        $nbEtudiants = (new EtudiantRepository())->nbElementsDistincts("numEtudiant");
        $nbEtudiantsPostulant = (new PostulerRepository())->nbElementsDistincts("numEtudiant");
        $nbEtudiantsAvecFormation = (new FormationRepository())->nbElementsDistincts("idEtudiant");
        $nbEntreprises = (new EntrepriseRepository())->nbElementsDistincts("numSiret");
        $nbEntreprisesSansOffre = $nbEntreprises - (new FormationRepository())->nbElementsDistincts("idEntreprise");
        $nbOffresMoyen = (new FormationRepository())->nbMoyenOffresParEntreprise();
        $nbFormations = (new FormationRepository())->nbElementsDistincts("idFormation");
        $nbStages = (new FormationRepository())->nbElementsDistinctsQuandContient("typeOffre", "Stage");
        $nbAlternances = (new FormationRepository())->nbElementsDistinctsQuandContient("typeOffre", "Alternance");
        $nbOffresNonValidees = (new FormationRepository())->nbElementsDistinctsQuandEgal("offreValidee", 0);
        $nbOffresAvecEtudiant = (new FormationRepository())->nbElementsDistincts("idEtudiant");
        $nbOffresConventionNonValidee = (new FormationRepository())->nbElementsDistinctsQuandEgal("conventionValidee", 0);
        return ["nbEtudiants" => $nbEtudiants, "nbEtudiantsPostulant" => $nbEtudiantsPostulant, "nbEtudiantsAvecFormation" => $nbEtudiantsAvecFormation,
            "nbEntreprises" => $nbEntreprises, "nbEntreprisesSansOffre" => $nbEntreprisesSansOffre, "nbOffresMoyen" => $nbOffresMoyen,
            "nbFormations" => $nbFormations, "nbStages" => $nbStages, "nbAlternances" => $nbAlternances, "nbOffresNonValidees" => $nbOffresNonValidees,
            "nbOffresAvecEtudiant" => $nbOffresAvecEtudiant, "nbOffresConventionNonValidee" => $nbOffresConventionNonValidee];
    }

    /**
     * @return array
     * Retourne un array contenant toutes les valeurs nécessaires pour la vue historique d'admin
     */
    public static function recupererHisto(): array
    {
        $nbEtuAvecFormAnneeDerniere = AbstractRepository::lancerFonctionHistorique("nbEtuAvecFormAnneeDerniere");
        $nbMoyenEtuAvecForm = AbstractRepository::lancerFonctionHistorique("nbMoyenEtuAvecForm");
        $nbEntreAnneeDerniere = AbstractRepository::lancerFonctionHistorique("nbEntreAnneeDerniere");
        $nbMoyenEntrQuiPosteOffre = AbstractRepository::lancerFonctionHistorique("nbMoyenEntrQuiPosteOffre");
        $nbEntrSansOffreAnneeDerniere = AbstractRepository::lancerFonctionHistorique("nbEntrSansOffreAnneeDerniere");
        $nbMoyenOffresChaqueAnnee = AbstractRepository::lancerFonctionHistorique("nbMoyenOffresChaqueAnnee");
        $nbOffresAnneeDerniere = AbstractRepository::lancerFonctionHistorique("nbOffresAnneeDerniere");
        $nbOffresSansConvValideeAnneeDerniere = AbstractRepository::lancerFonctionHistorique("nbOffresSansConvValideeAnneeDerniere");
        return ["nbEtuAvecFormAnneeDerniere" => $nbEtuAvecFormAnneeDerniere, "nbMoyenEtuAvecForm" => $nbMoyenEtuAvecForm,
            "nbEntreAnneeDerniere" => $nbEntreAnneeDerniere, "nbMoyenEntrQuiPosteOffre" => $nbMoyenEntrQuiPosteOffre, "nbEntrSansOffreAnneeDerniere" => $nbEntrSansOffreAnneeDerniere,
            "nbMoyenOffresChaqueAnnee" => $nbMoyenOffresChaqueAnnee, "nbOffresAnneeDerniere" => $nbOffresAnneeDerniere, "nbOffresSansConvValideeAnneeDerniere" => $nbOffresSansConvValideeAnneeDerniere];
    }

    /**
     * @return void met à jour les informations de l'admin connecté
     */
    public static function mettreAJour(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs" || ConnexionUtilisateur::getTypeConnecte() == "Personnels" || ConnexionUtilisateur::getTypeConnecte() == "Secretariat") {
            ControleurAdminMain::updateImage();
            (new ProfRepository())->mettreAJourInfos($_REQUEST['nom'], $_REQUEST['prenom'], ConnexionUtilisateur::getLoginUtilisateurConnecte());
            ControleurAdminMain::redirectionFlash('afficherProfil', "success", "Informations modifiées");
        } else {
            ControleurAdminMain::redirectionFlash("afficherProfil", "danger", "Vous n'avez pas les droits requis");
        }
    }
}