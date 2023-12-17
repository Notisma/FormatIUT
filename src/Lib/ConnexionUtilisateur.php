<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\DataObject\UtilisateurObject;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";
    private static string $cleTypeConnexion = "_typeUtilisateurConnecte";

    public static function connecter(UtilisateurObject $user): void
    {
        $session = Session::getInstance();
        $session->enregistrer(self::$cleConnexion, $user);
        $session->enregistrer(self::$cleTypeConnexion, $user->getTypeConnecte());
    }

    public static function estConnecte(): bool
    {
        // À compléter
        $session = Session::getInstance();
        return $session->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        // À compléter
        if (self::estConnecte()) {
            $session = Session::getInstance();
            if (self::getTypeConnecte() == "Etudiants") {
                ConnexionLdap::deconnexion();
            }
            $session->supprimer(self::$cleConnexion);
            $session->supprimer(self::$cleTypeConnexion);
        }

    }

    public static function getUtilisateurConnecte() : ?UtilisateurObject
    {
        if (self::estConnecte()){
            $session=Session::getInstance();
            return $session->lire(self::$cleConnexion);
        }
        return null;
    }



    public static function getTypeConnecte(): ?string
    {
        if (self::estConnecte()) {
            $session = Session::getInstance();
            return $session->lire(self::$cleTypeConnexion);
        }
        return null;
    }

    public static function genererChiffresAleatoires(int $nbChiffres = 8): string
    {
        $chiffres = "";
        for ($i = 0; $i < $nbChiffres; $i++) {
            $chiffres .= rand(0, 9);
        }
        return $chiffres;
    }

    public static function premiereConnexionEtu(string $login): bool
    {
        if (!(new EtudiantRepository())->estEtudiant($login)) {
            $infos = ConnexionLdap::getInfoPersonne();
            echo $infos["mail"];
            $value = array("numEtudiant" => self::genererChiffresAleatoires(), "prenomEtudiant" => $infos["prenom"], "nomEtudiant" => $infos["nom"], "loginEtudiant" => $login, "mailUniversitaire" => $infos["mail"]);
            (new EtudiantRepository())->premiereConnexion($value);
            return true;
        }
        $numEtu=(new EtudiantRepository())->getNumEtudiantParLogin($_REQUEST["login"]);
        $etudiant =(new EtudiantRepository())->getObjectParClePrimaire($numEtu);
        var_dump($etudiant);
        if ($etudiant->getGroupe() == "" || $etudiant->getParcours() == "") {
            return true;
        }
        return false;
    }

    public static function premiereConnexionProf(string $login)
    {
        if (!(new ProfRepository())->estProf($login)) {
            $infos = ConnexionLdap::getInfoPersonne();
            $prof = new Prof($infos["login"], $infos["nom"], $infos["prenom"], $infos["mail"],0,0);
            (new ProfRepository())->creerObjet($prof);
        }
    }
    public static function premiereConnexionProfTest(string $login)
    {
        if (!(new ProfRepository())->estProf($login)) {
            $prof = new Prof($_REQUEST["login"], "secretariat", "secretariat", "mail",0,1);
            (new ProfRepository())->creerObjet($prof);
        }
    }

    public static function profilEstComplet(string $login): bool
    {

        return false;
    }

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


}