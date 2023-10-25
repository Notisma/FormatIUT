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

    public function construireDepuisTableau(array $cv): CV
    {
        return new CV($cv['idCV'], $cv['contenuCV']);
    }

    public function deposerCV($idCV, $contenuCV){
        $sql='INSERT INTO '.$this->getNomTable().' VALUES idCV=:idCVTag , contenuCV=:contenuCVTag';
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("idCVTag"=>$idCV, "contenuCVTag"=>$contenuCV);
        $pdoStatement->execute($values);
    }
}