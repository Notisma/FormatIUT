<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurMain
{


    public static function afficherIndex(){
        self::afficherVue('vueGenerale.php',["menu"=>self::getMenu(),"chemin"=>"vueIndex.php","titrePage"=>"Accueil"]);
    }

    public static function afficherVueDetailOffre(){
        $offre=(new OffreRepository())->getOffre($_GET['idOffre']);
        $entreprise=(new EntrepriseRepository())->getEntrepriseFromSiret($offre->getSiret());
        $menu="App\Formatiut\Controleur\Controleur".$_GET['controleur'];
        self::afficherVue('vueGenerale.php',["menu"=>$menu::getMenu(),"chemin"=>"Offre/vueDetail.php","titrePage"=>"Detail de l'offre","offre"=>$offre,"entreprise"=>$entreprise]);
    }

    public static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function getMenu() :array{
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil","lien"=>""),
            array("image"=>"../ressources/images/profil.png","label"=>"Se Connecter","lien"=>"?controleur=etuMain&action=afficherAccueilEtu"),
            array("image"=>"../ressources/images/entreprise.png","label"=>"Accueil Entreprise","lien"=>"?controleur=entrMain&action=afficherAccueilEntr")
        );
    }
    protected static function getTroisMax(array $liste) : ?array{
        $list=array();
        if (!empty($liste)) {
            for ($i = 0; $i <= min(3, sizeof($liste)); $i++) {
                $id = max($liste);
                foreach ($liste as $item => $value) {
                    if ($value == $id) $key = $item;
                }
                unset($liste[$key]);
                $list[] = $id;
            }
        }
        return $list;
    }

    public static function afficherErreur(string $error): void
    {
        self::afficherVueDansCorps("ERREUR", 'erreur.php', [], [
            'errorstr' => $error
        ]);
    }
    protected static function afficherVueDansCorps(string $titrePage, string $cheminVue, array $menu, array $parametres = []): void
    {
        self::afficherVue("vueGenerale.php", array_merge(
            [
                'pageTitle' => $titrePage,
                'cheminVueBody' => $cheminVue,
                'menu' => $menu
            ],
            $parametres
        ));
    }
}