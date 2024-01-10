<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresProf
{
    public static function personnel_prof():string
    {
        return " AND estAdmin=0 AND nomProf NOT LIKE \"secretariat\"";
    }
    public static function personnel_admin():string
    {
        return " AND estAdmin=1";
    }
    public static function personnel_secretariat():string
    {
        return " AND nomProf LIKE \"secretariat\" ";
    }
}