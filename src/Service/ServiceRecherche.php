<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\PrivilegesUtilisateursRecherche;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use DOMDocument;

class ServiceRecherche
{

    /**
     * @return void permet à l'utilisateur de rechercher grâce à la barre de recherche
     */
    public static function rechercher(): void
    {
        /** @var ControleurMain $controleur */
        $controleur = Configuration::getCheminControleur();

        if (!isset($_REQUEST['recherche'])) {
            MessageFlash::ajouter("warning", "Veuillez renseigner une recherche.");
            header("Location: $_SERVER[HTTP_REFERER]");
            return;
        }
        ////si la recherche ne contient que un ou des espaces
        if (preg_match('/^\s+$/', $_REQUEST['recherche'])) {
            MessageFlash::ajouter("warning", "Veuillez renseigner une recherche valide.");
            header("Location: $_SERVER[HTTP_REFERER]");
            return;
        }

        $recherche = $_REQUEST['recherche'];
        $morceaux = explode(" ", $recherche);

        $res = AbstractRepository::getResultatRechercheTrie($morceaux);
        $liste=array();
        foreach (PrivilegesUtilisateursRecherche::getInstance()->getPrivileges() as $user =>$privilege){
            if ($user==ConnexionUtilisateur::getTypeConnecte()){
                foreach ($privilege as $repository) {
                    $nomDeClasseRepository="App\FormatIUT\Modele\Repository\\".$repository."Repository";
                    $re="recherche";
                    $liste[$repository]= (new $nomDeClasseRepository)->$re($morceaux);
                }
            }
        }

        if (is_null($res)) { // jamais censé être null, même en cas de zéro résultat
            MessageFlash::ajouter("danger", "Crash de recherche");
            die();
        } else {
            $count = count($res['offres']);
            MessageFlash::ajouter("success", "$count résultats trouvés.");
            ControleurMain::afficherVue("Résultat de la recherche", "vueResultatRecherche.php", ControleurMain::getMenu(), [
                "recherche" => $recherche,
                "offres" => $liste["Formation"],
                "entreprises" => array(),
                "nbResults" => $count
            ]);
        }
    }
}