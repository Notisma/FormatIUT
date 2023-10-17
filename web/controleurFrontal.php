<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "namespace" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');

use App\FormatIUT\Controleur\ControleurMain as CGlobal;

if (isset($_GET['controleur'])) {
    $controleur = ucfirst($_GET["controleur"]);
    if ($_REQUEST["controleur"]=="EntrMain" && !\App\FormatIUT\Lib\ConnexionUtilisateur::estConnecte()){
        $controleur="Main";
    }
} else {
    $controleur = "Main";
}

if (isset($_GET['action'])) {
    $action = lcfirst($_GET["action"]);
} else {
    $action = "afficherIndex";
}

$nomClasseControleur = "App\FormatIUT\Controleur\Controleur$controleur";

$guillemets = '"';
if (class_exists($nomClasseControleur)) {
    if (in_array($action, get_class_methods($nomClasseControleur))) {
        $nomClasseControleur::$action();
    } else
        $nomClasseControleur::afficherErreur("L'action :$guillemets $action $guillemets n'existe pas dans le controleur :$guillemets $nomClasseControleur $guillemets");
} else
    $nomClasseControleur::afficherErreur("Le contrôleur :$guillemets $nomClasseControleur $guillemets n'existe pas");
