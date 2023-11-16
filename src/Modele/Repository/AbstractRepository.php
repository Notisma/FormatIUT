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

    /***
     * @return array|null
     * retourne une liste de l'ensemble des object d'une même classe
     * renvoie null si aucun objet n'est créer
     */
    public function getListeObjet():?array{
        $sql='SELECT * FROM '.$this->getNomTable();
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $item) {
            $listeObjet[]=$this->construireDepuisTableau($item);
        }
        return $listeObjet;
    }

    /***
     * @param AbstractDataObject $objet
     * @return void
     * créer un object dans la Base de Donnée avec les informations de l'objet donné en paramètre
     */

    public function creerObjet(AbstractDataObject $objet):void{
        $sql = "INSERT IGNORE INTO ".$this->getNomTable()." VALUES (";
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

    /***
     * @param $clePrimaire
     * @return AbstractDataObject|null
     * retourne un objet correspondant à la clé primaire donnée en paramètre
     * si l'objet n'existe pas, renvoie null
     */

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

    /***
     * @param $clePrimaire
     * @return void
     * supprime dans la Base de donnée l'objet donc la clé primaire est en paramètre
     */

    public function supprimer($clePrimaire) :void{
        $sql="DELETE FROM ".$this->getNomTable()." WHERE ".$this->getClePrimaire()."=:Tag ";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$clePrimaire);
        $pdoStatement->execute($values);
    }


}