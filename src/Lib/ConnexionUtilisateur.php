<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Lib\Users\Utilisateur;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;

class ConnexionUtilisateur
{
    private static string $cleConnexion = "_utilisateurConnecte";

    /**
     * @param Utilisateur $user l'utiliser à connecté
     * @return void enregistre dans la session l'utilisateur à connecté
     */
    public static function connecter(Utilisateur $user): void
    {
        $session = Session::getInstance();

        $session->enregistrer(self::$cleConnexion, $user);
    }

    /**
     * @return bool permet de savoir si un utilisateur est connecté
     */
    public static function estConnecte(): bool
    {
        $session = Session::getInstance();
        return $session->contient(self::$cleConnexion);
    }

    /**
     * @return void déconnecte l'utilisateur connecté en le supprimant de la session
     */
    public static function deconnecter(): void
    {
        if (self::estConnecte()) {
            $session = Session::getInstance();
            if (self::getTypeConnecte() == "Etudiants") {
                ConnexionLdap::deconnexion();
            }
            $session->supprimer(self::$cleConnexion);
        }

    }

    /**
     * @return Utilisateur|null l'utilisateur connecté, null si non connecté
     */
    public static function getUtilisateurConnecte():?Utilisateur
    {
        if (self::estConnecte()) {
            $session = Session::getInstance();
            $user = $session->lire(self::$cleConnexion);

            return $user;
        }
        return null;
    }

    /**
     * @return string|null le login de l'utilisateur connecté, null si non connecté
     */
    public static function getLoginUtilisateurConnecte(): ?string
    {
        // À compléter
        if (self::estConnecte()) {
            $session = Session::getInstance();
            $user = $session->lire(self::$cleConnexion);
            return $user->getLogin();
        }
        return null;
    }

    /**
     * @return int|null le numéro etudiant de l'étudiant connecté, null si non connecté
     */
    public static function getNumEtudiantConnecte(): ?int
    {
        if (self::estConnecte()) {
            $session = Session::getInstance();
            $Loginetu = $session->lire(self::$cleConnexion);
            return (new EtudiantRepository())->getNumEtudiantParLogin($Loginetu->getLogin());
        }
        return null;
    }

    /**
     * @return int|null le siret de l'entreprise connecté, null si non connecté
     */
    public static function getNumEntrepriseConnectee(): ?int
    {
        if (self::estConnecte()) {
            $session = Session::getInstance();
            $loginentr = $session->lire(self::$cleConnexion);
            return (new EntrepriseRepository())->getEntrepriseParMail($loginentr->getLogin())->getSiret();
        }
        return null;
    }

    /**
     * @return string|null le type d'utilisateur connecté, null si non connecté
     */
    public static function getTypeConnecte(): ?string
    {
        if (self::estConnecte()) {
            $session = Session::getInstance();
            $user = $session->lire(self::$cleConnexion);
            return $user->getTypeConnecte();
        }
        return null;
    }

    /**
     * @param string $login le login de l'étudiant qui se connecte
     * @return bool vérifie si l'étudiant connecté se connecte pour la première fois sur le site, si oui, l'enregistre dans la BD
     */
    public static function premiereConnexionEtu(string $login): bool
    {
        if (!(new EtudiantRepository())->estEtudiant($login)) {
            $infos = ConnexionLdap::getInfoPersonne();
            $value = array("numEtudiant" => self::genererChiffresAleatoires(), "prenomEtudiant" => $infos["prenom"], "nomEtudiant" => $infos["nom"], "loginEtudiant" => $login, "mailUniversitaire" => $infos["mail"]);
            (new EtudiantRepository())->premiereConnexion($value);
            return true;
        }
        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire(self::getNumEtudiantConnecte());
        if ($etudiant->getGroupe() == "" || $etudiant->getParcours() == "") {
            return true;
        }
        return false;
    }

    /**
     * @param string $login le login du personnel qui se connecte
     * @return void enregistre dans la BD le personnel s'il s'agit de sa première connexion sur le site
     */
    public static function premiereConnexionProf(string $login):void
    {
        if (!(new ProfRepository())->estProf($login)) {
            $infos = ConnexionLdap::getInfoPersonne();
            $prof = new Prof($infos["login"], $infos["nom"], $infos["prenom"], $infos["mail"], 0, 0);
            (new ProfRepository())->creerObjet($prof);
        }
    }

    /**
     * @param string $login le login de l'utilisateur test qui se connecte
     * @return void enregistre dans la BD le personnel test s'il s'agit de sa premoère connexion sur le site
     */
    public static function premiereConnexionTest(string $login):void
    {
        if(str_contains($login,"Etu")) {
            if (!(new EtudiantRepository())->estEtudiant($login)) {
                $etudiant = array("numEtudiant" => "0", "prenomEtudiant" => "etudiant", "nomEtudiant" => "test", "loginEtudiant" => $login, "mailUniversitaire" => "etudiant.test@etu.umontpellier.fr", "groupe" => "Q2", "parcours" => "RACDV");
                $etu = Etudiant::creerEtudiant($etudiant);
                (new EtudiantRepository())->creerObjet($etu);
            }
        }else if (!(new ProfRepository())->estProf($login)) {
            $prof = new Prof($_REQUEST["login"], "secretariat", "secretariat", "mail", 0, 1);
            (new ProfRepository())->creerObjet($prof);
        }
    }    /**
     * @param string $controleur le controleur sur lequel l'utilisateur se rend
     * @return bool vérifie si l'utilisateur connecté à les droits pour se rendre sur les pages
     */
    public static function verifConnecte(string $controleur):bool{
        $bool=false;
        if ($controleur == "EntrMain" && \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Entreprise") {
            $bool=true;
        } else if ($controleur=="EtuMain" && \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Etudiants") {
            $bool=true;
        } else if ($controleur=="AdminMain" && \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()!="Administrateurs") {
            if (ConnexionUtilisateur::getTypeConnecte()!="Personnels")
                if (ConnexionUtilisateur::getTypeConnecte()!="Secretariat")
                    $bool=true;
        }
        return $bool;
    }

    /**
     * @param int $nbChiffres le nombre de chiffre à générer
     * @return string un nombre aléatoire de taille nbChiffres
     */
    public static function genererChiffresAleatoires(int $nbChiffres = 8): string
    {
        $chiffres = "";
        for ($i = 0; $i < $nbChiffres; $i++) {
            $chiffres .= rand(0, 9);
        }
        return $chiffres;
    }


}