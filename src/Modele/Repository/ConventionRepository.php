<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Convention;

class ConventionRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "Formations";
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

    /**
     * @return int|mixed le nombre de conventions
     * Retourne le nombre de conventions
     */
    public function getNbConvention()
    {
        $sql = "SELECT COUNT(idConvention) as nb FROM Formations";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute();
        $resultat = $pdoStatement->fetch();
        if ($resultat === false) {
            return 0;
        }
        return $resultat["nb"];
    }

    /**
     * @param $numEtu
     * @return bool true si l'étudiant a une convention, false sinon
     * Vérifie si l'étudiant a une convention
     */
    public function aUneConvention($numEtu): bool
    {
        $sql = "Select * FROM Formations WHERE idEtudiant=:tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        if (!$pdoStatement->fetch()) return false;
        else return true;
    }


    /**
     * @param $numEtu
     * @return Convention
     * Retourne la convention de l'étudiant depuis son numéro et le formulaire
     */
    public function trouverConventionDepuisForm($numEtu): Convention
    {
        $sql = "Select c.idConvention, conventionValidee, dateCreation, dateTransmission, retourSigne, assurance, objectifOffre, typeConvention
        FROM Formations f JOIN Convention c ON c.idConvention = f.idConvention WHERE idEtudiant = :tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }

    /**
     * @param $numEtu
     * @return Convention|null l'id de la convention
     * Retourne l'id de la convention de l'étudiant depuis son numéro étudiant
     */
    public function getConventionEtudiant($numEtu): ?Convention
    {
        $sql = "SELECT idConvention FROM Formations WHERE idEtudiant=:tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        $resultat = $pdoStatement->fetch();
        if ($resultat === false) {
            return null;
        }
        return $this->getObjectParClePrimaire($resultat["idConvention"]);
    }
}
