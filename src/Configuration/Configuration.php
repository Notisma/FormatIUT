<?php
/*
//On configure ici l'accès à la base de données
define('DB_HOST', 'localhost'); //Adresse de la base de données
define('DB_USER', 'loyet'); //Nom d'utilisateur de la base de données
define('DB_PASS', '26032004'); //Mot de passe de la base de données
define('DB_NAME', 'loyet'); //Nom de la base de données4
*/

namespace App\FormatIUT\Configuration;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\UploadsRepository;

class Configuration
{
    static private array $configLocal = array(

        'hostname' => 'localhost',
        'database' => 'loyet',
        'port' => '3306',
        'login' => 'root',
        'password' => 'root'
    );
    static private array $configLocalRaphael = array(

        'hostname' => 'localhost',
        'database' => 'sae',
        'port' => '3306',
        'login' => 'notisma',
        'password' => ''
    );
    static private array $configLocalNoe = array(

        'hostname' => 'localhost',
        'database' => 'devapplicationformatiut',
        'port' => '3306',
        'login' => 'root',
        'password' => 'root'
    );
    static private array $configWebInfo = array(

        'hostname' => 'localhost',
        'database' => 'loyet',
        'port' => '3306',
        'login' => 'loyet',
        'password' => 'gfsGnT!!hSSfE88.'
    );

    static private function getConfig(): array
    {
        if ($_SERVER["HTTP_HOST"] == "webinfo.iutmontp.univ-montp2.fr")
            return self::$configWebInfo;
        else if ($_SERVER['SERVER_PORT'] == 9999)
            return self::$configLocalRaphael;
        else if ($_SERVER['SERVER_PORT'] == 1024)
            return self::$configLocalNoe;
        else
            return self::$configLocal;
    }

    public static function getHostname(): string
    {
        return self::getConfig()['hostname'];
    }

    public static function getDatabase(): string
    {
        return self::getConfig()['database'];
    }

    public static function getLogin(): string
    {
        return self::getConfig()['login'];
    }

    public static function getPassword(): string
    {
        return self::getConfig()['password'];
    }

    public static function getPort(): string
    {
        return self::getConfig()['port'];
    }

    public static function getAbsoluteURL(): string
    {
        if ($_SERVER["HTTP_HOST"] == "webinfo.iutmontp.univ-montp2.fr") {
            return "https://webinfo.iutmontp.univ-montp2.fr/~loyet/2S5t5RAd2frMP6/web/controleurFrontal.php";
        }
        return "http://localhost/SAE_DEV/web/controleurFrontal.php";
    }


    /**
     * @param $id
     * @return string
     * Pour l'instant ne sert qu'à DRY, mais pourra être utilisée pour gérer la sécu des uploads
     */
    public static function getUploadPathFromId($id): string
    {
        $type = ConnexionUtilisateur::getTypeConnecte();
        $uploadsRepository = new UploadsRepository();
        $fileName = $uploadsRepository->getFileNameFromId($id);

        if ($fileName) {
            if (file_exists("../ressources/uploads/$id-$fileName")) {
                return "../ressources/uploads/$id-$fileName";
            } else {
                if (file_exists("https://webinfo.iutmontp.univ-montp2.fr/~loyet/2S5t5RAd2frMP6/ressources/uplaods/$id-$fileName")) {
                    return "https://webinfo.iutmontp.univ-montp2.fr/~loyet/2S5t5RAd2frMP6/ressources/uplaods/$id-$fileName";
                }
            }
        }
        return "../ressources/images/danger.png";
    }


    private static string $controleur;

    public static function controleurIs(string $contr): bool
    {
        return self::$controleur == $contr;
    }

    public static function setControleur(string $controleur): void
    {
        self::$controleur = $controleur;
    }

    public static function getControleurName(): string
    {
        return self::$controleur;
    }

    /**
     * @return class-string<ControleurMain>
     */
    public static function getCheminControleur(): string
    {
        return "App\FormatIUT\Controleur\Controleur" . self::$controleur;
    }

    /*    public static function getControleurClass(): string
        {
            return "Controleur" . self::$controleur;
        }
    */
    public static function getDelai()
    {
        return 30 * 60;
    }
}
