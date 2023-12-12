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
use App\FormatIUT\Modele\Repository\pstageRepository;
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
                    if ($entrepriseVerif->getSiret() == $offreVerif->getSiret()) {
                        $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entrepriseVerif->getSiret());
                        if ((trim($entrepriseVerif->getNomEntreprise()) == trim($_REQUEST['nomEntreprise'])) && (trim($entrepriseVerif->getAdresseEntreprise()) == trim($_REQUEST['adresseEntr'])) && (trim($villeEntr->getNomVille()) == trim($_REQUEST['villeEntr'])) && ($villeEntr->getCodePostal() == $_REQUEST['codePostalEntr'])) {
                            if ($offreVerif->getDateDebut() == new DateTime($_REQUEST['dateDebut']) && $offreVerif->getDateFin() == new DateTime($_REQUEST['dateFin'])) {
                                $clefPrimConv = 'C' . (new ConventionRepository())->getNbConvention() + 1;
                                $convention = (new ConventionRepository())->construireDepuisTableau(["idConvention" => $clefPrimConv,
                                    "conventionValidee" => 0, "dateCreation" => $_REQUEST['dateCreation'], "dateTransmission" => $_REQUEST['dateCreation'],
                                    "retourSigne" => 1, "assurance" => $_REQUEST['assurance'], "objectifOffre" => $_REQUEST['objfOffre'], "typeConvention" => $offreVerif->getTypeOffre()]);
                                (new ConventionRepository())->creerObjet($convention);
                                if (!(new EtudiantRepository())->aUneFormation(ControleurEtuMain::getCleEtudiant())) {
                                    $formation = (new FormationRepository())->construireDepuisTableau(['idFormation' => ('F' . $offreVerif->getidFormation()), "dateDebut" => date_format($offreVerif->getDateDebut(), "Y-m-d"),
                                        "dateFin" => date_format($offreVerif->getDateFin(), "Y-m-d"), "idEtudiant" => ControleurEtuMain::getCleEtudiant(), "idTuteurPro" => null, "idEntreprise" => $entrepriseVerif->getSiret(), "idConvention" => $convention->getIdConvention(), "idTuteurUM" => null,
                                    ]);
                                    (new FormationRepository())->creerObjet($formation);
                                } else {
                                    (new FormationRepository())->ajouterConvention(ControleurEtuMain::getCleEtudiant(), $convention->getIdConvention());
                                }
                                ControleurEtuMain::redirectionFlash("afficherAccueilEtu", "success", "Convention créée");
                            } else {
                                ControleurEtuMain::afficherErreur("Erreur sur les dates");
                            }
                        } else {
                            ControleurEtuMain::afficherErreur("Erreur sur les informations de l'entreprise");
                        }
                    } else {
                        ControleurEtuMain::afficherErreur("L'entreprise n'a jamais créé cette offre");
                    }
                } else {
                    ControleurEtuMain::afficherErreur("Erreur l'entreprise n'existe pas");
                }
            } else {
                ControleurEtuMain::afficherErreur("Erreur nombre(s) négatif(s) présent(s)");
            }
        } else {
            ControleurEtuMain::afficherErreur("Aucune offre est liée à votre convention");
        }
    }
}