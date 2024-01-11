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

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Ville(
            $dataObjectTableau['idVille'],
            $dataObjectTableau['nomVille'],
            $dataObjectTableau['codePostal']
        );
    }

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

    public function getVilleParIdResidence($idResidence): Ville
    {
        $sql = "SELECT v.idVille, nomVille,codePostal FROM Ville v JOIN Residence r ON r.idVille = v.idVille WHERE idResidence =:tagResidence";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagResidence" => $idResidence);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());

    }

    public function getVilleParIdVilleEntr($siret): Ville
    {
        $sql = "Select v.idVille, nomVille, codePostal From Villes v JOIN Entreprises e ON v.idVille = e.idVille WHERE numSiret =:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $siret);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}
