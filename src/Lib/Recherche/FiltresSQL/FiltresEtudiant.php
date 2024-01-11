<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class FiltresEtudiant
{
    public static function etudiant_A1():string
    {
        self::annee_etudiant("etudiant_A1");
        return " groupe LIKE \"S%\"";
    }
    public static function etudiant_A2():string
    {
        return " groupe LIKE \"Q%\"";
    }
    public static function etudiant_A3():string
    {
        return " groupe LIKE \"G%\"";
    }

    public static function annee_etudiant(string $filtre)
    {
        $filtreL=array($filtre);
        foreach ($_REQUEST as $item) {
            if (in_array($item,get_class_methods("App\\FormatIUT\\Lib\\Recherche\\FiltresSQL\\FiltresEtudiant")) && $item!=$filtre){
                if (str_contains($item,"etudiant_A")){
                    $filtreL[]=$item;
                }
            }
        }
    }


    public static function etudiant_concerne():string
    {
        $entreprise=(new EntrepriseRepository())->getEntrepriseParMail(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        $idEntreprise=$entreprise->getSiret();
        return " EXISTS (SELECT idEtudiant FROM Formations WHERE idEntreprise=$idEntreprise AND E.numEtudiant=F.idEtudiant)";
    }

    public static function etudiant_avec_formation():?string
    {
        if (self::EnFormation_etudiant())
        return " EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant)";
        else return null;
    }

    public static function etudiant_sans_formation():?string
    {
        if (self::enFormation_etudiant())
        return " NOT EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant)";
        else return null;
    }

    public static function enFormation_etudiant() :bool
    {
        if (isset($_REQUEST["etudiant_avec_formation"],$_REQUEST["etudiant_sans_formation"])){
            return false;
        }else return true;
    }
    public static function etudiant_stage():?string
    {
        if (self::typeOffre_etudiant())
        return " EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant AND (typeOffre=\"Stage\" OR typeOffre=\"Stage / Alternance\"))";
        return null;
    }
    public static function etudiant_alternance():?string
    {
        if (self::typeOffre_etudiant())
        return " EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant AND (typeOffre=\"Alternance\" OR typeOffre=\"Stage / Alternance\"))";
        return null;
    }

    private static function typeOffre_etudiant():bool
    {
        if (isset($_REQUEST["etudiant_alternance"],$_REQUEST["etudiant_stage"])) {
            return false;
        }else return true;
    }
}