<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\InsertionCSV;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\Repository\pstageRepository;

class ControleurAdminMain extends ControleurMain
{

    private static string $pageActuelleAdmin = "Accueil Admin";

    public static function afficherAccueilAdmin()
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsSansOffres();
        $listeEntreprises = (new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres = (new OffreRepository())->offresNonValides();
        self::$pageActuelleAdmin = "Accueil Administrateurs";
        self::afficherVue("Accueil Administrateurs", "Admin/vueAccueilAdmin.php", self::getMenu(), ["listeEntreprises" => $listeEntreprises, "listeOffres" => $listeOffres, "listeEtudiants" => $listeEtudiants]);
    }

    public static function afficherProfilAdmin()
    {
        self::$pageActuelleAdmin = "Mon Compte";
        self::afficherVue("Mon Compe", "Admin/vueCompteAdmin.php", self::getMenu());
    }

    public static function afficherDetailEtudiant()
    {
        self::$pageActuelleAdmin = "Détails d'un Étudiant";
        self::afficherVue("Détails d'un Étudiant", "Admin/vueDetailEtudiant.php", self::getMenu());
    }

    public static function afficherListeEtudiant()
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsEtats();
        self::$pageActuelleAdmin = "Liste Étudiants";
        self::afficherVue("Liste Étudiants", "Admin/vueListeEtudiants.php", self::getMenu(), ["listeEtudiants" => $listeEtudiants]);
    }

    public static function afficherDetailEntreprise()
    {
        self::$pageActuelleAdmin = "Détails d'une Entreprise";
        self::afficherVue("Détails d'une Entreprise", "Admin/vueDetailEntreprise.php", self::getMenu());
    }

    public static function afficherListeEntreprises(): void
    {
        self::$pageActuelleAdmin = "Liste Entreprises";
        self::afficherVue("Liste Entreprises", "Admin/vueListeEntreprises.php", self::getMenu());
    }

    public static function afficherVueCSV(): void
    {
        self::$pageActuelleAdmin = "Mes CSV";
        self::afficherVue("Mes CSV", "Admin/vueCSV.php", self::getMenu());
    }

    public static function ajouterCSV(): void
    {
        $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

        fgetcsv($csvFile);

        while (($ligne = fgetcsv($csvFile)) !== FALSE) {
            if (sizeof($ligne) == 82) {
                InsertionCSV::insererPstage($ligne);
            } else if (sizeof($ligne) == 143) {
                InsertionCSV::insererStudea($ligne);
            } else {
                self::redirectionFlash("afficherVueCSV", "warning", "le fichier csv est incompatible pour l'instant (n'accepte que pstage/studea).");
                return;
            }
        }
        fclose($csvFile);

        self::afficherAccueilAdmin();
    }

    public static function exporterCSV()
    {
        $tab = (new pstageRepository())->exportCSV();

        $delimiter = ",";
        $filename = "sae-data_" . date('Y-m-d') . ".csv";
        $f = fopen('php://memory', 'w');

        $champs = array('numEtudiant', 'prenomEtudiant', 'nomEtudiant', 'sexeEtu', 'mailUniversitaire', 'mailPerso', 'tel Etu', 'groupe', 'parcours', 'Nom ville etudiant', 'Code postal Etudiant', 'nomOffre', 'dateDebut', 'dateFin', 'sujetOffre', 'gratification', 'dureeHeures', 'Type de loffre', 'Etat de l offre', 'Siret', 'nomEntreprise', 'StatutJurique', 'Effectif', 'code NAF', 'telEntreprise', 'Ville Entreprise', 'Code postal Entreprise');
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

    public static function getMenu(): array
    {
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Administrateurs", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/liste.png", "label" => "Liste des Offres", "lien" => "?action=afficherListeOffres&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),
            array("image" => "../ressources/images/document.png", "label" => "Mes CSV", "lien" => "?action=afficherVueCSV&controleur=AdminMain"),


        );

        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain");
        }

        if (self::$pageActuelleAdmin == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/mon-compte.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
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


    public static function accepterOffre(): void
    {
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
        $offre->setEstValide(true);
        (new OffreRepository())->modifierObjet($offre);
        header("Location: ?action=afficherAccueilAdmin&controleur=AdminMain&idOffre=" . $offre->getIdOffre());
        MessageFlash::ajouter("success", "L'offre a bien été validée");
    }


    public static function rejeterOffre(): void
    {
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
        (new OffreRepository())->supprimer($offre->getIdOffre());
        self::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été rejetée");
    }

    public static function supprimerOffre(): void
    {
        //TODO : FAIRE LES VERIFICATIONS
        $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
        (new OffreRepository())->supprimer($_REQUEST['idOffre']);
        self::redirectionFlash("afficherAccueilAdmin", "success", "L'offre a bien été supprimée");
    }

    public static function supprimerEtudiant(): void
    {
        //TODO : FAIRE LES VERIFICATIONS
        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtu']);
        (new EtudiantRepository())->supprimer($_REQUEST['numEtu']);
        self::redirectionFlash("afficherAccueilAdmin", "success", "L'étudiant a bien été supprimé");
    }

    public static function refuserEntreprise(): void
    {
        //TODO : rajouter des éléments
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (!$entreprise->estValide()) {
                    (new EntrepriseRepository())->supprimer($entreprise->getSiret());
                    MessageFlash::ajouter("success", "L'entreprise a bien été refusée");
                } else MessageFlash::ajouter("info", "L'entreprise est déjà validée");
            } else MessageFlash::ajouter("info", "L'entreprise n'existe pas");
        } else MessageFlash::ajouter("danger", "L'entreprise n'est pas renseigné");
        header("Location: ?action=afficherAccueilAdmin&controleur=AdminMain");

    }

    public static function validerEntreprise(): void
    {
        //TODO : rajouter des vérifications
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                if (!$entreprise->estValide()) {
                    $entreprise->setEstValide(true);
                    (new EntrepriseRepository())->modifierObjet($entreprise);
                    MessageFlash::ajouter("success", "L'entreprise a bien été validée");
                } else MessageFlash::ajouter("info", "L'entreprise est déjà valider");
            } else MessageFlash::ajouter("info", "L'entreprise n'existe pas");
        } else MessageFlash::ajouter("danger", "L'entreprise n'est pas renseigné");
        header("Location: ?action=afficherAccueilAdmin&controleur=AdminMain");

    }

    public static function supprimerEntreprise(): void
    {
        //TODO : FAIRE LES VERIFICATIONS
        if (isset($_REQUEST["siret"])) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST['siret']);
            if (!is_null($entreprise)) {
                (new EntrepriseRepository())->supprimer($_REQUEST['siret']);
                MessageFlash::ajouter("success", "L'entreprise a bien été supprimée");
            } else MessageFlash::ajouter("info", "L'entreprise n'existe pas");
        } else {
            MessageFlash::ajouter("danger", "L'entreprise n'est pas renseigné");
        }
        header("Location: ?action=afficherAccueilAdmin&controleur=AdminMain");
    }
}