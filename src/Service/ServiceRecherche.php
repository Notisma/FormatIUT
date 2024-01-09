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
        $liste = array();
        $count = 0;
        $privilege=ConnexionUtilisateur::getUtilisateurConnecte()->getFiltresRecherche();
        $sansfiltres=true;
        foreach ($privilege as $item=>$value) {
            if (isset($_REQUEST[$item."s"])){$sansfiltres=false;}
        }
        foreach ($privilege as $repository=>$filtres) {
            $listeFiltres=array();
            foreach ($filtres as $filtre) {
                if (in_array("obligatoire",$filtre) ||isset($_REQUEST[$filtre["value"]])){
                    $listeFiltres[]=$filtre["SQL"];
                }
            }
            if (isset($_REQUEST[$repository.'s']) || $sansfiltres) {
                $nomDeClasseRepository = "App\FormatIUT\Modele\Repository\\" . $repository . "Repository";
                $re = "recherche";
                $nomAffichageRecherche = "App\FormatIUT\Lib\AffichagesRecherche\\" . $repository . "Recherche";
                $element = (new $nomDeClasseRepository)->$re($morceaux,$listeFiltres);
                $arrayRecherche = array();
                foreach ($element as $objet) {
                    $arrayRecherche[] = new $nomAffichageRecherche($objet);
                }
                $liste[$repository] = $arrayRecherche;
                $count += sizeof($liste[$repository]);
            }
        }

        if (is_null($res)) { // jamais censé être null, même en cas de zéro résultat
            MessageFlash::ajouter("danger", "Crash de recherche");
            die();
        } else {
            MessageFlash::ajouter("success", "$count résultats trouvés.");
            $_REQUEST["recherche"] = $recherche;
            $_REQUEST["liste"] = $liste;
            $_REQUEST["count"] = $count;
            ControleurMain::afficherRecherche();
        }
    }

    /**
     * @param $tri, le string qui indique le type de tri : "type", "date", "ordre alphabétique"
     * @param $liste, la liste des résultats de la recherche que l'on doit trier
     * @return $liste une liste qui contient des tableaux pour chaque type de résultat (entreprise, étudiant) en étant triée selon le paramètre $tri
     */
    public static function trierPar($tri, $liste) {
        //seuls les types entreprise (avec la date de création de compte), les formations (avec date création offre) possèdent des dates que l'on peut trier
        //à chaque fois, on récupère les éléments de la liste, on crée
        $liste = null;
        return $liste;
    }

}