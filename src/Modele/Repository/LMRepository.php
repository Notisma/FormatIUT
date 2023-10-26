<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\LM;

class LMRepository extends AbstractRepository
{

    public function getNomTable(): string
    {
        return "LM";
    }

    public function getClePrimaire(): string
    {
        return("idLM");
    }

    public function getNomsColonnes(): array
    {
        return ["idLM", "contenuLM"];
    }

    public function construireDepuisTableau(array $DataObjectTableau): LM
    {
        return new LM($DataObjectTableau['idLM'], $DataObjectTableau['contenuLM']);
    }

    public function deposerLM($idLM, $contenuLM): void{
        $sql='INSERT INTO '.$this->getNomTable().' VALUES (idLM=:idLMTag , contenuLM=:contenuLMTag)';
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("idLMTag"=>$idLM, "contenuLMTag"=>$contenuLM);
        $pdoStatement->execute($values);
    }

}