<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

class FiltresProf
{
    public static function personnel_prof():string
    {
        $sql= " (estAdmin=0 AND loginProf NOT LIKE \"%ecretariat%\")";
        return self::type_prof($sql);
    }
    public static function personnel_admin():string
    {
        $sql= " estAdmin=1";
        return self::type_prof($sql);

    }
    public static function personnel_secretariat():string
    {
        $sql= " loginProf LIKE \"%ecretariat%\" ";
        return self::type_prof($sql);

    }
    public static function type_prof(string $filtre): string
    {
        $filtreL = array();
        foreach ($_REQUEST as $item) {
            if (in_array($item, get_class_methods("App\\FormatIUT\\Lib\\Recherche\\FiltresSQL\\FiltresProf"))) {
                if (str_contains($item, "personnel_")) {
                    $filtreL[] = $item;
                }
            }
        }
        if (count($filtreL) > 1) {
            $sql="(";
            foreach ($filtreL as $item) {
                if (str_contains($item, "prof")) {
                    $sql.="(estAdmin=0 AND loginProf NOT LIKE \"%ecretariat%\")";
                } else if (str_contains($item, "admin")) {
                    $sql.=" estAdmin=1 ";
                } else if (str_contains($item, "secretariat")) {
                    $sql.="loginProf LIKE \"%ecretariat%\" ";
                }
                if ($item !=$filtreL[count($filtreL)-1]){
                    $sql.=" OR ";
                }
            }
            $sql.=")";
            return $sql;
        } else {
            return $filtre;
        }

    }
}