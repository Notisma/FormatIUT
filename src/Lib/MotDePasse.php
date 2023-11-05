<?php
namespace App\FormatIUT\Lib;

class MotDePasse
{

    private static string $poivre="HU0ulztu0lR22QQWa7E4LX";

    public static function hacher(string $mdpClair): string
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        $mdpHache = password_hash($mdpPoivre, PASSWORD_DEFAULT);
        return $mdpHache;
    }

    public static function verifier(string $mdpClair, string $mdpHache): bool
    {
        $mdpPoivre = hash_hmac("sha256", $mdpClair, MotDePasse::$poivre);
        return password_verify($mdpPoivre, $mdpHache);
    }


    public static function genererChaineAleatoire(int $nbCaracteres = 22): string
    {
        //TODO : vérifier que ce qui est généré n'est pas déjà pris dans la base de données

        //ne doit générer que des chiffres et des lettres, pas de caractères spéciaux
        $octetsAleatoires = random_bytes(ceil($nbCaracteres * 6 / 8));
        return substr(base64_encode($octetsAleatoires), 0, $nbCaracteres);
    }

}


