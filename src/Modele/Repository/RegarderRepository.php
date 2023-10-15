<?php
namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Regarder;

class RegarderRepository extends AbstractRepository {
    public function getNomTable(): string
    {
        return "regarder";
    }

    public function getNomsColonnes(): array
    {
        return ["numEtudiant", "idOffre", "Etat"];
    }
    public function construireDepuisTableau(array $regarder): AbstractDataObject
    {
        return new Regarder($regarder['numEtudiant'], $regarder['idOffre'], $regarder['Etat']);
    }
    public function getClePrimaire(): string
    {
        return("(numEtudiant, idOffre)");
    }

    public function getEtatEtudiantOffre($numEtudiant, $idOffre){
        $sql = "SELECT * FROM regarder WHERE numEtudiant =:etuTag AND idOffre =:offreTag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("etuTag" => $numEtudiant, "offreTag"=>$idOffre);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["Etat"];

    }

    public function supprimerOffreDansRegarder($idOffre){
        $sql="DELETE FROM regarder WHERE idOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idOffre);
        $pdoStatement->execute($values);
    }

    public function supprimerOffreEtudiant($numEtudiant ,$idOffre){
        $sql="DELETE FROM regarder WHERE $numEtudiant=:TagEtu AND idOffre=:TagOffre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagEtu"=>$numEtudiant ,"TagOffre"=>$idOffre);
        $pdoStatement->execute($values);
    }

    public function validerOffreEtudiant($numEtudiant, $idOffre){
        $sql="UPDATE regarder SET Etat = 'Annulé' WHERE numEtudiant = :tagEtu AND idOffre <> :tagOffre;
        UPDATE regarder SET Etat = 'Annulé' WHERE numEtudiant <> :tagEtu AND idOffre = :tagOffre;
        UPDATE regarder SET Etat = 'Validée' WHERE numEtudiant = :tagEtu AND idOffre = :tagOffre;";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }
}