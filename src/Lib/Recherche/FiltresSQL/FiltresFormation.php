<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\FiltresSQL;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class FiltresFormation
{

    public static function formation_stage(): string
    {
        if (self::formation_type()) {
            return " AND (typeOffre=\"Stage\" OR typeOffre=\"Stage / Alternance\") ";
        } else return "";
    }

    public static function formation_alternance(): string
    {
        if (self::formation_type()) {
            return " AND (typeOffre=\"Alternance\" OR typeOffre=\"Stage / Alternance\")";
        } else return "";
    }

    public static function formation_type(): bool
    {
        if (isset($_REQUEST["formation_stage"], $_REQUEST["formation_alternance"])) {
            return false;
        } else {
            return true;
        }
    }

    public static function formation_validee(): string
    {
        if (self::validite_formation())
            return " AND estValide=1 ";
        else return "";
    }

    public static function formation_non_validee(): string
    {
        if (self::validite_formation())
            return " AND estValide=0 ";
        else return "";
    }

    public static function validite_formation(): bool
    {
        if (isset($_REQUEST["formation_validee"], $_REQUEST["formation_non_validee"])) {
            return false;
        } else return true;
    }

    public static function formation_disponible(): string
    {
        if (self::disponibilite_formation())
        return " AND idEtudiant is null";
        else return "";
    }

    public static function formation_non_disponible(): string
    {
        if (self::disponibilite_formation())
        return " AND idEtudiant is not null";
        else return "";
    }

    public static function disponibilite_formation(): bool
    {
        if (isset($_REQUEST["formation_disponible"],$_REQUEST["formation_non_disponible"])){
            return false;
        }else return true;
    }

    public static function formation_entreprise(): string
    {
        $entreprise = (new EntrepriseRepository())->getEntrepriseParMail(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        $idEntreprise = $entreprise->getSiret();
        return " AND idEntreprise=$idEntreprise";
    }
}