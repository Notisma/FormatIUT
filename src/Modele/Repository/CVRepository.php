<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\CV;

class CVRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "CV";
    }

    public function getClePrimaire(): string
    {
        return("idCV");
    }

    public function getNomsColonnes(): array
    {
        return ["idCV", "contenuCV"];
    }

    public function construireDepuisTableau(array $DataObjectTableau): CV
    {
        return new CV($DataObjectTableau['idCV'], $DataObjectTableau['contenuCV']);
    }
}