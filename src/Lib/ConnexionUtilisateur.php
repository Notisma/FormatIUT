<?php
namespace App\FormatIUT\Lib;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;

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
        if (self::estConnecte()) {
            $session = Session::getInstance();
            if (self::getTypeConnecte() == "Etudiant") {
                ConnexionLdap::deconnexion();
            }
            $session->supprimer(self::$cleConnexion);
            $session->supprimer(self::$cleTypeConnexion);
        }

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

    public static function getNumEntrepriseConnectee():?int{
        if (self::estConnecte()){
            $session=Session::getInstance();
            $loginentr=$session->lire(self::$cleConnexion);
           return $loginentr;
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

    public static function genererChiffresAleatoires(int $nbChiffres = 8): string
    {
        $chiffres = "";
        for ($i = 0; $i < $nbChiffres; $i++) {
            $chiffres .= rand(0, 9);
        }
        return $chiffres;
    }

    public static function premiereConnexionEtu(string $login) : bool{
        if (!(new EtudiantRepository())->estEtudiant($login)){
            $infos=ConnexionLdap::getInfoPersonne();
            echo $infos["mail"];
            $value=array("numEtudiant"=>self::genererChiffresAleatoires(),"prenomEtudiant"=>$infos["prenom"],"nomEtudiant"=>$infos["nom"],"loginEtudiant"=>$login,"mailUniversitaire"=>$infos["mail"]);
            (new EtudiantRepository())->premiereConnexion($value);
            return true;
        }
        return false;
    }

    public static function premiereConnexionProf(string $login)
    {
        if (!(new ProfRepository())->estProf($login)){
            $infos=ConnexionLdap::getInfoPersonne();
            $prof=new Prof(2,$infos["nom"],$infos["prenom"],$infos["mail"]);
            (new ProfRepository())->creerObjet($prof);
        }
    }

    public static function profilEstComplet(string $login) : bool {
        $etudiant=(new EtudiantRepository())->getObjectParClePrimaire(self::getNumEtudiantConnecte());
        if ($etudiant->getGroupe()!="" && $etudiant->getParcours()!=""){
            return true;
        }
        return false;
    }


}