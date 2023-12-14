<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\Repository\AbstractRepository;

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
        } //si la recherche contient des chiffres
        if (preg_match('/[0-9]/', $_REQUEST['recherche'])) {
            MessageFlash::ajouter("warning", "On évite les nombres stp (à régler plus tard)");
            header("Location: $_SERVER[HTTP_REFERER]");
            return;
        } //si la recherche ne contient que un ou des espaces
        if (preg_match('/^\s+$/', $_REQUEST['recherche'])) {
            MessageFlash::ajouter("warning", "Veuillez renseigner une recherche valide.");
            header("Location: $_SERVER[HTTP_REFERER]");
            return;
        }

        $recherche = $_REQUEST['recherche'];
        $morceaux = explode(" ", $recherche);

        $res = AbstractRepository::getResultatRechercheTrie($morceaux);

        if (is_null($res)) { // jamais censé être null, même en cas de zéro résultat
            MessageFlash::ajouter("danger", "Crash de recherche");
            die();
        } else {
            $count = count($res['offres']) + count($res['entreprises']);
            MessageFlash::ajouter("success", "$count résultats trouvés.");
            $controleur::afficherVue("Résultat de la recherche", "vueResultatRecherche.php", $controleur::getMenu(), [
                "recherche" => $recherche,
                "offres" => $res['offres'],
                "entreprises" => $res['entreprises'],
                "nbResults" => $count
            ]);
        }
    }
}