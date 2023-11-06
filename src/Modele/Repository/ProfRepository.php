<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class ProfRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Prof";
    }

    protected function getNomsColonnes(): array
    {
        return array("idProf","nomProf","prenomProf","mailUniversitaire");
    }

    protected function getClePrimaire(): string
    {
        return "idProf";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Prof(
            $DataObjectTableau["idProf"],
            $DataObjectTableau["nomProf"],
            $DataObjectTableau["prenomProf"],
            $DataObjectTableau["mailUniversitaire"]
        );
    }

    public function estProf(string $login) :bool{
        $sql="SELECT COUNT(*) FROM ".$this->getNomTable()." WHERE nomProf=:Tag";
        $pdoStetement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$login);
        $pdoStetement->execute($values);
        $count=$pdoStetement->fetch();
        if ($count>0) return true;
        else return false;
    }
}