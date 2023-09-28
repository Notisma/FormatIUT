<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');



// On recupère l'action passée dans l'URL
if (!isset($_GET['action'])) {
    $action = "afficherIndex";
}else {
    $action=$_GET["action"];
}
if (!isset($_GET['controleur'])) {
    $controleur = "Main";
}else{
    $controleur=$_GET["controleur"];
}

$nomDeClasseControleur = "App\FormatIUT\Controleur\Controleur" . ucfirst($controleur);
$nomDeClasseControleur::$action();



