<?php
namespace App\FormatIUT\Modele\HTTP;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
//use App\FormatIUT\Lib\MessageFlash;
use Exception;

class Session
{
private static ?Session $instance = null;

/**
* @throws Exception
*/
private function __construct()
{
if (session_start() === false) {
throw new Exception("La session n'a pas réussi à démarrer.");
}
}

public static function getInstance(): Session
{
if (is_null(Session::$instance))
    Session::$instance = new Session();
//self::verifierDerniereActivite();
return Session::$instance;
}

public function contient($name): bool
{
// À compléter
    return isset($_SESSION[$name]);
}

public function enregistrer(string $name, $value): void
{
// À compléter
    $_SESSION[$name]=$value;
}

public function lire(string $name)
{
// À compléter
    return $_SESSION[$name];
}

public function supprimer($name): void
{
// À compléter
    unset($_SESSION[$name]);
}

public function detruire() : void
{
session_unset();     // unset $_SESSION variable for the run-time
session_destroy();   // destroy session data in storage
Cookie::supprimer(session_name()); // deletes the session cookie
// Il faudra reconstruire la session au prochain appel de getInstance()
$instance = null;
}/*
public static function verifierDerniereActivite():void{

    if (isset($_SESSION['derniereActivite']) && (time() - $_SESSION['derniereActivite'] > (Configuration::getDelai()))) {
        //$test=time() - $_SESSION['derniereActivite'];
        $bool=false;
        if (isset($_SESSION["_utilisateurConnecte"])) $bool=true;
        session_unset();     // unset $_SESSION variable for the run-time
        if ($bool)
        MessageFlash::ajouter("info","Vous avez été déconnecté(e)");
    }
    $_SESSION['derniereActivite'] = time(); // update last activity time stamp
}*/
}