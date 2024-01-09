<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresProf
{
    public static function personnel_prof():string
    {
        return " AND estAdmin=0 AND loginProf NOT LIKE \"ecretariat\"";
    }
    public static function personnel_admin():string
    {
        return " AND estAdmin=1";
    }
    public static function personnel_secretariat():string
    {
        return " AND loginProf LIKE \"ecretariat\" ";
    }
}