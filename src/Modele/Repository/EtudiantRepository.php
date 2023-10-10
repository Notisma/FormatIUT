<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class EtudiantRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Etudiants";
    }

    protected function getNomsColonnes(): array
    {
        return array();
    }

    protected function getClePrimaire(): string
    {
        return "numEtudiant";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Etudiant(
            $DataObjectTableau["numEtudiant"],
            $DataObjectTableau["loginEtudiant"]
        );
    }

    /**
     * @return void
     */
    public function EtudiantPostuler($numEtu,$numOffre){
        $sql="INSERT INTO regarder VALUES (:TagEtu,:TagOffre)";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "TagEtu"=>$numEtu,
            "TagOffre"=>$numOffre
        );
        $pdoStatement->execute($values);
    }

    public function EtudiantsParOffre($idOffre){
        $sql=" SELECT * FROM ".$this->getNomTable()." etu JOIN regarder re ON etu.numEtudiant=re.numEtudiant WHERE idOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "Tag"=>$idOffre
        );
        $pdoStatement->execute($values);
        $tab=array();
        foreach ($pdoStatement as $item) {
            $tab[]=$this->construireDepuisTableau($item);
        }
        return $tab;
    }

    public function nbPostulation($idOffre){
        $sql="SELECT COUNT(numEtudiant)as nb FROM regarder WHERE idOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idOffre);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["nb"];
    }

    public function aUneFormation($idEtudiant){
        $sql="SELECT * FROM Formation WHERE idEtudiant=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idEtudiant);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }
    public function aPostuler($numEtudiant,$idOffre){
        $sql="SELECT * FROM regarder WHERE numEtudiant=:TagEtu AND idOffre=:TagOffre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagEtu"=>$numEtudiant,"TagOffre"=>$idOffre);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }


}