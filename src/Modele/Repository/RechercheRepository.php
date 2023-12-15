<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\Repository\AbstractRepository;

abstract class RechercheRepository extends AbstractRepository
{
    protected abstract function getColonnesRecherche():array;

    public function recherche(array $motsclefs)
    {
        foreach ($motsclefs as $mot) {
            $mot=strtolower($mot);
            $sql="SELECT * FROM ".$this->getNomTable()." WHERE ";
            foreach ($this->getColonnesRecherche() as $colonne) {
                if ($colonne!=$this->getColonnesRecherche()[0]){
                    $sql.=" OR ";
                }
                $sql.=" LOWER($colonne) LIKE :tag$colonne";
                $values["tag".$colonne]= "%$mot%";
            }
        }
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        foreach ($pdoStatement as $item) {
            $liste[]=$this->construireDepuisTableau($item);
        }
        return $liste;
    }
}