<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\Repository\ConnexionBaseDeDonnee;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;

abstract class AbstractRepository
{
    protected abstract function getNomTable():string;

    protected abstract function getNomsColonnes():array;
    protected abstract function getClePrimaire():string;

    public abstract function construireDepuisTableau(array $DataObjectTableau):AbstractDataObject;

    public function getListeObjet():?array{
        $sql='SELECT * FROM '.$this->getNomTable();
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $item) {
            $listeObjet[]=$this->construireDepuisTableau($item);
        }
        return $listeObjet;
    }

    public function creerObjet(AbstractDataObject $objet):void{
        $sql = "INSERT INTO ".$this->getNomTable()." VALUES (";
        foreach ($this->getNomsColonnes() as $nomsColonne) {
            if ($nomsColonne!=$this->getNomsColonnes()[0]){
                $sql.=",";
            }
            $sql.=":".$nomsColonne."Tag";
            $values[$nomsColonne."Tag"]=$objet->formatTableau()[$nomsColonne];
        }
        $sql.=")";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
    }

    public function getObjectParClePrimaire($clePrimaire):?AbstractDataObject{
        $sql="SELECT * FROM ".$this->getNomTable()." WHERE ".$this->getClePrimaire()."=:Tag ";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$clePrimaire);
        $pdoStatement->execute($values);
        $objet=$pdoStatement->fetch();
        if (!$objet){
            return null;
        }
        return $this->construireDepuisTableau($objet);
    }

    public function supprimer($clePrimaire) :void{
        $sql="DELETE FROM ".$this->getNomTable()." WHERE ".$this->getClePrimaire()."=:Tag ";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$clePrimaire);
        $pdoStatement->execute($values);
    }


}