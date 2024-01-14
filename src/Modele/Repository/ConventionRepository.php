<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Convention;

class ConventionRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "Formations";
    }

    public function getClePrimaire(): string
    {
        return "idConvention";
    }

    public function getNomsColonnes(): array
    {
        return array("idConvention", "conventionValidee", "dateCreation", "dateTransmission", "retourSigne", "assurance", "objectifOffre", "typeConvention");
    }

    public function construireDepuisTableau(array $convention): AbstractDataObject
    {
        $dateCreation = new \DateTime($convention['dateCreation']);
        $dateTransmission = new \DateTime($convention['dateTransmission']);

        $creationconv = new Convention($convention['idConvention'], $convention ['conventionValidee'], $dateCreation,
            $dateTransmission, $convention['retourSigne'], $convention['assurance'],
            $convention['objectifOffre'], $convention['typeConvention']);
        return $creationconv;
    }
}
