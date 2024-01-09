<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresEntreprise
{
    public static function entreprise_validee():string
    {
        return " AND estValide=1 ";
    }
    public static function entreprise_non_validee():string
    {
        return " AND estValide=0";
    }
}