<?php
namespace App\FormatIUT\Lib;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";
    private static string $cleTypeConnexion ="_typeUtilisateurConnecte";

    public static function connecter(string $loginUtilisateur,string $typeUtilisateur): void
    {
        $session=Session::getInstance();
        $session->enregistrer(self::$cleConnexion,$loginUtilisateur);
        $session->enregistrer(self::$cleTypeConnexion,$typeUtilisateur);
    }

    public static function estConnecte(): bool
    {
        // À compléter
        $session=Session::getInstance();
        return $session->contient(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        // À compléter
        $session=Session::getInstance();
        if (self::getTypeConnecte()=="Etudiant"){
            ConnexionLdap::deconnexion();
        }
        $session->supprimer(self::$cleConnexion);

    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        // À compléter
        if (self::estConnecte()){
            $session=Session::getInstance();
            return $session->lire(self::$cleConnexion);
        }
        return null;
    }
    public static function getNumEtudiantConnecte():?int{
        if (self::estConnecte()){
            $session=Session::getInstance();
            $Loginetu=$session->lire(self::$cleConnexion);
            return (new EtudiantRepository())->getNumEtudiantParLogin($Loginetu);
        }
        return null;
    }

    public static function getTypeConnecte():?string{
        if (self::estConnecte()){
            $session=Session::getInstance();
            return $session->lire(self::$cleTypeConnexion);
        }
        return null;
    }

    public static function premiereConnexion(string $login) : void{
        if (!(new EtudiantRepository())->estEtudiant($login)){
            //afficherPopUp pour informations
            $infos=ConnexionLdap::getInfoPersonne();
            $value=array("numEtudiant"=>"2","loginEtudiant"=>$login,"nomEtudiant"=>$infos["nom"],"prenomEtudiant"=>$infos["prenom"],"mailUniversitaire"=>$infos["mail"]);
            (new EtudiantRepository())->premiereConnexion($value);

        }
    }
}