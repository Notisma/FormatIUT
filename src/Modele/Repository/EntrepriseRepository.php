<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\Entreprise;
use PDO;

// cette classe n'est pas encore faite, sauf deux fonctions utilisées dans Offre
class EntrepriseRepository
{
    // private parce qu'on a pas besoin de mieux pour l'instant, mais on pourra mettre public si besoin
    private static function getEntreprises(): array
    {
        //aucun field taggable donc pas besoin de prepare
        $query = "SELECT * FROM Entreprise;";
        $statement = ConnexionBaseDeDonnee::getPdo()->query($query);

        $entreprises = array();
        foreach ($statement as $entreprise)
            $entreprises[] = Entreprise::construireDepuisTableau($entreprise);

        return $entreprises;
    }

    public static function getEntrepriseFromSiret(int $siret): ?Entreprise
    {
        foreach (self::getEntreprises() as $entreprise)
            if ($entreprise->getSiret() === $siret)
                return $entreprise;
        return null;
    }
}