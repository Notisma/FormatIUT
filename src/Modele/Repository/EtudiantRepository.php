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
        return array("numEtudiant","prenomEtudiant","nomEtudiant","loginEtudiant","mdpEtudiant","sexeEtu","mailUniversitaire","mailPerso","telephone","groupe","parcours","validationPedagogique","codeEtape","idResidence","img_id");
    }

    protected function getClePrimaire(): string
    {
        return "numEtudiant";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        $image=((new ImageRepository()))->getImage($DataObjectTableau["img_id"]);
        return new Etudiant(
            $DataObjectTableau["numEtudiant"],
            $DataObjectTableau["prenomEtudiant"],
            $DataObjectTableau["nomEtudiant"],
            $DataObjectTableau["loginEtudiant"],
            $DataObjectTableau["mdpEtudiant"],
            $DataObjectTableau["sexeEtu"],
            $DataObjectTableau["mailUniversitaire"],
            $DataObjectTableau["mailPerso"],
            $DataObjectTableau["telephone"],
            $DataObjectTableau["groupe"],
            $DataObjectTableau["parcours"],
            $DataObjectTableau["validationPedagogique"],
            $DataObjectTableau["codeEtape"],
            $DataObjectTableau["idResidence"],
            $image["img_blob"]

        );
    }

    /**
     * @return void
     */
    public function EtudiantPostuler($numEtu,$numOffre){
        $sql="INSERT INTO regarder VALUES (:TagEtu,:TagOffre,'En Attente')";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "TagEtu"=>$numEtu,
            "TagOffre"=>$numOffre
        );
        $pdoStatement->execute($values);
    }

    public function EtudiantAPostuler($numEtu,$idOffre){
        $sql="SELECT * FROM regarder WHERE numEtudiant=:TagEtu AND idOffre=:TagOffre AND Etat='En Attente'";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagEtu"=>$numEtu,"TagOffre"=>$idOffre);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
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

    public function updateImage($numEtudiant,$idImage){
        $sql="UPDATE ".$this->getNomTable()." SET img_id=:TagImage WHERE ".$this->getClePrimaire()."=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagImage"=>$idImage,"Tag"=>$numEtudiant);
        $pdoStatement->execute($values);
    }

    public function EtudiantsEnAttente($idOffre){
        $sql="SELECT numEtudiant FROM regarder WHERE idOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idOffre);
        $pdoStatement->execute($values);
        $listeEtu=array();
        foreach ($pdoStatement as $item) {
            $listeEtu[]=$this->getObjectParClePrimaire($item["numEtudiant"]);
        }
        return $listeEtu;
    }

    public function nbEnEtat($numEtudiant,$etat){
        $sql="SELECT COUNT(idOffre) as nb FROM regarder WHERE numEtudiant=:Tag AND Etat=:TagEtat";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$numEtudiant,"TagEtat"=>$etat);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["nb"];
    }

}