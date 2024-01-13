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
        return ["numEtudiant", "idFormation", "etat", "cv", "lettre"];
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Postuler($dataObjectTableau['numEtudiant'], $dataObjectTableau['idFormation'], $dataObjectTableau['etat'], $dataObjectTableau['cv'], $dataObjectTableau['lettre']);
    }

    public function getClePrimaire(): string
    {
        return ("(numEtudiant, idFormation)");
    }

    public function getEtatEtudiantOffre($numEtudiant, $idFormation)
    {
        $sql = "SELECT * FROM Postuler WHERE numEtudiant =:etuTag AND idFormation =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("etuTag" => $numEtudiant, "offreTag" => $idFormation);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["etat"];

    }

    public function supprimerOffreDansPostuler($idFormation): void
    {
        $sql = "DELETE FROM Postuler WHERE idFormation=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idFormation);
        $pdoStatement->execute($values);
    }

    public function supprimerOffreEtudiant($numEtudiant, $idFormation): void
    {
        $sql = "DELETE FROM Postuler WHERE $numEtudiant=:TagEtu AND idFormation=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idFormation);
        $pdoStatement->execute($values);
    }

    public function validerOffreEtudiant($numEtudiant, $idFormation): void
    {
        $this->annulerAutresOffre($numEtudiant, $idFormation);
        $this->annulerAutresEtudiant($numEtudiant, $idFormation);
        $this->validerOffre($numEtudiant, $idFormation);

    }

    public function annulerAutresOffre($numEtudiant, $idFormation): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET etat='Annulé' WHERE numEtudiant=:tagEtu AND idFormation!=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idFormation
        );
        $pdoStatement->execute($values);
    }

    public function annulerAutresEtudiant($numEtudiant, $idFormation): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET etat='Annulé' WHERE numEtudiant!=:tagEtu AND idFormation=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idFormation
        );
        $pdoStatement->execute($values);
    }

    public function validerOffre($numEtudiant, $idFormation): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET etat='Validée' WHERE numEtudiant=:tagEtu AND idFormation=:tagOffre ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tagEtu" => $numEtudiant,
            "tagOffre" => $idFormation
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

    public function recupererCV($numEtudiant, $idFormation)
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE numEtudiant =:etudiantTag AND idFormation =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "etudiantTag" => $numEtudiant,
            "offreTag" => $idFormation
        );
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["cv"];
    }

    public function getNbCandidatsPourOffre($idFormation)
    {
        $sql = "SELECT COUNT(*) FROM Postuler WHERE idFormation=:offreTag AND etat!='Annulé'";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "offreTag" => $idFormation
        );
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["COUNT(*)"];
    }

    public function recupererLettre($numEtudiant, $idFormation)
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE numEtudiant =:etudiantTag AND idFormation =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "etudiantTag" => $numEtudiant,
            "offreTag" => $idFormation
        );
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["lettre"];
    }
    public function mettreAChoisir($numEtudiant, $idFormation): void
    {
        $sql = "UPDATE Postuler SET etat='A Choisir' WHERE numEtudiant=:TagEtu AND idFormation=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idFormation);
        $pdoStatement->execute($values);
    }
}
