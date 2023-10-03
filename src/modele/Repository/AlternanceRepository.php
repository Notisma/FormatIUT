<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\Repository\OffreRepository;

class AlternanceRepository extends OffreRepository
{

    public function getNomTable(): string
    {
        return "Alternance";
    }
}