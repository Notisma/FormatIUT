<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class EtudiantRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "etudiants";
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
        $sql=" SELECT * FROM etudiants etu JOIN regarder re ON etu.numEtudiant=re.numEtudiant WHERE idOffre=:Tag";
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
}