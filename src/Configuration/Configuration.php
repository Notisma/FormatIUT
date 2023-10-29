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
        'database' => 'loyet',
        'port' => '3306',
        'login' => 'loyet',
        'password' => 'gfsGnT!!hSSfE88.'
        //'password'=>'root'
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
        return"http://localhost:81/SAE_DEV/web/controleurFrontal.php";
    }
}
