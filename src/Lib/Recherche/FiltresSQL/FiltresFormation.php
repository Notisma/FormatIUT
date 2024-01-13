<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\FiltresSQL;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class FiltresFormation
{

    public static function formation_stage(): string
    {
        $sql = " (typeOffre=\"Stage\" OR typeOffre=\"Stage/Alternance\") ";
        return self::formation_type($sql);
    }

    public static function formation_alternance(): string
    {
        $sql = " (typeOffre=\"Alternance\" OR typeOffre=\"Stage/Alternance\")";
        return self::formation_type($sql);
    }

    public static function formation_type(string $sql): string
    {
        if (isset($_REQUEST["formation_stage"], $_REQUEST["formation_alternance"])) {
            return "";
        } else {
            return $sql;
        }
    }

    public static function formation_validee(): string
    {
        $sql = " estValide=1 ";
        return self::validite_formation($sql);

    }

    public static function formation_non_validee(): string
    {
        $sql = " estValide=0 ";
        return self::validite_formation($sql);
    }

    public static function validite_formation(string $sql): string
    {
        if (isset($_REQUEST["formation_validee"], $_REQUEST["formation_non_validee"])) {
            return "";
        } else return $sql;
    }

    public static function formation_disponible(): string
    {
        $sql = " idEtudiant is null";
        return self::disponibilite_formation($sql);
    }

    public static function formation_non_disponible(): string
    {
        $sql = " idEtudiant is not null";
        return self::disponibilite_formation($sql);
    }

    public static function disponibilite_formation(string $sql): string
    {
        if (isset($_REQUEST["formation_disponible"], $_REQUEST["formation_non_disponible"])) {
            return "";
        } else return $sql;
    }

    public static function formation_entreprise(): string
    {
        $entreprise = (new EntrepriseRepository())->getEntrepriseParMail(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        $idEntreprise = $entreprise->getSiret();
        return " idEntreprise=$idEntreprise";
    }
}