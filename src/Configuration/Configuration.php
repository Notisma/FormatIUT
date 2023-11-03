<?php
/*
//On configure ici l'accès à la base de données
define('DB_HOST', 'localhost'); //Adresse de la base de données
define('DB_USER', 'loyet'); //Nom d'utilisateur de la base de données
define('DB_PASS', '26032004'); //Mot de passe de la base de données
define('DB_NAME', 'loyet'); //Nom de la base de données4
*/

namespace App\FormatIUT\Configuration;

class Configuration
{

    static private array $config = array(
        'hostname' => 'localhost',
        'database' => 'sae',
        'port' => '3306',
        'login' => 'notisma',
        'password' => ''
    );

    public static function getHostname(): string
    {
        return self::$config['hostname'];
    }

    public static function getDatabase(): string
    {
        return self::$config['database'];
    }

    public static function getLogin(): string
    {
        return self::$config['login'];
    }

    public static function getPassword(): string
    {
        return self::$config['password'];
    }

    public static function getPort(): string
    {
        return self::$config['port'];
    }

    public static function getAbsoluteURL()
    {
        return "http://localhost/SAE_DEV/web/controleurFrontal.php";
    }


    private static string $controleur;

    public static function getControleur(): string
    {
        return self::$controleur;
    }
    public static function controleurIs(string $contr): bool {
        return self::$controleur == $contr;
    }

    public static function setControleur(string $controleur): void
    {
        self::$controleur = $controleur;
    }

    public static function getCheminControleur(): string {
        return "App\FormatIUT\Controleur\Controleur" . self::$controleur;
    }
}
