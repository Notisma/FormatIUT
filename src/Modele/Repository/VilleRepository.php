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
        return array("idVille","nomVille","codePostal");
    }

    protected function getClePrimaire(): string
    {
        return "idVille";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Ville(
            $DataObjectTableau["idVille"],
            $DataObjectTableau['nomVille'],
            $DataObjectTableau['codePostal']
        );
    }
    public function getVilleParNom(string $nomVille):?string{
        $sql="SELECT idVille FROM ".$this->getNomTable()." WHERE nomVille=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$nomVille);
        $pdoStatement->execute($values);
        if (!$pdoStatement){
            return null;
        }
        return ($pdoStatement->fetch())["idVille"];
    }
}