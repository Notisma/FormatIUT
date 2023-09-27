<?php
/*
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
// initialisation
$loader = new App\Covoiturage\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "espace de nom" → "dossier"
$loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');
*/


// On recupère l'action passée dans l'URL
if (!isset($_POST['action'])) {
    $action = "afficherAccueilEtu";
}
if (!isset($_GET['controleur'])) {
    $controleur = "MainControleur";
}

$nomDeClasseControleur = "App\Covoiturage\Controleur\Controleur" . ucfirst($controleur);

$nomDeClasseControleur::$action();
// Appel de la méthode statique $action de ControleurVoiture



