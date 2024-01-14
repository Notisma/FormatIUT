<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Ville;

class VilleRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Villes";
    }

    protected function getNomsColonnes(): array
    {
        return array("idVille", "nomVille", "codePostal");
    }

    protected function getClePrimaire(): string
    {
        return "idVille";
    }

    /**
     * @param array $dataObjectTableau
     * @return AbstractDataObject permet de construire une ville depuis un tableau
     */
    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Ville(
            $dataObjectTableau['idVille'],
            $dataObjectTableau['nomVille'],
            $dataObjectTableau['codePostal']
        );
    }

    /**
     * @param string|null $nomVille
     * @return int|null permet de récupérer l'id d'une ville depuis son nom
     */
    public function getVilleParNom(?string $nomVille): ?int
    {
        $sql = "SELECT idVille FROM " . $this->getNomTable() . " WHERE nomVille=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $nomVille);
        $pdoStatement->execute($values);

        $result = $pdoStatement->fetch();
        if (!$result) return null;
        else return ($result)["idVille"];
    }

    /**
     * @param string|null $nomVille
     * @return Ville|null permet de récupérer une ville depuis son nom
     */
    public function getVilleParNom2(?string $nomVille): ?Ville
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE nomVille=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $nomVille);
        $pdoStatement->execute($values);

        $result = $pdoStatement->fetch();
        if (!$result) return null;
        else return $this->construireDepuisTableau($result);
    }


    /**
     * @param $siret
     * @return Ville permet de récupérer la ville d'une entreprise depuis son siret
     */
    public function getVilleParIdVilleEntr($siret): Ville
    {
        $sql = "Select v.idVille, nomVille, codePostal From Villes v JOIN Entreprises e ON v.idVille = e.idVille WHERE numSiret =:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $siret);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}
