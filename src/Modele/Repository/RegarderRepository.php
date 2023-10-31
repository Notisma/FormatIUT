<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Regarder;

class RegarderRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "regarder";
    }

    public function getNomsColonnes(): array
    {
        return ["numEtudiant", "idOffre", "Etat", "cv", "lettre"];
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Regarder($DataObjectTableau['numEtudiant'], $DataObjectTableau['idOffre'], $DataObjectTableau['Etat'], $DataObjectTableau['cv'], $DataObjectTableau['lettre']);
    }

    public function getClePrimaire(): string
    {
        return ("(numEtudiant, idOffre)");
    }

    public function getEtatEtudiantOffre($numEtudiant, $idOffre)
    {
        $sql = "SELECT * FROM regarder WHERE numEtudiant =:etuTag AND idOffre =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("etuTag" => $numEtudiant, "offreTag" => $idOffre);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["Etat"];

    }

    public function supprimerOffreDansRegarder($idOffre)
    {
        $sql = "DELETE FROM regarder WHERE idOffre=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idOffre);
        $pdoStatement->execute($values);
    }

    public function supprimerOffreEtudiant($numEtudiant, $idOffre)
    {
        $sql = "DELETE FROM regarder WHERE $numEtudiant=:TagEtu AND idOffre=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idOffre);
        $pdoStatement->execute($values);
    }

    public function validerOffreEtudiant($numEtudiant, $idOffre)
    {
        $this->annulerAutresOffre($numEtudiant, $idOffre);
        $this->annulerAutresEtudiant($numEtudiant, $idOffre);
        $this->validerOffre($numEtudiant, $idOffre);

    }

    public function annulerAutresOffre($numEtudiant, $idOffre)
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET Etat='Annulé' WHERE numEtudiant=:tagEtu AND idOffre!=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }

    public function annulerAutresEtudiant($numEtudiant, $idOffre)
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET Etat='Annulé' WHERE numEtudiant!=:tagEtu AND idOffre=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }

    public function validerOffre($numEtudiant, $idOffre)
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET Etat='Validée' WHERE numEtudiant=:tagEtu AND idOffre=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }

    public function getOffreValider($numEtudiant): ?Regarder
    {
        $sql = "SELECT * FROM regarder WHERE etat='Validée' AND numEtudiant=:tagEtudiant";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtudiant" => $numEtudiant
        );
        $pdoStatement->execute($values);
        $fetch = $pdoStatement->fetch();
        if (empty($fetch)) {
            return null;
        }
        else {
            return $this->construireDepuisTableau($fetch);
        }
    }

}