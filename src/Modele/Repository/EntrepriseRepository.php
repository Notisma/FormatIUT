<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Entreprise;
use PDO;

// cette classe n'est pas encore faite, sauf deux fonctions utilisées dans Offre
class EntrepriseRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "Entreprise";
    }

    protected function getNomsColonnes(): array
    {
        return ["numSiret","nomEntreprise","statutJuridique","effectif","codeNAF","tel","Adresse_Entreprise","idVille"];
    }

    public function construireDepuisTableau(array $entrepriseFormatTableau): Entreprise
    {
        return new Entreprise($entrepriseFormatTableau['numSiret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel'],
            $entrepriseFormatTableau['Adresse_Entreprise'],
            $entrepriseFormatTableau['idVille']
        );
    }

    protected function getClePrimaire(): string
    {
       return  "numSiret";
    }

}