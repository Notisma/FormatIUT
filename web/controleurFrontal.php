<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "namespace" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');

use App\FormatIUT\Controleur\ControleurMain as CGlobal;

if (isset($_REQUEST['controleur'])) {
    $controleur = ucfirst($_REQUEST["controleur"]);
} else {
    $controleur = "Main";
}

if (isset($_REQUEST['action'])) {
    $action = lcfirst($_REQUEST["action"]);
} else {
    $action = "afficherIndex";
}

$nomClasseControleur = "App\FormatIUT\Controleur\Controleur$controleur";

$guillemets = '"';
if (class_exists($nomClasseControleur)) {
    if (in_array($action, get_class_methods($nomClasseControleur))) {

        if ($controleur=="EntrMain" && !\App\FormatIUT\Lib\ConnexionUtilisateur::estConnecte()) {
            \App\FormatIUT\Controleur\ControleurMain::redirectionFlash("afficherIndex", "danger", "Veuillez vous connecter");
        }
        else {
            $nomClasseControleur::$action();
        }
    } else
        $nomClasseControleur::afficherErreur("L'action :$guillemets $action $guillemets n'existe pas dans le controleur :$guillemets $nomClasseControleur $guillemets");
} else
    $nomClasseControleur::afficherErreur("Le contrôleur :$guillemets $nomClasseControleur $guillemets n'existe pas");
