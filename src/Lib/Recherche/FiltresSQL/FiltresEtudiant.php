<?php

namespace App\FormatIUT\Lib\Recherche\FiltresSQL;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class FiltresEtudiant
{
    public static function etudiant_A1(): string
    {
        $sql = " groupe LIKE \"S%\"";
        return self::annee_etudiant($sql);
    }

    public static function etudiant_A2(): string
    {
        $sql= " groupe LIKE \"Q%\"";
        return self::annee_etudiant($sql);

    }

    public static function etudiant_A3(): string
    {
        $sql= " groupe LIKE \"G%\"";
        return self::annee_etudiant($sql);

    }

    public static function annee_etudiant(string $filtre): string
    {
        foreach ($_REQUEST as $item) {
            if (in_array($item, get_class_methods("App\\FormatIUT\\Lib\\Recherche\\FiltresSQL\\FiltresEtudiant"))) {
                if (str_contains($item, "etudiant_A")) {
                    $filtreL[] = $item;
                }
            }
        }
        if (count($filtreL) > 1) {
            $sql="(";
            foreach ($filtreL as $item) {
                $sql.=" groupe LIKE \"";
                if (str_contains($item, "A1")) {
                    $sql.="S";
                } else if (str_contains($item, "A2")) {
                    $sql.="Q";
                } else if (str_contains($item, "A3")) {
                    $sql.="G";
                }
                $sql.="%\"";
                if ($item !=$filtreL[count($filtreL)-1]){
                    $sql.=" OR ";
                }
            }
            $sql.=")";
            return $sql;
        } else {
            return $filtre;
        }

    }


    public static function etudiant_concerne(): string
    {
        $entreprise=(new EntrepriseRepository())->getEntrepriseParMail(ConnexionUtilisateur::getUtilisateurConnecte()->getLogin());
        $idEntreprise=$entreprise->getSiret();
        return " EXISTS (SELECT idEtudiant FROM Formations F WHERE idEntreprise=$idEntreprise AND E.numEtudiant=F.idEtudiant)";
    }

    public static function etudiant_avec_formation(): string
    {
        $sql = " EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant)";
        return self::enFormation_etudiant($sql);
    }

    public static function etudiant_sans_formation(): string
    {
        $sql = " NOT EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant)";
        return self::enFormation_etudiant($sql);
    }

    public static function enFormation_etudiant(string $sql): string
    {
        if (isset($_REQUEST["etudiant_avec_formation"], $_REQUEST["etudiant_sans_formation"])) {
            return "";
        } else return $sql;
    }

    public static function etudiant_stage(): string
    {
        $sql = " EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant AND (typeOffre=\"Stage\" OR typeOffre=\"Stage/Alternance\"))";
        return self::typeOffre_etudiant($sql);
    }

    public static function etudiant_alternance(): string
    {
        $sql = " EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant AND (typeOffre=\"Alternance\" OR typeOffre=\"Stage/Alternance\"))";
        return self::typeOffre_etudiant($sql);
    }

    private static function typeOffre_etudiant(string $sql): string
    {
        if (isset($_REQUEST["etudiant_alternance"], $_REQUEST["etudiant_stage"])) {
            return "EXISTS (SELECT idEtudiant FROM Formations F WHERE E.numEtudiant=F.idEtudiant)";
        } else return $sql;
    }
}