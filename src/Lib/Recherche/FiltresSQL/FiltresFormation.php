<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\FiltresSQL;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class FiltresFormation
{

    public static function formation_stage():string
    {
        return " AND (typeOffre=\"Stage\" OR typeOffre=\"Stage/Alternance\") ";
    }
    public static function formation_alternance():string
    {
        return " AND (typeOffre=\"Alternance\"  OR typeOffre=\"Stage/Alternance\")";
    }
    public static function formation_validee():string
    {
        return " AND estValide=1 ";
    }
    public static function formation_non_validee():string
    {
        return " AND estValide=0 ";
    }
    public static function formation_disponible():string
    {
        return " AND idEtudiant is null";
    }
    public static function formation_entreprise() :string
    {
        $entreprise=(new EntrepriseRepository())->getEntrepriseParMail(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        $idEntreprise=$entreprise->getSiret();
        return " AND idEntreprise=$idEntreprise";
    }
}