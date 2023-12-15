<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurEtuMain;
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
                    if ($entrepriseVerif->getSiret() == $offreVerif->getSiret()) {
                        $villeEntr = (new VilleRepository())->getVilleParIdVilleEntr($entrepriseVerif->getSiret());
                        if ((trim($entrepriseVerif->getNomEntreprise()) == trim($_REQUEST['nomEntreprise'])) && (trim($entrepriseVerif->getAdresseEntreprise()) == trim($_REQUEST['adresseEntr'])) && (trim($villeEntr->getNomVille()) == trim($_REQUEST['villeEntr'])) && ($villeEntr->getCodePostal() == $_REQUEST['codePostalEntr'])) {
                            if ($offreVerif->getDateDebut() == new DateTime($_REQUEST['dateDebut']) && $offreVerif->getDateFin() == new DateTime($_REQUEST['dateFin'])) {
                                $clefPrimConv = 'C' . (new ConventionRepository())->getNbConvention() + 1;
                                $convention = Convention::creerConvention($_REQUEST,$clefPrimConv,$offreVerif->getTypeOffre());
                                (new ConventionRepository())->creerObjet($convention);
                                if (!(new EtudiantRepository())->aUneFormation(ControleurEtuMain::getCleEtudiant())) {
                                    $formation = (new FormationRepository())->construireDepuisTableau(['idFormation' => ($offreVerif->getidFormation()), "dateDebut" => date_format($offreVerif->getDateDebut(), "Y-m-d"),
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