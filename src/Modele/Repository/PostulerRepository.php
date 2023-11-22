<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Postuler;

class PostulerRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "Postuler";
    }

    public function getNomsColonnes(): array
    {
        return ["numEtudiant", "idOffre", "Etat", "cv", "lettre"];
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Postuler($dataObjectTableau['numEtudiant'], $dataObjectTableau['idOffre'], $dataObjectTableau['Etat'], $dataObjectTableau['cv'], $dataObjectTableau['lettre']);
    }

    public function getClePrimaire(): string
    {
        return ("(numEtudiant, idOffre)");
    }

    public function getEtatEtudiantOffre($numEtudiant, $idOffre)
    {
        $sql = "SELECT * FROM Postuler WHERE numEtudiant =:etuTag AND idOffre =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("etuTag" => $numEtudiant, "offreTag" => $idOffre);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["Etat"];

    }

    public function supprimerOffreDansPostuler($idOffre): void
    {
        $sql = "DELETE FROM Postuler WHERE idOffre=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idOffre);
        $pdoStatement->execute($values);
    }

    public function supprimerOffreEtudiant($numEtudiant, $idOffre): void
    {
        $sql = "DELETE FROM Postuler WHERE $numEtudiant=:TagEtu AND idOffre=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idOffre);
        $pdoStatement->execute($values);
    }

    public function validerOffreEtudiant($numEtudiant, $idOffre): void
    {
        $this->annulerAutresOffre($numEtudiant, $idOffre);
        $this->annulerAutresEtudiant($numEtudiant, $idOffre);
        $this->validerOffre($numEtudiant, $idOffre);

    }

    public function annulerAutresOffre($numEtudiant, $idOffre): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET Etat='Annulé' WHERE numEtudiant=:tagEtu AND idOffre!=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }

    public function annulerAutresEtudiant($numEtudiant, $idOffre): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET Etat='Annulé' WHERE numEtudiant!=:tagEtu AND idOffre=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }

    public function validerOffre($numEtudiant, $idOffre): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET Etat='Validée' WHERE numEtudiant=:tagEtu AND idOffre=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idOffre
        );
        $pdoStatement->execute($values);
    }

    public function getOffreValider($numEtudiant): ?Postuler
    {
        $sql = "SELECT * FROM Postuler WHERE etat='Validée' AND numEtudiant=:tagEtudiant";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtudiant" => $numEtudiant
        );
        $pdoStatement->execute($values);
        $fetch = $pdoStatement->fetch();
        if (empty($fetch)) {
            return null;
        } else {
            return $this->construireDepuisTableau($fetch);
        }
    }

    public function recupererCV($numEtudiant, $idOffre)
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE numEtudiant =:etudiantTag AND idOffre =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "etudiantTag" => $numEtudiant,
            "offreTag" => $idOffre
        );
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["cv"];
    }

    public function recupererLettre($numEtudiant, $idOffre)
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE numEtudiant =:etudiantTag AND idOffre =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "etudiantTag" => $numEtudiant,
            "offreTag" => $idOffre
        );
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["lettre"];
    }
}