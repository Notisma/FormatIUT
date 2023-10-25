<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\CV;

class CVRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "CV";
    }

    public function getClePrimaire(): string
    {
        return("idCV");
    }

    public function getNomsColonnes(): array
    {
        return ["idCV", "contenuCV"];
    }

    public function construireDepuisTableau(array $DataObjectTableau): CV
    {
        return new CV($DataObjectTableau['idCV'], $DataObjectTableau['contenuCV']);
    }

    public function deposerCV($idCV, $contenuCV): void{
        $sql='INSERT INTO '.$this->getNomTable().' VALUES (idCV=:idCVTag , contenuCV=:contenuCVTag)';
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("idCVTag"=>$idCV, "contenuCVTag"=>$contenuCV);
        $pdoStatement->execute($values);
    }
}