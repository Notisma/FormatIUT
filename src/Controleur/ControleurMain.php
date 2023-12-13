<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\Historique;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\StringUtils;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;

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
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
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

    /***
     * @return void Affiche la page d'acceuil du site sans qu'aucune connexion n'aie été faite
     */
    public static function afficherIndex(): void
    {
        self::afficherVue("Accueil", "vueIndex.php", self::getMenu());
    }

    /***
     * @return void Affiche la page de présentations aux entreprises n'ayant pas de compte
     */
    public static function afficherVuePresentation(): void
    {
        self::afficherVue("Accueil Entreprise", "Entreprise/vuePresentationEntreprise.php", self::getMenu());
    }

    /***
     * @return void Affiche la page de detail d'une offre qui varie selon le client
     */
    public static function afficherVueDetailOffre(string $idFormation = null): void
    {
        if (!isset($_REQUEST['idFormation']) && is_null($idFormation))
            self::afficherErreur("Il faut préciser la formation");

        if (Configuration::controleurIs("EtuMain")) {
            $anneeEtu = (new EtudiantRepository())->getAnneeEtudiant((new EtudiantRepository())->getObjectParClePrimaire(ControleurEtuMain::getCleEtudiant()));
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
            if (($anneeEtu >= $offre->getAnneeMin()) && $anneeEtu <= $offre->getAnneeMax()) {
                if ($offre->getEstValide()) {
                    self::$pageActuelle = "Détails de l'offre";
                    /** @var ControleurMain $menu */
                    $menu = Configuration::getCheminControleur();
                    $liste = (new FormationRepository())->getListeidFormations();
                    if ($idFormation || isset($_REQUEST["idFormation"])) {
                        if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
                        if (in_array($idFormation, $liste)) {
                            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                            $client = "Etudiant";
                            $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                            self::afficherVue("Détails de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
                        } else {
                            self::redirectionFlash("afficherPageConnexion", "danger", "Cette offre n'existe pas");
                        }
                    } else {
                        self::redirectionFlash("afficherPageConnexion", "danger", "L'offre n'est pas renseignée");
                    }
                } else {
                    self::redirectionFlash("afficherCatalogue", "danger", "Vous n'avez pas le droit de voir cette offre");
                }
            } else {
                self::redirectionFlash("afficherCatalogue", "danger", "Vous n'avez pas le droit de voir cette offre");
            }
        } else if (Configuration::controleurIs("EntrMain")) {
            $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
            if ($offre->getIdEntreprise() == ConnexionUtilisateur::getNumEntrepriseConnectee()) {
                self::$pageActuelle = "Détails de l'offre";
                /** @var ControleurMain $menu */
                $menu = Configuration::getCheminControleur();
                $liste = (new FormationRepository())->getListeidFormations();
                if ($idFormation || isset($_REQUEST["idFormation"])) {
                    if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
                    if (in_array($idFormation, $liste)) {
                        $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                        $client = "Entreprise";
                        $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                        self::afficherVue("Détail de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
                    } else {
                        self::redirectionFlash("afficherPageConnexion", "danger", "Cette offre n'existe pas");
                    }
                } else {
                    self::redirectionFlash("afficherPageConnexion", "danger", "L'offre n'est pas renseignée");
                }
            } else {
                self::redirectionFlash("afficherMesOffres", "danger", "Vous ne pouvez pas accéder à cette offre");
            }
        } else {
            self::$pageActuelle = "Détails de l'offre";
            /** @var ControleurMain $menu */
            $menu = Configuration::getCheminControleur();
            $liste = (new FormationRepository())->getListeidFormations();
            if ($idFormation || isset($_REQUEST["idFormation"])) {
                if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
                if (in_array($idFormation, $liste)) {
                    $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                    $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                    $client = "Admin";
                    $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                    self::afficherVue("Détails de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
                } else {
                    self::redirectionFlash("afficherPageConnexion", "danger", "Cette offre n'existe pas");
                }
            } else {
                self::redirectionFlash("afficherPageConnexion", "danger", "L'offre n'est pas renseignée");
            }
        }
    }

    /**
     * @param string $error le message que l'erreur va afficher
     * @return void fonctions pour afficher la page d'erreur
     */
    public static function afficherErreur(string $error): void
    {
        /** @var ControleurMain $menu */
        $menu = Configuration::getCheminControleur();

        self::afficherVue("Erreur", 'vueErreur.php', $menu::getMenu(), [
            'erreurStr' => $error
        ]);
    }

    /**
     * @return void affiche la page de connexion
     */
    public static function afficherPageConnexion(): void
    {
        self::afficherVue("Se Connecter", "vueFormulaireConnexion.php", self::getMenu());
    }

    /**
     * @return void affiche la page sourçant les sources des images
     */
    public static function afficherSources(): void
    {
        self::afficherVue("Sources", "sources.php", self::getMenu());
    }

    /**
     * @return void affiche la vue pour réinitialiser le mot de passe
     */
    public static function afficherMotDePasseARemplir(): void
    {
        if (!isset($_REQUEST["login"], $_REQUEST["nonce"]))
            self::afficherErreur("Lien corrompu (à transformer en flash, pb de \$_GET)");
        else
            self::afficherVue("Mot de Passe oublié", "Entreprise/vueResetMdp.php", self::getMenu());
    }

    //FONCTIONS D'ACTIONS ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void action connectant l'utilisateur
     */
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
                $prof = (new ProfRepository())->getObjectParClePrimaire($_REQUEST["login"]);
                if (!is_null($prof)) {
                    if ($prof->isEstAdmin()) {
                        ConnexionUtilisateur::connecter($_REQUEST["login"], "Administrateurs");
                    }
                }
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    header("Location : controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
                } else if (ConnexionUtilisateur::getTypeConnecte() == "Personnels") {
                    header("Location : controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
                } else if (ConnexionUtilisateur::premiereConnexionEtu($_REQUEST["login"])) {
                    MessageFlash::ajouter('info', "Veuillez compléter votre profil");
                    header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain&premiereConnexion=true");
                } elseif (!ConnexionUtilisateur::profilEstComplet($_REQUEST["login"])) {
                    header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain&premiereConnexion=true");
                } else {
                    header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain");
                }
                exit();
            } else if ($_REQUEST["login"] == "ProfTest") {
                if (MotDePasse::verifier($_REQUEST["mdp"], '$2y$10$oBxrVTdMePhNpS5y4SzhHefAh7HIUrbzAU0vSpfBhDFUysgu878B2')) {
                    ConnexionUtilisateur::connecter($_REQUEST["login"], "Personnels");
                    MessageFlash::ajouter("success", "Connexion Réussie");
                    header("Location:controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
                    exit();
                }
            } else if ($_REQUEST["login"] == "AdminTest") {
                if (MotDePasse::verifier($_REQUEST["mdp"], '$2y$10$oBxrVTdMePhNpS5y4SzhHefAh7HIUrbzAU0vSpfBhDFUysgu878B2')) {
                    ConnexionUtilisateur::connecter($_REQUEST["login"], "Administrateurs");
                    MessageFlash::ajouter("success", "Connexion Réussie");
                    header("Location:controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
                    exit();
                }
            }
        }
        header("Location: controleurFrontal.php?controleur=Main&action=afficherPageConnexion&erreur=1");
    }

    /**
     * @return void déconnecte l'utilisateur
     */
    public static function seDeconnecter(): void
    {
        ConnexionUtilisateur::deconnecter();
        Session::getInstance()->detruire();
        self::redirectionFlash("afficherIndex", "info", "Vous êtes déconnecté");
    }

    /**
     * @return void valide l'email grâce au lien envoyé par mail
     */
    public static function validerEmail(): void
    {
        VerificationEmail::traiterEmailValidation($_REQUEST["login"], $_REQUEST["nonce"]);
        self::redirectionFlash("afficherPageConnexion", "success", "Email validé");
    }

    /**
     * @return void créeer une entreprise dans la BD et envoie un mail de validation
     */
    public static function creerCompteEntreprise(): void
    {
        //vérification des nombres négatifs
        if ($_REQUEST["siret"] > 0 && $_REQUEST["codePostal"] > 0 && $_REQUEST["tel"] > 0 && $_REQUEST["effectif"] > 0) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["siret"]);
            //vérification de doublon de Siret
            if (is_null($entreprise)) {
                $liste = ((new EntrepriseRepository())->getListeObjet());
                $listeMail = null;
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

    /**
     * @return void envoie un mail pour réinitialiser le mot de passe d'un compte Entreprise
     */
    public static function mdpOublie(): void
    {
        if (isset($_REQUEST["mail"])) {
            $liste = ((new EntrepriseRepository())->getListeObjet());
            $listeMail = null;
            foreach ($liste as $entreprise) {
                $listeMail[] = $entreprise->getEmail();
            }
            //vérification de doublon de mail
            if (in_array($_REQUEST["mail"], $listeMail)) {
                $entreprise = (new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["mail"]);
                $entreprise->setNonce(MotDePasse::genererChaineAleatoire());
                (new EntrepriseRepository())->modifierObjet($entreprise);
                VerificationEmail::envoyerMailMdpOublie($entreprise);
                self::afficherIndex();
            } else {
                self::redirectionFlash("afficherPageConnexion", "warning", "Cette adresse mail n'existe pas");
            }
        }
    }

    /**
     * @return void permet à l'utilisateur de réinitialiser son mot de passe
     */
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

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /***
     * @param array $liste
     * @return array|null
     * retourne les 3 éléments avec la valeur les plus hautes
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
    protected static function autoIncrement(array $listeId, string $get): int
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
     * @param array $listeId la liste des IDs déjà utilisées
     * @param string $get le nom du Request à envoyer
     * @return int envoie en $_REQUEST une id auto-incrémentée pour les formations
     */
    protected static function autoIncrementF(array $listeId, string $get): int
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

    /**
     * @param string $action le nom de la fonction sur laquelle rediriger
     * @param string $type le type de message Flash
     * @param string $message le message à envoyer
     * @return void redirige en envoyant un messageFlash
     */
    protected static function redirectionFlash(string $action, string $type, string $message): void
    {
        MessageFlash::ajouter($type, $message);
        (Configuration::getCheminControleur())::$action();
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
                var_dump($file['name']);
                echo "<br>";
                var_dump(StringUtils::filter_filename(basename($file['name'])));

                $fileLocation = $uploadsLocation . $idFile . '-' . basename($file['name']);
                if (!move_uploaded_file($file['tmp_name'], $fileLocation))
                    self::redirectionFlash($actionInErrorCase, "danger", "Problem uploading file");
            }
        }

        return $ids;
    }
}
