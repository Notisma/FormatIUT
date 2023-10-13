<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "namespace" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');

use App\FormatIUT\Controleur\ControleurMain as CGlobal;

if (isset($_GET['controleur'])) {
    $controleur = $_GET["controleur"];
} else {
    $controleur = "Main";
}

if (isset($_GET['action'])) {
    $action = $_GET["action"];
} else {
    $action = "afficherIndex";
}

$nomClasseControleur = "App\FormatIUT\Controleur\Controleur$controleur";

if (class_exists($nomClasseControleur)) {
    if (in_array($action, get_class_methods($nomClasseControleur))) {
        $nomClasseControleur::$action();
    } else
        CGlobal::afficherErreur("L'action $action n'existe pas dans le controleur $nomClasseControleur");
} else
    CGlobal::afficherErreur("Le controleur $nomClasseControleur n'existe pas !");
