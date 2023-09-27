<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');



// On recupère l'action passée dans l'URL
if (!isset($_POST['action'])) {
    $action = "afficherAccueilEtu";
}
if (!isset($_GET['controleur'])) {
    $controleur = "\MainControleur";
}

$nomDeClasseControleur = "App\Covoiturage\Controleur" . $controleur;
\App\FormatIUT\Controleur\MainControleur::afficherAccueilEtu();
//$nomDeClasseControleur::$action();



