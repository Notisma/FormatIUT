<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class FiltresEtudiant
{
    public static function etudiant_A1():string
    {
        return " AND groupe LIKE \"S\"";
    }
    public static function etudiant_A2():string
    {
        return " AND groupe LIKE \"Q\"";
    }
    public static function etudiant_A3():string
    {
        return " AND groupe LIKE \"G\"";
    }

    public static function etudiant_concerne():string
    {
        $entreprise=(new EntrepriseRepository())->getEntrepriseParMail(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        $idEntreprise=$entreprise->getSiret();
        return " AND numEtudiant IN (SELECT idEtudiant FROM Formations WHERE idEntreprise=76543128904567 )";
    }

    public static function etudiant_avec_formation():string
    {
        return " ";
    }

    public static function etudiant_sans_formation():string
    {
        return "";
    }
    public static function etudiant_stage():string
    {
        return "";
    }
    public static function etudiant_alternance():string
    {
        return "";
    }
}