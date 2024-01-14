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

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return mixed permet de savoir si un étudiant a postulé à une offre
     */
    public function getEtatEtudiantOffre($numEtudiant, $idFormation)
    {
        $sql = "SELECT * FROM Postuler WHERE numEtudiant =:etuTag AND idFormation =:offreTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("etuTag" => $numEtudiant, "offreTag" => $idFormation);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["etat"];

    }


    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return void permet de supprimer une offre d'un étudiant
     */
    public function supprimerOffreEtudiant($numEtudiant, $idFormation): void
    {
        $sql = "DELETE FROM Postuler WHERE $numEtudiant=:TagEtu AND idFormation=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idFormation);
        $pdoStatement->execute($values);
    }

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return void permet de valider une offre d'un étudiant
     */
    public function validerOffreEtudiant($numEtudiant, $idFormation): void
    {
        $this->annulerAutresOffre($numEtudiant, $idFormation);
        $this->annulerAutresEtudiant($numEtudiant, $idFormation);
        $this->validerOffre($numEtudiant, $idFormation);

    }

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return void permet d'annuler une offre d'un étudiant
     */
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

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return void permet d'annuler les autres offres d'un étudiant
     */
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

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return void permet de valider une offre d'un étudiant
     */
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

    /**
     * @param $numEtudiant
     * @return Postuler|null permet de récupérer les offres d'un étudiant
     */
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

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return mixed permet de récupérer le cv d'un étudiant
     */
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

    /**
     * @param $idFormation
     * @return mixed permet de récupérer le nombre de candidats pour une offre
     */
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

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return mixed permet de récupérer la lettre d'un étudiant
     */
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

}
