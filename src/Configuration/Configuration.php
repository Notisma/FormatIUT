<?php
/*
//On configure ici l'accès à la base de données
define('DB_HOST', 'localhost'); //Adresse de la base de données
define('DB_USER', 'loyet'); //Nom d'utilisateur de la base de données
define('DB_PASS', '26032004'); //Mot de passe de la base de données
define('DB_NAME', 'loyet'); //Nom de la base de données4
*/
namespace App\FormatIUT\Configuration;

class Configuration{
    static private array $config = array(
        // webinfo à l'IUT
        // localhost sur votre machine
        // webinfo.iutmontp.univ-montp2.fr pour accéder à webinfo depuis l'extérieur
        'hostname' => 'webinfo',
        // A l'IUT, vous avez une BDD nommee comme votre login
        // Sur votre machine, vous devrez creer une BDD
        'database' => 'loyet',
        // À l'IUT, le port de MySQL est particulier : 3316
        // Ailleurs, on utilise le port par défaut : 3306
        'port' => '3316',
        // A l'IUT, c'est votre login
        // Sur votre machine, vous avez surement un compte 'root'
        'login' => 'loyet',
        // A l'IUT, c'est votre mdp (INE par defaut)
        // Sur votre machine personelle, vous avez créé ce mdp a l'installation
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

    public static function getLogin():string{
        return self::$config['login'];
    }

    public static function getPassword():string{
        return self::$config['password'];
    }

    public static function getPort():string{
        return self::$config['port'];
    }

}
?>

