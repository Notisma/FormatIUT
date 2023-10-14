<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurMain
{


    public static function afficherIndex(){
        self::afficherVue('vueGenerale.php',["menu"=>self::getMenu(),"chemin"=>"vueIndex.php","titrePage"=>"Accueil"]);
    }

    public static function afficherVueDetailOffre(){
        $offre=(new OffreRepository())->getObjectParClePrimaire($_GET['idOffre']);
        $entreprise=(new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
        $menu="App\Formatiut\Controleur\Controleur".$_GET['controleur'];
        if ($_GET["controleur"]=="EntrMain") $client="Entreprise";
        else $client="Etudiant";
        $chemin=ucfirst($client)."/vueDetail".ucfirst($client).".php";
        self::afficherVue('vueGenerale.php',["menu"=>$menu::getMenu(),"chemin"=>$chemin,"titrePage"=>"Detail de l'offre","offre"=>$offre,"entreprise"=>$entreprise]);
    }

    public static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function getMenu() :array{
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil","lien"=>""),
            array("image"=>"../ressources/images/profil.png","label"=>"Se Connecter","lien"=>"?controleur=EtuMain&action=afficherAccueilEtu"),
            array("image"=>"../ressources/images/entreprise.png","label"=>"Accueil Entreprise","lien"=>"?controleur=EntrMain&action=afficherAccueilEntr")
        );
    }
    public static function getMenuErreur() :array{
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil","lien"=>"?controleur=Main&action=afficherIndex"),
            array("image"=>"../ressources/images/profil.png","label"=>"Se Connecter","lien"=>"?controleur=EtuMain&action=afficherAccueilEtu"),
            array("image"=>"../ressources/images/entreprise.png","label"=>"Accueil Entreprise","lien"=>"?controleur=EntrMain&action=afficherAccueilEntr")
        );
    }
    protected static function getTroisMax(array $liste) : ?array{
        $list=array();
        if (!empty($liste)) {
            $min=min(3, sizeof($liste));
            for ($i = 0; $i < $min; $i++) {
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
        $menu="App\Formatiut\Controleur\Controleur".$_GET['controleur'];
        self::afficherVueDansCorps("Erreur", 'vueErreur.php', $menu::getMenu(), [
            'erreurStr' => $error
        ]);
    }
    protected static function afficherVueDansCorps(string $titrePage, string $cheminVue, array $menu, array $parametres = []): void
    {
        self::afficherVue("vueGenerale.php", array_merge(
            [
                'titrePage' => $titrePage,
                'chemin' => $cheminVue,
                'menu' => $menu
            ],
            $parametres
        ));
    }

    public static function insertImage($nom){
        TransfertImage::transfert($nom, $_GET["controleur"]);
    }

    protected static function autoIncrement($listeId, $get): int
    {
        $id = 1;
        while (!isset($_POST[$get])) {
            if (in_array($id, $listeId)) {
                $id++;
            } else {
                $_POST[$get] = $id;
            }
        }
        return $id;
    }
}