<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Configuration\index;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\TransfertImage;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurMain
{

    /***
     * Affiche la page d'acceuil du site sans qu'aucune connexion n'aie été faite
     */
    public static function afficherIndex(): void
    {
        self::afficherVue("Accueil", "vueIndex.php", self::getMenu());
    }

    /***
     * Affiche la page de présentations aux entreprises n'ayant pas de compte
     */
    public static function afficherVuePresentation(): void
    {
        self::afficherVue("Accueil Entreprise", "Entreprise/vuePresentationEntreprise.php", self::getMenu());
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

                if (Configuration::controleurIs("EntrMain"))
                    $client = "Entreprise";
                else
                    $client = "Etudiant";

                $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                self::afficherVue("Détail de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
            } else {
                self::redirectionFlash("afficherPageConnexion", "danger", "Cette offre n'existe pas");
            }
        } else {
            self::redirectionFlash("afficherPageConnexion", "danger", "L'offre n'est pas renseignée");
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
        $menu = Configuration::getCheminControleur();

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

    public static function afficherPageConnexion(): void
    {
        self::afficherVue("Se Connecter", "vueFormulaireConnexion.php", self::getMenu());
    }

    public static function seConnecter(): void
    {
        if (isset($_REQUEST["login"], $_REQUEST["mdp"])) {
            $user = ((new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["login"]));
            if (!is_null($user)) {
                if (MotDePasse::verifier($_REQUEST["mdp"], $user->getMdpHache())) {
                    if (VerificationEmail::aValideEmail($user)) {
                        ConnexionUtilisateur::connecter($user->getSiret(), "Entreprise");
                        MessageFlash::ajouter("success", "Connexion Réussie");
                        header("Location: controleurFrontal.php?action=afficherAccueilEntr&controleur=EntrMain");
                        exit();
                    }
                }
            } else if (ConnexionLdap::connexion($_REQUEST["login"], $_REQUEST["mdp"], "connexion")) {
                ConnexionUtilisateur::connecter($_REQUEST['login'], ConnexionLdap::getInfoPersonne()["type"]);
                MessageFlash::ajouter("success", "Connexion Réussie");
                if (ConnexionUtilisateur::premiereConnexion($_REQUEST["login"])) {
                    header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain&premiereConnexion=true");
                } elseif (!ConnexionUtilisateur::profilEstComplet($_REQUEST["login"])) {
                    header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain&premiereConnexion=true");
                } else {
                    header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain");
                }
                exit();
            }
        }
        header("Location: controleurFrontal.php?controleur=Main&action=afficherPageConnexion&erreur=1");
    }

    public static function seDeconnecter(): void
    {
        ConnexionUtilisateur::deconnecter();
        Session::getInstance()->detruire();
        self::redirectionFlash("afficherIndex", "info", "Vous êtes déconnecté");
    }

    public static function validerEmail(): void
    {
        VerificationEmail::traiterEmailValidation($_REQUEST["login"], $_REQUEST["nonce"]);
        self::redirectionFlash("afficherPageConnexion", "success", "Email validé");
    }

    public static function redirectionFlash(string $action, string $type, string $message): void
    {
        MessageFlash::ajouter($type, $message);
        (Configuration::getCheminControleur())::$action();

    }

    public static function creerCompteEntreprise(): void
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
                            self::redirectionFlash("afficherPageConnexion", "info", "Un email de validation vous a été envoyé");
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

    public static function mdpOublie(): void
    {
        if (isset($_REQUEST["mail"])) {
            $liste = ((new EntrepriseRepository())->getListeObjet());
            foreach ($liste as $entreprise) {
                $listeMail[] = $entreprise->getEmail();
            }
            //vérification de doublon de mail
            if (in_array($_REQUEST["mail"], $listeMail)) {
                $entreprise = (new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["mail"]);
                $entreprise->setNonce(MotDePasse::genererChaineAleatoire());
                (new EntrepriseRepository())->modifierObjet($entreprise);
                VerificationEmail::EnvoyerMailMdpOublie($entreprise);
                self::afficherIndex();
            } else {
                self::redirectionFlash("afficherPageConnexion", "warning", "Cette adresse mail n'existe pas");
            }
        }
    }

    public static function motDePasseARemplir(): void
    {
        if (!isset($_REQUEST["login"], $_REQUEST["nonce"]))
            self::afficherErreur("Lien corrompu (à transformer en flash, pb de \$_GET)");
        else
            self::afficherVue("Mot de Passe oublié", "Entreprise/vueResetMdp.php", self::getMenu());
    }


    public static function resetMdp(): void
    {
        if (isset($_REQUEST["mdp"], $_REQUEST["confirmerMdp"])) {
            $entreprise = (new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["login"]);
            if ($_REQUEST["nonce"] == $entreprise->getNonce()) {
                if ($_REQUEST["mdp"] == $_REQUEST["confirmerMdp"]) {
                    if (strlen($_REQUEST["mdp"]) >= 8) {
                        $entreprise->setMdpHache(MotDePasse::hacher($_REQUEST["mdp"]));
                        $entreprise->setNonce(MotDePasse::genererChaineAleatoire(22));
                        (new EntrepriseRepository())->modifierObjet($entreprise);
                        self::redirectionFlash("afficherPageConnexion", "success", "Mot de passe modifié");
                    } else {
                        self::redirectionFlash("motDePasseARemplir", "warning", "Le mot de passe doit faire plus de 7 caractères");
                    }
                } else {
                    self::redirectionFlash("motDePasseARemplir", "warning", "Les mots de passe doivent corréler");
                }
            } else {
                self::redirectionFlash("motDePasseARemplir", "danger", "Lien invalide. Veuillez réessayer");
            }
        }
    }

    public static function rechercher(): void
    {
        $controleur = Configuration::getCheminControleur();

        if (!isset($_REQUEST['recherche'])) {
            $controleur::afficherErreur("Il faut renseigner une recherche.");
            return;
        }

        $recherche = $_REQUEST['recherche'];
        $morceaux = explode(" ", $recherche);

        $res = AbstractRepository::getResultatRechercheTrie($morceaux);
        if ($res == null)
            self::afficherErreur("Erreur dans la recherche, veuillez réessayer.");
        else
            $controleur::afficherVue("Résultat de la recherche", "vueResultatRecherche.php", $controleur::getMenu(), [
                "recherche" => $recherche,
                "offres" => $res['offres'],
                "entreprises" => $res['entreprises']
            ]);
    }

    public static function afficherSources()
    {
        self::afficherVue("Sources", "sources.php", self::getMenu());
    }
}
