<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\Repository\OffreRepository;

class StageRepository extends OffreRepository
{

    public function getNomTable(): string
    {
       return "Stage";
    }
}