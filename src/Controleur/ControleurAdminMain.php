<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\InsertionCSV;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\pstageRepository;

class ControleurAdminMain extends ControleurMain
{
    private static string $pageActuelleAdmin = "Accueil Admin";

    /**
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
     */
    public static function getMenu(): array
    {
        $accueil = "";
        if (ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
            $accueil = "Personnels";
        } else if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            $accueil = "Administrateurs";
        }
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil $accueil", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/liste.png", "label" => "Liste des Offres", "lien" => "?action=afficherListeOffres&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),
        );
        if (ConnexionUtilisateur::getTypeConnecte()=="Administrateurs"){
            $menu[] = array("image" => "../ressources/images/document.png", "label" => "Mes CSV", "lien" => "?action=afficherVueCSV&controleur=AdminMain");
        }

        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain");
        }

        if (self::$pageActuelleAdmin == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
        }

        if (self::$pageActuelleAdmin == "Détails d'un Étudiant") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Détails d'un Étudiant", "lien" => "?action=afficherDetailEtudiant");
        }

        if (self::$pageActuelleAdmin == "Détails d'une Entreprise") {
            $menu[] = array("image" => "../ressources/images/equipe.png", "label" => "Détails d'une Entreprise", "lien" => "?action=afficherDetailEntreprise");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter");

        return $menu;
    }


    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour un Administrateur connecté
     */
    public static function afficherAccueilAdmin(): void
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsSansOffres();
        $listeEntreprises = (new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres = (new FormationRepository())->offresNonValides();
        $accueil = "Administrateurs";
        if (ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
            $accueil = "Personnels";
        }
        self::$pageActuelleAdmin = "Accueil Administrateurs";
        self::afficherVue("Accueil $accueil", "Admin/vueAccueilAdmin.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises, "listeOffres" => $listeOffres, "listeEtudiants" => $listeEtudiants]);
    }


    /**
     * @return void affiche le profil de l'administrateur connecté
     */
    public static function afficherProfilAdmin(): void
    {
        self::$pageActuelleAdmin = "Mon Compte";
        self::afficherVue("Mon Compte", "Admin/vueCompteAdmin.php", self::getMenu());
    }

    /**
     * @return void affiche les informations d'un étudiant
     */
    public static function afficherDetailEtudiant(): void
    {
        self::$pageActuelleAdmin = "Détails d'un Étudiant";
        self::afficherVue("Détails d'un Étudiant", "Admin/vueDetailEtudiant.php", self::getMenu());
    }

    /**
     * @return void affiche la liste des étudiants
     */
    public static function afficherListeEtudiant(): void
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsEtats();
        self::$pageActuelleAdmin = "Liste Étudiants";
        self::afficherVue("Liste Étudiants", "Admin/vueListeEtudiants.php", self::getMenu(), ["listeEtudiants" => $listeEtudiants]);
    }

    /**
     * @return void affiche les informations d'une entreprise
     */
    public static function afficherDetailEntreprise(): void
    {
        self::$pageActuelleAdmin = "Détails d'une Entreprise";
        self::afficherVue("Détails d'une Entreprise", "Admin/vueDetailEntreprise.php", self::getMenu());
    }

    /**
     * @return void affiche la liste des entreprises
     */
    public static function afficherListeEntreprises(): void
    {
        $listeEntreprises = (new EntrepriseRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste Entreprises";
        self::afficherVue("Liste Entreprises", "Admin/vueListeEntreprises.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises]);
    }

    /**
     * @return void affiche la page d'importation et d'exportation des csv
     */
    public static function afficherVueCSV(): void
    {
        self::$pageActuelleAdmin = "Mes CSV";
        self::afficherVue("Mes CSV", "Admin/vueCSV.php", self::getMenu());
    }

    public static function afficherListeOffres(): void
    {
        $listeOffres = (new FormationRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste des Offres";
        self::afficherVue("Liste des Offres", "Admin/vueListeOffres.php", self::getMenu(), ["listeOffres" => $listeOffres]);
    }

    /**
     * @return void affiche la page d'ajout d'un étudiant
     */

    public static function afficherFormulaireCreationEtudiant(): void
    {
        self::$pageActuelleAdmin = "Ajouter un étudiant";
        self::afficherVue("Ajouter un étudiant", "Admin/vueFormulaireCreationEtudiant.php", self::getMenu());
    }

    //FONCTIONS D'ACTIONS ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void permet à l'admin connecté d'importer un fichier csv
     */
    public static function ajouterCSV(): void
    {
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        fgetcsv($csvFile);

        while (($ligne = fgetcsv($csvFile)) !== FALSE) {
            $taille = sizeof($ligne);
            if ($taille == 82) {
                InsertionCSV::insererPstage($ligne);
            } else if ($taille == 143) {
                InsertionCSV::insererStudea($ligne);
            } else if ($taille == 18) {
                $listeId = (new FormationRepository())->getListeidFormations();
                $idFormation = self::autoIncrement($listeId, "idFormation");
                InsertionCSV::insererSuiviSecretariat($ligne, $idFormation);
            } else {
                self::redirectionFlash("afficherVueCSV", "warning", "le fichier csv est incompatible pour l'instant (n'accepte que pstage/studea).");
                return;
            }
        }
        fclose($csvFile);

        self::afficherAccueilAdmin();
    }

    /**
     * @return void permet à l'admin connecté d'exporter un fichier csv
     */
    public static function exporterCSV(): void
    {
        $tab = (new pstageRepository())->exportCSV();

        $delimiter = ",";
        $filename = "sae-data_" . date('Y-m-d') . ".csv";
        $f = fopen('php://memory', 'w');

        $champs = array('prenomEtudiant', 'nomEtudiant', 'numEtudiant', 'EmailEtu', 'groupe', 'parcours', 'validationPedagogique', 'Type de formation', 'Date creation de la convention', 'Date de transmission de la convention',
            'Date début de stage', 'Date fin de stage', 'Structure accueil', 'Tuteur email', 'Avenant/Remarque', 'Présence au forum de l IUT', 'Tuteur univ');
        fputcsv($f, $champs, $delimiter);

        foreach ($tab as $ligne) {

            fputcsv($f, $ligne, $delimiter);
        }
        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
        fclose($f);
    }

    /**
     * @return void permet à l'admin connecté de valider une offre
     */
    public static function accepterOffre(): void
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
                    } else self::redirectionFlash("afficherVueDetailOffre", "warning", "L'offre est déjà valider");
                } else self::redirectionFlash("afficherVueDetailOffre", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherListeOffres", "warning", "L'offre n'existe pas");
        } else self::redirectionFlash("afficherListeOffres", "danger", "L'offre n'est pas renseignée");
    }

    /**
     * @return void permet à l'admin connecté de refuser une offre
     */
    public static function rejeterOffre(): void
    {
        if (isset($_REQUEST["idFormation"])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            if (!is_null($offre)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$offre->getEstValide()) {
                        (new FormationRepository())->supprimer($offre->getidFormation());
                        self::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été rejetée");
                    } else self::redirectionFlash("afficherVueDetailOffre", "warning", "L'offre est déjà accepter");
                } else self::redirectionFlash("afficherVueDetailOffre", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherListeOffres", "warning", "L'offre n'existe pas");
        } else self::redirectionFlash("afficherListeOffres", "danger", "L'offre n'est pas renseignée");
    }

    /**
     * @return void permet à l'admin connecté de supprimer(archiver) une offre
     */
    public static function supprimerOffre(): void
    {
        if (isset($_REQUEST["idFormation"])) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
            if (!is_null($offre)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    (new FormationRepository())->supprimer($_REQUEST['idFormation']);
                    self::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été supprimée");
                } else self::redirectionFlash("afficherVueDetailOffre", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherListeOffres", "warning", "L'offre n'existe pas");
        } else self::redirectionFlash("afficherListeOffres", "danger", "L'offre n'est pas renseignée");
    }

    /**
     * @return void permet à l'admin connecté d'ajouter un étudiant avec ses informations primordiales
     */

    public static function ajouterEtudiant(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            if ((new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtudiant']) != null) {
                self::redirectionFlash("afficherFormulaireCreationEtudiant", "warning", "Un étudiant avec ce numéro existe déjà");
            }
            else {
                $_REQUEST['loginEtudiant'] = strtolower($_REQUEST['loginEtudiant']);
                $_REQUEST['sexeEtu'] = null;
                $_REQUEST['mailPerso'] = null;
                $_REQUEST['telephone'] = null;
                $_REQUEST['validationPedagogique'] = 0;
                $_REQUEST['presenceForumIUT'] = 0;
                $_REQUEST['img_id'] = 1;
                $etudiant = (new EtudiantRepository())->construireDepuisTableau($_REQUEST);
                (new EtudiantRepository())->creerObjet($etudiant);
                self::redirectionFlash("afficherAccueilAdmin", "success", "L'étudiant a bien été ajouté");
            }
        }
    }

    /**
     * @return void permet à l'admin connecté de supprimer(archiver) un étudiant
     */
    public static function supprimerEtudiant(): void
    {
        if (isset($_REQUEST["numEtu"])) {
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtu']);
            if (!is_null($etudiant)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    (new EtudiantRepository())->supprimer($_REQUEST['numEtu']);
                    self::redirectionFlash("afficherListeEtudiant", "success", "L'étudiant a bien été supprimé");
                } else self::redirectionFlash("afficherDetailEtudiant", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherListeEtudiant", "warning", "L'étudiant n'existe pas");
        } else self::redirectionFlash("afficherListeEtudiant", "danger", "L'étudiant n'est pas renseigné");

    }

    /**
     * @return void permet à l'admin connecté de refuser une entreprise
     */
    public static function refuserEntreprise(): void
    {
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {

                    if (!$entreprise->isEstValide()) {
                        (new EntrepriseRepository())->supprimer($entreprise->getSiret());
                        self::redirectionFlash("afficherListeEntreprises", "success", "L'entreprise a bien été refusée");
                    } else self::redirectionFlash("afficherDetailEntreprise", "warning", "L'entreprise est déjà validé");
                } else self::redirectionFlash("afficherDetailEntreprise", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherListeEntreprises", "warning", "L'entreprise n'existe pas");
        } else self::redirectionFlash("afficherListeEntreprises", "danger", "L'entreprise n'est pas renseignée");

    }

    /**
     * @return void permet à l'admin connecté de valider une entreprise
     */
    public static function validerEntreprise(): void
    {
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$entreprise->isEstValide()) {
                        $entreprise->setEstValide(true);
                        (new EntrepriseRepository())->modifierObjet($entreprise);
                        self::redirectionFlash("afficherAccueilAdmin", "success", "L'entreprise a bien été validée");
                    } else self::redirectionFlash("afficherDetailEntreprise", "warning", "L'entreprise est déjà valider");
                } else self::redirectionFlash("afficherDetailEntreprise", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherListeEntreprises", "warning", "L'entreprise n'existe pas");
        } else self::redirectionFlash("afficherListeEntreprises", "danger", "L'entreprise n'est pas renseignée");
    }

    /**
     * @return void permet à l'entreprise de supprimer (archiver) une entreprise
     */
    public static function supprimerEntreprise(): void
    {
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    (new EntrepriseRepository())->supprimer($_REQUEST['siret']);
                    self::redirectionFlash("afficherListeEntreprises", "success", "L'entreprise a bien été supprimé");
                } else self::redirectionFlash("afficherDetailEntreprise", "danger", "Vous n'avez pas les drois requis");
            } else self::redirectionFlash("afficherListeEntreprises", "warning", "L'entreprise n'existe pas");
        } else self::redirectionFlash("afficherListeEntreprises", "danger", "L'entreprise n'est pas renseignée");
    }


    public static function promouvoirProf() : void {
        if (isset($_REQUEST["loginProf"])) {
            $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($_REQUEST['loginProf']);
            if (!is_null($prof)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    if (!$prof->isEstAdmin()) {
                        $prof->setEstAdmin(true);
                        (new \App\FormatIUT\Modele\Repository\ProfRepository())->modifierObjet($prof);
                        self::redirectionFlash("afficherProfilAdmin", "success", "Permissions mises à jour");
                    } else self::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur est déjà administrateur");
                } else self::redirectionFlash("afficherProfilAdmin", "danger", "Vous n'avez pas les droits requis");
            } else self::redirectionFlash("afficherProfilAdmin", "warning", "Le professeur n'existe pas");
        } else self::redirectionFlash("afficherProfilAdmin", "danger", "Le professeur n'est pas renseigné");
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

}
