<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Lib\Users\Utilisateur;

class Administrateurs extends Personnels
{

    public function getTypeConnecte(): string
    {
        return "Administrateurs";
    }
}