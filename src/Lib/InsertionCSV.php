<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Modele\DataObject\ConventionStage;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\DataObject\TuteurPro;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use App\FormatIUT\Modele\Repository\ConventionStageRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;
use App\FormatIUT\Modele\Repository\TuteurProRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use App\FormatIUT\Service\ServiceConnexion;
use App\FormatIUT\Service\ServiceConvention;
use App\FormatIUT\Service\ServiceEntreprise;
use App\FormatIUT\Service\ServiceEtudiant;
use App\FormatIUT\Service\ServiceFichier;
use App\FormatIUT\Service\ServiceFormation;
use App\FormatIUT\Service\ServiceMdp;
use App\FormatIUT\Service\ServicePersonnel;
use App\FormatIUT\Service\ServicePostuler;
use App\FormatIUT\Service\ServiceRecherche;
use DateTime;

class InsertionCSV
{
    /**
     * @param $ligne
     * @return void permet d'insérer un CSV de pstage à la base de données
     */
    public static function insererPstage($ligne): void
    {
        $login = $ligne[2];
        $login .= $ligne[3][0]; //surement à changer si un étudiant a le même nom et le même prenom
        $login = strtolower($login);
        $etudiant = new Etudiant($ligne[1], $ligne[3], $ligne[2], $login, $ligne[42], $ligne[7], $ligne[6], $ligne[5], "XX", "XXXXX", 1, 1, 1);
        (new EtudiantRepository())->creerObjet($etudiant);

        $idVille = "";
        $ville = new Ville($idVille, $ligne[47], $ligne[45]);
        (new VilleRepository())->creerObjet($ville);

        $entreprise = new Entreprise($ligne[55], $ligne[54], $ligne[62], $ligne[64], $ligne[65], $ligne[66], $ligne[57], $idVille, 0, "", "", "", "", 0, "");
        (new EntrepriseRepository())->creerObjet($entreprise);

        $loginProf = $ligne[29];
        $loginProf .= $ligne[30][0];
        $prof = new Prof($loginProf, $ligne[29], $ligne[30], $ligne[31], 0, 1);
        (new ProfRepository())->creerObjet($prof);

        $idTuteur = "";
        $tuteur = new TuteurPro($idTuteur, $ligne[79], $ligne[80], $ligne[81], $ligne[77], $ligne[78], $ligne[55]);
        (new TuteurProRepository())->creerObjet($tuteur);

        $formation = new Formation(null, "", $ligne[13], $ligne[14], $ligne[18], $ligne[19], $ligne[22], $ligne[23], $ligne[25], $ligne[26], $ligne[27], $ligne[24], 1, "", null, "Stage", "", "", 1, 1, null, $ligne[48], $ligne[51], "", "", "", $ligne[50], $ligne[1], $idTuteur, $ligne[55], $loginProf, 0);
        (new FormationRepository())->creerObjet($formation);
    }

    /**
     * @param $ligne
     * @return void permet d'insérer un CSV de studea dans la base de données
     */

    public static function insererStudea($ligne): void
    {
        $login = $ligne[9];
        $login .= $ligne[10][0]; //surement à changer si un étudiant à le même nom et le même prenom
        $login = strtolower($login);
        $etudiant = new Etudiant($ligne[3], $ligne[10], $ligne[9], $login, $ligne[8], $ligne[28], $ligne[29], $ligne[26], "XX", "XXXXX", 1, 0, 1);
        (new EtudiantRepository())->creerObjet($etudiant);

        $idVille = 0;
        $ville = new Ville($idVille, $ligne[33], $ligne[32]);
        (new VilleRepository())->creerObjet($ville);

        $entreprise = new Entreprise($ligne[58], "", "XX", $ligne[63], $ligne[61], "", $ligne[64], $idVille, 0, "", "", "", "", 0, "");
        (new EntrepriseRepository())->creerObjet($entreprise);

        $formation = new Formation($ligne[5], $ligne[139], $ligne[140], $ligne[3], "TP1", $ligne[58], null, 1, 2, "", "", "", "", "", null, "", "", "", "", "", "", "", null, null, "", "", "", "", "", "", "", 0);
        (new FormationRepository())->creerObjet($formation);
    }

    /**
     * @param $ligne
     * @param $idFormation
     * @return void permet d'insérer un CSV du secrétariat dans la base de données
     */
    public static function insererSuiviSecretariat($ligne, $idFormation): void {
        $groupe = $ligne[4][0];
        $groupe .= $ligne[4][1];
        $parcours = "";
        for($i = 5; $i < strlen($ligne[4]); $i++){
            $parcours .= $ligne[4][$i];
        }
        $etu = new Etudiant($ligne[2], $ligne[1], "", "", null, null, null, null, $groupe, $parcours, 1, $ligne[16], 1);
        (new EtudiantRepository())->creerObjet($etu);

        $entreprise = new Entreprise($ligne[12], "", null, null, null, null, "", "V0", 0, "", "" , "", "", 1, null);
        (new EntrepriseRepository())->creerObjet($entreprise);

        $prof = new Prof($ligne[17], "", "", "", 0, 1);
        (new ProfRepository())->creerObjet($prof);

        $tuteur = new TuteurPro($ligne[13], $ligne[14], "", "", "", "", $ligne[12]);
        (new TuteurProRepository())->creerObjet($tuteur);

        $type = "Alternance";
        if($ligne[6] == "/")
            $type = "Stage";
        $formation = new Formation($idFormation, null, $ligne[10], $ligne[11], null, null, null, null, null, null, null, null, null, null, null, $type, null, null, 1, 1, null, null, $ligne[7], $ligne[8], $ligne[9], null, null, null, $ligne[13], $ligne[12], $ligne[17], 0);
        (new FormationRepository())->creerObjet($formation);
    }

}