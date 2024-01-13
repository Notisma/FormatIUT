<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\Historique;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\StringUtils;
use App\FormatIUT\Modele\Repository\UploadsRepository;
use App\FormatIUT\Service\ServiceConnexion;
use App\FormatIUT\Service\ServiceMdp;
use App\FormatIUT\Service\ServiceRecherche;

class ControleurMain
{
    private static string $pageActuelle = "Accueil";

    /**
     * @return string
     */
    public static function getPageActuelle(): string
    {
        return self::$pageActuelle;
    }

    /**
     * @return array[] qui représente le contenu du menu non connecté dans le bandeauDéroulant
     */
    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil", "lien" => "?controleur=Main&action=afficherIndex"),
            array("image" => "../ressources/images/profil.png", "label" => "Se Connecter", "lien" => "?controleur=Main&action=afficherPageConnexion"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Accueil Entreprise", "lien" => "?controleur=Main&action=afficherVuePresentation")
        );
    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @param string $titrePage Le titre de la Page actuelle
     * @param string $cheminVue Le chemin de la vue à utiliser
     * @param array $menu Le menu à utiliser dans le bandeau déroulant
     * @param array $parametres des paramètres supplémentaire pour des informations spécifiques aux pages
     * @return void fonctions à appeler pour afficher une vue
     */

    public static function afficherVue(string $titrePage, string $cheminVue, array $parametres = []): void
    {
        $cssPath = str_replace('vue', 'styleVue', $cheminVue);
        $cssPath = str_replace('.php', '.css', $cssPath);
        extract(array_merge(
            [
                'titrePage' => $titrePage,
                'chemin' => $cheminVue,
                'css' => $cssPath
            ],
            $parametres
        ));
        require __DIR__ . "/../vue/vueGenerale.php"; // Charge la vue
    }

    /***
     * @return void Affiche la page d'acceuil du site sans qu'aucune connexion n'aie été faite
     */
    public static function afficherIndex(): void
    {
        self::afficherVue("Accueil", "vueIndex.php");
    }

    /***
     * @return void Affiche la page de présentations aux entreprises n'ayant pas de compte
     */
    public static function afficherVuePresentation(): void
    {
        self::afficherVue("Accueil Entreprise", "Entreprise/vuePresentationEntreprise.php");
    }

    /**
     * @param string $error le message que l'erreur va afficher
     * @return void fonctions pour afficher la page d'erreur
     */
    public static function afficherErreur(string $error): void
    {
        /** @var ControleurMain $menu */
        $menu = Configuration::getCheminControleur();

        self::afficherVue("Erreur", 'vueErreur.php', [
            'erreurStr' => $error
        ]);
    }

    /**
     * @return void affiche la page de connexion
     */
    public static function afficherPageConnexion(): void
    {
        self::afficherVue("Se Connecter", "vueFormulaireConnexion.php");
    }

    /**
     * @return void affiche la page sourçant les sources des images
     */
    public static function afficherSources(): void
    {
        self::afficherVue("Sources", "sources.php");
    }

    /**
     * @return void affiche le résultat de la recherche
     */

    public static function afficherRecherche(): void
    {
        self::$pageActuelle = 'Résultats de la recherche';

        ControleurMain::afficherVue("Résultats de la recherche", "vueResultatRecherche.php", [
            "recherche" => $_REQUEST["recherche"],
            "liste"=>$_REQUEST["liste"],
            "nbResults" => $_REQUEST["count"]
        ]);
    }

    /**
     * @return void afficher les mentions légales du site
     */
    public static function afficherMentionsLegales() :void
    {
        self::afficherVue("Mentions Légales", "vueMentionsLegales.php",Configuration::getCheminControleur()::getMenu());
    }

    //APPELS AUX SERVICES -------------------------------------------------------------------------------------------------------------------------------

    public static function seConnecter(): void
    {
        ServiceConnexion::seConnecter();
    }

    public static function seDeconnecter(): void
    {
        ServiceConnexion::seDeconnecter();
    }

    public static function validerEmail(): void
    {
        ServiceConnexion::validerEmail();
    }

    public static function motDePasseARemplir(): void
    {
        ServiceMdp::motDePasseARemplir();
    }

    public static function mdpOublie(): void
    {
        ServiceMdp::mdpOublie();
    }

    public static function rechercher(): void
    {
        ServiceRecherche::rechercher();
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /***
     * @param array $liste
     * @return array|null
     * retourne les 6 éléments avec la valeur les plus hautes
     */
    protected static function getSixMax(array $liste): ?array
    {
        $list = array();
        if (!empty($liste)) {
            $min = min(6, sizeof($liste));
            for ($i = 0; $i < $min; $i++) {
                $id = max($liste);
                $key = null;
                foreach ($liste as $item => $value) {
                    if ($value == $id) $key = $item;
                }
                unset($liste[$key]);
                $list[] = $id;
            }
        }
        return $list;
    }

    /**
     * @param array $listeId la liste des IDs déjà utilisées
     * @param string $get le nom du Request à envoyer
     * @return int envoie en $_REQUEST une id auto-incrémentée
     */
    public static function autoIncrement(array $listeId, string $get): int
    {
        $id = 1;
        while (!isset($_REQUEST[$get])) {
            if (in_array($id, $listeId)) {
                $id++;
            } else {
                $_REQUEST[$get] = $id;
            }
        }
        return $id;
    }


    /**
     * @param string $action le nom de la fonction sur laquelle rediriger
     * @param string $type le type de message Flash
     * @param string $message le message à envoyer
     * @return void redirige en envoyant un messageFlash
     */
    public static function redirectionFlash(string $action, string $type, string $message): void
    {
        MessageFlash::ajouter($type, $message);
        self::$action();
    }

    /**
     * Récupère et stocke les fichiers (par ex, CV et LM).
     */
    public static function uploadFichiers(array $fileTags, string $actionInErrorCase): array
    {
        $ids = array();
        $uploadsLocation = "../ressources/uploads/";

        foreach ($fileTags as $fileName) {
            if (!isset($_FILES[$fileName])) {
                self::redirectionFlash($actionInErrorCase, "danger", "Fichier non fourni");
                die();
            }
            $ids[$fileName] = null;
            $file = $_FILES[$fileName];

            if ($file['error'] == 1 || $file['error'] == 2) {
                self::redirectionFlash($actionInErrorCase, "warning", "Fichier " . strtoupper($fileName) . " trop lourd (si le fichier est normal, merci de reporter ce problème)");
                die();
            }
            if ($file["tmp_name"] != null) {
                $idFile = (new UploadsRepository())->insert($file['name']);
                $ids[$fileName] = $idFile;

                $fileLocation = $uploadsLocation . "$idFile-$file[name]";
                if (!move_uploaded_file($file['tmp_name'], $fileLocation))
                    self::redirectionFlash($actionInErrorCase, "danger", "Problem uploading file");
            }
        }

        return $ids;
    }
}
