<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class VilleRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Ville";
    }

    protected function getNomsColonnes(): array
    {
        return array("idVille","nomVille","paysVille");
    }

    protected function getClePrimaire(): string
    {
        return "idVille";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Ville(
            $DataObjectTableau['idVille'],
            $DataObjectTableau['nomVille'],
            $DataObjectTableau['paysVille']
        );
    }

    public function getVilleParIdResidence($idResidence) : Ville{
        $sql = "SELECT v.idVille, nomVille, paysVille FROM Ville v JOIN Residence r ON r.idVille = v.idVille WHERE idResidence =:tagResidence";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagResidence" => $idResidence);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());

    }
}