<?php

namespace App\FormatIUT\Modele\HTTP;

class Cookie
{

    public static function enregistrer(string $cle, $valeur, ?int $dureeExpiration = null): void{
        if (!is_null($dureeExpiration)) {
            setcookie($cle, serialize($valeur),$dureeExpiration);
        }
        setcookie($cle, serialize($valeur),$dureeExpiration);
    }
    public static function lire(string $cle){
        $cookie=unserialize($_COOKIE[$cle]);
        return $cookie;
    }
    public static function contient($cle) : bool{
        $bool=isset($_COOKIE[$cle]);
        return $bool;
    }
    public static function supprimer($cle) : void {
        unset($_COOKIE[$cle]);
        setcookie($cle,"",1);
    }



}