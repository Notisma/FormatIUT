<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresEntreprise
{
    public static function entreprise_validee(): string
    {
        $sql = " estValide=1 ";
        return self::validite_entreprise($sql);
    }

    public static function entreprise_non_validee(): string
    {
        $sql= "estValide=0";
        return self::validite_entreprise($sql);
    }

    public static function validite_entreprise(string $sql): string
    {
        if (isset($_REQUEST["entreprise_validee"], $_REQUEST["entreprise_non_validee"])) {
            return "";
        } else return $sql;
    }
}