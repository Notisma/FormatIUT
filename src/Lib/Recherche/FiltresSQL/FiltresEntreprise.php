<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresEntreprise
{
    public static function entreprise_validee():string
    {
        if (self::validite_entreprise())
        return " AND estValide=1 ";
        else return "";
    }
    public static function entreprise_non_validee():string
    {
        if (self::validite_entreprise())
        return " AND estValide=0";
        else return "";
    }
    public  static function validite_entreprise():bool
    {
     if (isset($_REQUEST["entreprise_validee"],$_REQUEST["entreprise_non_validee"])){
         return false;
     }   else return true;
    }
}