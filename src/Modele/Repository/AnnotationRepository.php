<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Annotation;

class AnnotationRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Annotations";
    }

    protected function getNomsColonnes(): array
    {
        return array("loginProf", "siretEntreprise", "messageAnnotation", "dateAnnotation", "noteAnnotation");
    }

    protected function getClePrimaire(): string
    {
        return "loginProf, siretEntreprise";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Annotation(
            $dataObjectTableau["loginProf"],
            $dataObjectTableau["siretEntreprise"],
            $dataObjectTableau["messageAnnotation"],
            $dataObjectTableau["dateAnnotation"],
            $dataObjectTableau["noteAnnotation"],
        );
    }

    /**
     * @param $idEntreprise
     * @return array
     * Permet d'avoir la liste des annotations d'une entreprise
     */
    public function annotationsParEntreprise($idEntreprise): array {
        $sql = "SELECT * FROM " . $this->getNomTable() .
            " WHERE siretEntreprise=:Tag;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }

    /**
     * @param $loginProf
     * @param $siretEntreprise
     * @return void
     * Permet de supprimer une annotation à partir de ses deux clés primaires
     */
    public function supprimerAnnotation($loginProf, $siretEntreprise): void {
        $sql = "DELETE FROM " . $this->getNomTable() . " WHERE loginProf=:loginTag AND siretEntreprise=:siretTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("loginTag" => $loginProf, "siretTag" => $siretEntreprise);
        $pdoStatement->execute($values);
    }

    public function addReplaceAnnotation(Annotation $annotation): void{
        $sql = "REPLACE INTO " . $this->getNomTable() . " VALUES(:loginTag, :siretTag, :messageTag, :dateTag, :noteTag);";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("loginTag" => $annotation->getLoginProf(),
            "siretTag" => $annotation->getSiretEntreprise(),
            "messageTag" => $annotation->getMessageAnnotation(),
            "dateTag" => $annotation->getDateAnnotation(),
            "noteTag" => $annotation->getNoteAnnotation());
        $pdoStatement->execute($values);
    }

    public function creerAnnotationDepuisForm(Annotation $annotation): void {
        $sql = "INSERT INTO " . $this->getNomTable() . " VALUES(:loginTag, :siretTag, :messageTag, :dateTag, :noteTag);";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("loginTag" => $annotation->getLoginProf(),
            "siretTag" => $annotation->getSiretEntreprise(),
            "messageTag" => $annotation->getMessageAnnotation(),
            "dateTag" => $annotation->getDateAnnotation(),
            "noteTag" => $annotation->getNoteAnnotation());
        $pdoStatement->execute($values);
    }

    /**
     * @param $siret
     * @param $loginAdmin
     * @return bool retourne true si l'admin a déposé une annotation sur l'entreprise
     */
    public function aDeposeAnnotation($siret, $loginAdmin) : bool {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE siretEntreprise=:siretTag AND loginProf=:loginTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("siretTag" => $siret, "loginTag" => $loginAdmin);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = $this->construireDepuisTableau($offre);
        }
        if (empty($listeOffres)) {
            return false;
        } else {
            return true;
        }
    }
}
