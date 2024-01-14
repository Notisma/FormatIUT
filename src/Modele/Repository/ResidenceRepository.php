<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Residence;

class ResidenceRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "Residence";
    }

    public function getClePrimaire(): string
    {
        return "idResidence";
    }

    public function getNomsColonnes(): array
    {
        return ["idResidence", "voie", "libCedex", "idVille"];
    }

    /**
     * @param array $residence
     * @return AbstractDataObject permet de construire une résidence depuis un tableau
     */
    public function construireDepuisTableau(array $residence): AbstractDataObject
    {
        return new Residence($residence['idResidence'], $residence['voie'], $residence['libCedex'], $residence['idVille']);
    }

}
