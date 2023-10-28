<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurMain
{

    /***
     * Affiche la page d'acceuil du site sans qu'aucune connexion n'aie été faite
     */
    public static function afficherIndex()
    {
        self::afficherVue("Accueil", "vueIndex.php", self::getMenu());
    }

    /***
     * Affiche la page de présentations aux entreprises n'ayant pas de compte
     */
    public static function afficherVuePresentation()
    {
        self::afficherVue("Présentation Entreprise", "Entreprise/vuePresentationEntreprise.php", self::getMenu());
    }

    /***
     * Affiche la page de detail d'une offre qui varie selon le client
     */

    public static function afficherVueDetailOffre(string $idOffre = null): void
    {
        $menu = "App\FormatIUT\Controleur\Controleur" . $_REQUEST['controleur'];
        $liste = (new OffreRepository())->getListeIdOffres();
        if ($idOffre || isset($_REQUEST["idOffre"])) {
            if (!$idOffre) $idOffre = $_REQUEST['idOffre'];
            if (in_array($idOffre, $liste)) {
                $offre = (new OffreRepository())->getObjectParClePrimaire($_REQUEST['idOffre']);
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                if ($_REQUEST["controleur"] == "EntrMain") $client = "Entreprise";
                else $client = "Etudiant";
                $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                self::afficherVue("Détail de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
            } else {
                $menu::afficherErreur("L'offre n'existe pas");
            }
        } else {
            $menu::afficherErreur("L'offre n'est pas renseignée");
        }
    }

    public static function afficherVue(string $titrePage, string $cheminVue, array $menu, array $parametres = []): void
    {
        $cssPath = str_replace('vue', 'styleVue', $cheminVue);
        $cssPath = str_replace('.php', '.css', $cssPath);
        extract(array_merge(
            [
                'titrePage' => $titrePage,
                'chemin' => $cheminVue,
                'menu' => $menu,
                'css' => $cssPath
            ],
            $parametres
        ));
        require __DIR__ . "/../vue/vueGenerale.php"; // Charge la vue
    }

    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil", "lien" => "?controleur=Main&action=afficherIndex"),
            array("image" => "../ressources/images/profil.png", "label" => "(prov étudiants)", "lien" => "?controleur=EtuMain&action=afficherAccueilEtu"),
            array("image" => "../ressources/images/profil.png", "label" => "Se Connecter", "lien" => "?controleur=Main&action=afficherPageConnexion"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Accueil Entreprise", "lien" => "?controleur=Main&action=afficherVuePresentation")
        );
    }

    /***
     * @param array $liste
     * @return array|null
     * retourne les 3 éléments avec la valeur les plus hautes
     */
    protected static function getTroisMax(array $liste): ?array
    {
        $list = array();
        if (!empty($liste)) {
            $min = min(3, sizeof($liste));
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
        $menu = "App\Formatiut\Controleur\Controleur" . $_REQUEST['controleur'];
        self::afficherVue("Erreur", 'vueErreur.php', $menu::getMenu(), [
            'erreurStr' => $error
        ]);
    }

    public static function insertImage($nom)
    {
        return TransfertImage::transfert($nom);
    }

    protected static function autoIncrement($listeId, $get): int
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

    protected static function autoIncrementF($listeId, $get): int
    {
        $id = 1;
        while (!isset($_REQUEST[$get])) {
            if (in_array("F" . $id, $listeId)) {
                $id++;
            } else {
                $_REQUEST[$get] = $id;
            }
        }
        return $id;
    }

    public static function afficherPageConnexion()
    {
        self::afficherVue("Se Connecter", "vueFormulaireConnexion.php", self::getMenu());
    }

    public static function seConnecter()
    {
        if (isset($_REQUEST["login"], $_REQUEST["mdp"])) {
            $user = ((new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["login"]));
            if (!is_null($user)) {
                if (MotDePasse::verifier($_REQUEST["mdp"], $user->getMdpHache())) {
                    ConnexionUtilisateur::connecter($_REQUEST["login"]);
                    MessageFlash::ajouter("success", "Connexion Réussie");
                    header("Location: controleurFrontal.php?action=afficherAccueilEntr&controleur=EntrMain");
                    exit();
                }
            }
        }
        header("Location: controleurFrontal.php?controleur=Main&action=afficherPageConnexion&erreur=1");
    }

    public static function seDeconnecter()
    {
        ConnexionUtilisateur::deconnecter();
        Session::getInstance()->detruire();
        header("Location: controleurFrontal.php");
    }

    public static function validerEmail()
    {
        VerificationEmail::traiterEmailValidation($_REQUEST["login"], $_REQUEST["nonce"]);
        self::afficherPageConnexion();
        header("Location : controleurFrontal.php?action=afficherPageConnexion&controleur=Main");
    }

    public static function redirectionFlash(string $action, string $type, string $message)
    {
        MessageFlash::ajouter($type, $message);
        self::$action();

    }

    public static function creerCompteEntreprise()
    {
        //vérification des nombres négatifs
        if ($_REQUEST["siret"] > 0 && $_REQUEST["codePostal"] > 0 && $_REQUEST["tel"] > 0 && $_REQUEST["effectif"] > 0) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["siret"]);
            //vérification de doublon de Siret
            if (is_null($entreprise)) {
                $liste = ((new EntrepriseRepository())->getListeObjet());
                foreach ($liste as $entreprise) {
                    $listeMail[] = $entreprise->getEmail();
                }
                //vérification de doublon de mail
                if (!in_array($_REQUEST["email"], $listeMail)) {
                    //concordance des mots de passe
                    if ($_REQUEST["mdp"] == $_REQUEST["mdpConf"]) {
                        if (strlen($_REQUEST["mdp"]) >= 8) {
                            $entreprise = Entreprise::construireDepuisFormulaire($_REQUEST);
                            (new EntrepriseRepository())->creerObjet($entreprise);
                            VerificationEmail::envoiEmailValidation($entreprise);
                            header("Location: controleurFrontal.php");
                        } else {
                            self::redirectionFlash("afficherVuePresentation", "warning", "Le mot de passe doit faire plus de 7 caractères");
                        }
                    } else {
                        self::redirectionFlash("afficherVuePresentation", "warning", "Les mots de passes doivent corréler");
                    }
                } else {
                    self::redirectionFlash("afficherVuePresentation", "warning", "L'adresse mail est déjà utilisée");
                }
            } else {
                self::redirectionFlash("afficherVuePresentation", "danger", "Le SIRET est déjà utilisé");
            }
        } else {
            self::redirectionFlash("afficherVuePresentation", "danger", "Des données sont érronées");
        }
    }
}