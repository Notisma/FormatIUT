<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "namespace" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\Historique;
$classe="Controleur";
if (isset($_REQUEST['controleur'])) { //
    $controleur = ucfirst($_REQUEST["controleur"]);
} else {
    if (isset($_REQUEST["service"])){
        $controleur=ucfirst($_REQUEST["service"]);
        $classe="Service";
    }else {
        $controleur = "Main";
    }
}

if (isset($_REQUEST['action'])) {
    $action = lcfirst($_REQUEST["action"]);
} else {
    $action = "afficherIndex";
}
$nomClasseControleur = "App\FormatIUT\\$classe\\$classe".$controleur;
if (class_exists($nomClasseControleur)) {
    Configuration::setControleur($controleur);
    if (in_array($action, get_class_methods($nomClasseControleur))) {
        $nonConnecte =\App\FormatIUT\Lib\ConnexionUtilisateur::verifConnecte($controleur);
        if ($nonConnecte){
            header("Location: ?controleur=Main&action=afficherPageConnexion");
            \App\FormatIUT\Lib\MessageFlash::verifDeconnexion();
        }else {
            $nomClasseControleur::$action();
        }
    } else {
        ControleurMain::afficherErreur("L'action : ' $action ' n'existe pas dans le $classe : ' $nomClasseControleur '");
    }
} else {
    Configuration::setControleur("Main");
    ControleurMain::afficherErreur("Le $classe : ' $nomClasseControleur ' n'existe pas");
}
