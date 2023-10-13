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
}