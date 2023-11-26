<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

// initialisation
$loader = new App\FormatIUT\Lib\Psr4AutoloaderClass();
$loader->register();
// enregistrement d'une association "namespace" → "dossier"
$loader->addNamespace('App\FormatIUT', __DIR__ . '/../src');

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Configuration\Configuration;

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
$nonConnecte=false;
if (class_exists($nomClasseControleur)) {
    Configuration::setControleur($controleur);
    if (in_array($action, get_class_methods($nomClasseControleur))) {
        if ($controleur == "EntrMain" && \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Entreprise") {
           $nonConnecte=true;
        } else if ($controleur=="EtuMain" && \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Etudiants") {
            $nonConnecte=true;
        } else if ($controleur=="AdminMain" && \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Administrateurs") {
            if (\App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Personnels") {
                $nonConnecte = true;
            }else {
                $nomClasseControleur::$action();
            }
        }else {
            $nomClasseControleur::$action();
        }
        if ($nonConnecte){
            header("Location: ?controleur=Main&action=afficherPageConnexion");
            \App\FormatIUT\Lib\MessageFlash::ajouter("danger", "Veuillez vous connecter");
        }
    } else
        $nomClasseControleur::afficherErreur('L\'action : "' . $action . '" n\'existe pas dans le contrôleur : "' . $nomClasseControleur . '"');
} else {
    Configuration::setControleur("Main");
    ControleurMain::afficherErreur('Le contrôleur : ' . $nomClasseControleur . ' n\'existe pas');
}
