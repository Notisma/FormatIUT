<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\studea;

class StudeaRepository extends RechercheRepository
{
    public function getNomTable(): string
    {
        return "InsererDonnees";
    }

    public function construireDepuisTableau(array $dataObjectTableau): studea
    {
        $maitreApprentissage = (bool)$dataObjectTableau[113];
        $formationMaitreApprentissage = (bool)$dataObjectTableau[114];
        $maitreApprentissage2 = (bool)$dataObjectTableau[122];
        $formationMaitreApprentissage2 = (bool)$dataObjectTableau[123];

        return new studea(
            $dataObjectTableau[0],
            $dataObjectTableau[1],
            $dataObjectTableau[2],
            $dataObjectTableau[3],
            $dataObjectTableau[4],
            $dataObjectTableau[5],
            $dataObjectTableau[6],
            $dataObjectTableau[7],
            $dataObjectTableau[8],
            $dataObjectTableau[9],
            $dataObjectTableau[10],
            $dataObjectTableau[11],
            $dataObjectTableau[12],
            $dataObjectTableau[13],
            $dataObjectTableau[14],
            $dataObjectTableau[15],
            $dataObjectTableau[16],
            $dataObjectTableau[17],
            $dataObjectTableau[18],
            $dataObjectTableau[19],
            $dataObjectTableau[20],
            $dataObjectTableau[21],
            $dataObjectTableau[22],
            $dataObjectTableau[23],
            $dataObjectTableau[24],
            $dataObjectTableau[25],
            $dataObjectTableau[26],
            $dataObjectTableau[27],
            $dataObjectTableau[28],
            $dataObjectTableau[29],
            $dataObjectTableau[30],
            $dataObjectTableau[31],
            $dataObjectTableau[32],
            $dataObjectTableau[33],
            $dataObjectTableau[34],
            $dataObjectTableau[35],
            $dataObjectTableau[36],
            $dataObjectTableau[37],
            $dataObjectTableau[38],
            $dataObjectTableau[39],
            $dataObjectTableau[40],
            $dataObjectTableau[41],
            $dataObjectTableau[42],
            $dataObjectTableau[43],
            $dataObjectTableau[44],
            $dataObjectTableau[45],
            $dataObjectTableau[46],
            $dataObjectTableau[47],
            $dataObjectTableau[48],
            $dataObjectTableau[49],
            $dataObjectTableau[50],
            $dataObjectTableau[51],
            $dataObjectTableau[52],
            $dataObjectTableau[53],
            $dataObjectTableau[54],
            $dataObjectTableau[55],
            $dataObjectTableau[56],
            $dataObjectTableau[57],
            $dataObjectTableau[58],
            $dataObjectTableau[59],
            $dataObjectTableau[60],
            $dataObjectTableau[61],
            $dataObjectTableau[62],
            $dataObjectTableau[63],
            $dataObjectTableau[64],
            $dataObjectTableau[65],
            $dataObjectTableau[66],
            $dataObjectTableau[67],
            $dataObjectTableau[68],
            $dataObjectTableau[69],
            $dataObjectTableau[70],
            $dataObjectTableau[71],
            $dataObjectTableau[72],
            $dataObjectTableau[73],
            $dataObjectTableau[74],
            $dataObjectTableau[75],
            $dataObjectTableau[76],
            $dataObjectTableau[77],
            $dataObjectTableau[78],
            $dataObjectTableau[79],
            $dataObjectTableau[80],
            $dataObjectTableau[81],
            $dataObjectTableau[82],
            $dataObjectTableau[83],
            $dataObjectTableau[84],
            $dataObjectTableau[85],
            $dataObjectTableau[86],
            $dataObjectTableau[87],
            $dataObjectTableau[88],
            $dataObjectTableau[89],
            $dataObjectTableau[90],
            $dataObjectTableau[91],
            $dataObjectTableau[92],
            $dataObjectTableau[93],
            $dataObjectTableau[94],
            $dataObjectTableau[95],
            $dataObjectTableau[96],
            $dataObjectTableau[97],
            $dataObjectTableau[98],
            $dataObjectTableau[99],
            $dataObjectTableau[100],
            $dataObjectTableau[101],
            $dataObjectTableau[102],
            $dataObjectTableau[103],
            $dataObjectTableau[104],
            $dataObjectTableau[105],
            $dataObjectTableau[106],
            $dataObjectTableau[107],
            $dataObjectTableau[108],
            $dataObjectTableau[109],
            $dataObjectTableau[110],
            $dataObjectTableau[111],
            $dataObjectTableau[112],
            $maitreApprentissage,
            $formationMaitreApprentissage,
            $dataObjectTableau[115],
            $dataObjectTableau[116],
            $dataObjectTableau[117],
            $dataObjectTableau[118],
            $dataObjectTableau[119],
            $dataObjectTableau[120],
            $dataObjectTableau[121],
            $maitreApprentissage2,
            $formationMaitreApprentissage2,
            $dataObjectTableau[124],
            $dataObjectTableau[125],
            $dataObjectTableau[126],
            $dataObjectTableau[127],
            $dataObjectTableau[128],
            $dataObjectTableau[129],
            $dataObjectTableau[130],
            $dataObjectTableau[131],
            $dataObjectTableau[132],
            $dataObjectTableau[133],
            $dataObjectTableau[134],
            $dataObjectTableau[135],
            $dataObjectTableau[136],
            $dataObjectTableau[137],
            $dataObjectTableau[138],
            $dataObjectTableau[139],
            $dataObjectTableau[140],
            $dataObjectTableau[141],
            $dataObjectTableau[142],
        );
    }

    public function callProcedure(studea $studea): bool
    {
        $sql = 'CALL insertionStudea(:numEtudiant, :prenomEtudiant, :nomEtudiant, :loginEtudiant);';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("numEtudiant" => $studea->getId(), "nomEtudiant" => $studea->getNomAlternant(), "prenomEtudiant" => $studea->getPrenomAlternant(), "loginEtudiant" => "loginRandom");
        $pdoStatement->execute($values);
        if ($pdoStatement->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    protected function getNomsColonnes(): array
    {
        return array();
    }

    protected function getClePrimaire(): string
    {
        return "codeUFR";
    }
}
