<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurMain
{

    /***
     * Affiche la page d'acceuil du site sans qu'aucune connexion n'est été faite
     */
    public static function afficherIndex(){
        self::afficherVue('vueGenerale.php',["menu"=>self::getMenu(),"chemin"=>"vueIndex.php","titrePage"=>"Accueil"]);
    }

    /***
     * Affiche la page de detail d'une offre qui varie selon le client
    */
    public static function afficherVueDetailOffre(){
        $menu = "App\Formatiut\Controleur\Controleur" . $_GET['controleur'];
        $liste=(new OffreRepository())->getListeIdOffres();
        if (isset($_GET["idOffre"])) {
            if (in_array($_GET["idOffre"], $liste)) {
                $offre = (new OffreRepository())->getObjectParClePrimaire($_GET['idOffre']);
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                if ($_GET["controleur"] == "EntrMain") $client = "Entreprise";
                else $client = "Etudiant";
                $chemin = ucfirst($client) . "/vueDetail" . ucfirst($client) . ".php";
                self::afficherVue('vueGenerale.php', ["menu" => $menu::getMenu(), "chemin" => $chemin, "titrePage" => "Detail de l'offre", "offre" => $offre, "entreprise" => $entreprise]);
            } else {
                $menu::afficherErreur("L'offre n'existe pas");
            }
        }else {
            $menu::afficherErreur("L'offre n'est pas renseigné");
        }
    }

    public static function afficherVue(string $cheminVue, array $parametres = []): void
    {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }

    public static function getMenu() :array{
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil","lien"=>"?action=afficherIndex"),
            array("image"=>"../ressources/images/profil.png","label"=>"Se Connecter","lien"=>"?controleur=EtuMain&action=afficherAccueilEtu"),
            array("image"=>"../ressources/images/entreprise.png","label"=>"Accueil Entreprise","lien"=>"?controleur=EntrMain&action=afficherAccueilEntr")
        );
    }

    /***
     * @param array $liste
     * @return array|null
     * retourne les 3 éléments avec la valeur les plus hautes
     */
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
        return TransfertImage::transfert($nom);
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
    protected static function autoIncrementF($listeId, $get): int
    {
        $id = 1;
        while (!isset($_POST[$get])) {
            if (in_array("F".$id, $listeId)) {
                $id++;
            } else {
                $_POST[$get] = $id;
            }
        }
        return $id;
    }
    public static function afficherPageConnexion(){
        self::afficherVue("vueGenerale.php",["titrePage"=>"Page de Connexion","menu"=>self::getMenu(),"chemin"=>"vueFormulaireConnexion.php"]);
    }

    public static function seConnecter(){
        if(isset($_POST["login"],$_POST["mdp"])){
            $user=((new EntrepriseRepository())->getObjectParClePrimaire($_POST["login"]));
            if (!is_null($user)){
                if ( hash('sha256', $_POST["mdp"])==$user->getMdpHache()){
                    ConnexionUtilisateur::connecter($_POST["login"]);
                    ControleurEntrMain::afficherAccueilEntr();
                    exit();
                }
            }
        }
        self::afficherPageConnexion();
    }
}