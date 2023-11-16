<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Modele\DataObject\ConventionStage;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\ConventionStageRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;

class InsertionCSV
{

    public static function insererPstage($ligne): void {
        $login = $ligne[2] + $ligne[3][0]; //surement à changer si un étudiant à le même nom et le même prenom
        $etudiant = new Etudiant($ligne[1], $ligne[3], $ligne[2], $login, $ligne[42], $ligne[7], $ligne[6], $ligne[5], "XX", "XXXXX", 1, $ligne[11], "X", 1);
        (new EtudiantRepository())->creerObjet($etudiant);

        //il faut changer l'effectif,
        $entreprise = new Entreprise($ligne[55], "", $ligne[62], 0, $ligne[65], $ligne[66], $ligne[56], "V1", 0);
        (new EntrepriseRepository())->creerObjet($entreprise);

        $formation = new Formation("F25", $ligne[13], $ligne[14], $ligne[1], "TP1", $ligne[55], $ligne[0], 1, 2);
        (new FormationRepository())->creerObjet($formation);

        $ville = new Ville("V23", $ligne[47], $ligne[45]);
        (new VilleRepository())->creerObjet($ville);

        $ville2 = new Ville("V24", $ligne[60], $ligne[59]);
        (new VilleRepository())->creerObjet($ville2);

        $conventionValidee = $ligne[28] == "oui" ? 1 : 0;
        $convention = new ConventionStage($ligne[0], $conventionValidee, $ligne[13], $ligne[14], 0, "", $ligne[20], $ligne[37]);
        (new ConventionStageRepository())->creerObjet($convention);
    }

}