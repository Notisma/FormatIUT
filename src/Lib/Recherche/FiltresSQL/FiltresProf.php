<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresProf
{
    public static function personnel_prof():string
    {
        return " (estAdmin=0 AND loginProf LIKE \"%ecretariat%\")";
    }
    public static function personnel_admin():string
    {
        return " estAdmin=1";
    }
    public static function personnel_secretariat():string
    {
        return " loginProf LIKE \"%ecretariat%\" ";
    }
}