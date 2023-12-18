<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Lib\Users\Personnels;

class Secretariat extends Personnels
{

    public function getTypeConnecte(): string
    {
        return "Secretariat";
    }
}