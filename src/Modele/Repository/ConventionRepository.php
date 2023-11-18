<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Convention;

class ConventionRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "Convention";
    }

    public function getClePrimaire(): string
    {
        return "idConvention";
    }

    public function getNomsColonnes(): array
    {
        return array("idConvention", "conventionValidee", "dateCreation", "dateTransmission", "retourSigne", "assurance", "objectifOffre", "typeConvention");
    }

    public function construireDepuisTableau(array $convention): AbstractDataObject
    {
        $dateCreation = new \DateTime($convention['dateCreation']);
        $dateTransmission = new \DateTime($convention['dateTransmission']);

        $creationconv = new Convention($convention['idConvention'], $convention ['conventionValidee'], $dateCreation,
            $dateTransmission, $convention['retourSigne'], $convention['assurance'],
            $convention['objectifOffre'], $convention['typeConvention']);
        return $creationconv;
    }

    public function getNbConvention()
    {
        $sql = "SELECT COUNT(idConvention) as nb FROM Convention";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute();
        $resultat = $pdoStatement->fetch();
        if ($resultat === false) {
            return 0;
        }
        return $resultat["nb"];
    }

    public function aUneConvention($numEtu): bool
    {
        $sql = "Select * FROM Convention c JOIN Formation f ON f.idConvention = c.idConvention WHERE idEtudiant=:tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        if(!$pdoStatement->fetch()) return false;
        else return true;
    }


    public function trouverConventionDepuisForm($numEtu): Convention
    {
        $sql = "Select c.idConvention, conventionValidee, dateCreation, dateTransmission, retourSigne, assurance, objectifOffre, typeConvention
        FROM Formation f JOIN Convention c ON c.idConvention = f.idConvention WHERE idEtudiant = :tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}