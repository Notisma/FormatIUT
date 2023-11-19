<?php

namespace App\FormatIUT\Modele\HTTP;

class Cookie
{
    public static function enregistrer(string $cle, $valeur, ?int $dureeExpiration = null): void
    {
        if (!is_null($dureeExpiration)) {
            setcookie($cle, serialize($valeur), $dureeExpiration);
        }
        setcookie($cle, serialize($valeur), $dureeExpiration);
    }

    public static function lire(string $cle)
    {
        return unserialize($_COOKIE[$cle]);
    }

    public static function contient($cle): bool
    {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer($cle): void
    {
        unset($_COOKIE[$cle]);
        setcookie($cle, "", 1);
    }

}
