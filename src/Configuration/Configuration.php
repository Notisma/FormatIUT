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
    /*
    static private array $config = array(
        'hostname'=>'localhost',
        'database'=>'loyet',
        'login'=>'loyet',
        'password'=>'26032004',
        'port' =>'3306'
    );*/


    static private array $config = array(
        'hostname' => 'webinfo',
        'database' => 'loyet',
        'port' => '3316',
        'login' => 'loyet',
        'password' => '26032004'
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

}
