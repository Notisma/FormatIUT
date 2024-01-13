<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\InsertionCSV;
use App\FormatIUT\Modele\DataObject\Postuler;
use App\FormatIUT\Modele\Repository\ConventionRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Modele\Repository\CSV_Utils;
use App\FormatIUT\Modele\Repository\VilleRepository;
use DateTime;
use Exception;

class ServiceFichier
{

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
                $idFormation = ControleurMain::autoIncrement($listeId, "idFormation");
                InsertionCSV::insererSuiviSecretariat($ligne, $idFormation);
            } else {
                ControleurAdminMain::redirectionFlash("afficherVueCSV", "warning", "le fichier csv est incompatible pour l'instant (n'accepte que pstage/studea).");
                return;
            }
        }
        fclose($csvFile);

        ControleurAdminMain::afficherAccueilAdmin();
    }

    /**
     * @return void permet à l'admin connecté d'exporter un fichier csv
     */
    public static function exporterCSV(): void
    {
        $tab = (new CSV_Utils())->exportCSV();

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
     * @return void télécharge le Cv d'un étudiant sur une offre
     */
    public static function telechargerCV(): void
    {
        $cv = (new PostulerRepository())->recupererCV($_REQUEST['etudiant'], $_REQUEST['idFormation']);
        if (empty($cv))
            ControleurEntrMain::redirectionFlash("afficherVueDetailOffre", "warning", "Cet étudiant n'a pas fourni de CV.");
        else {
            $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['etudiant']);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=CV_de_' . $etu->getPrenomEtudiant() . '_' . $etu->getNomEtudiant() . '.pdf');
            readfile(Configuration::getUploadPathFromId($cv));
        }
    }

    /**
     * @return void télécharge la lettre de motivation d'un étudiant sur une offre
     */
    public static function telechargerLM(): void
    {
        $lm = (new PostulerRepository())->recupererLettre($_REQUEST['etudiant'], $_REQUEST['idFormation']);
        if (empty($lm))
            ControleurEntrMain::redirectionFlash("afficherVueDetailOffre", "warning", "Cet étudiant n'a pas fourni de lettre de motivation.");
        else {
            $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['etudiant']);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename=Lettre_de_motivation_de_' . $etu->getPrenomEtudiant() . '_' . $etu->getNomEtudiant() . '.pdf');
            readfile(Configuration::getUploadPathFromId($lm));
        }
    }

    /**
     * @return void modifie les Cv et Lettres de motivations de l'étudiant connecté pour une offre
     */
    public static function modifierFichiers(): void
    {
        $ids = ControleurEtuMain::uploadFichiers(['cv', 'lm'], "afficherMesOffres");
        (new PostulerRepository())->modifierObjet(new Postuler(ControleurEtuMain::getCleEtudiant(), $_REQUEST["idFormation"], "En attente", $ids['cv'], $ids['lm']));
        ControleurEtuMain::redirectionFlash("afficherMesOffres", "success", "Fichiers modifiés");
    }

}