<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class ProfRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Profs";
    }

    protected function getNomsColonnes(): array
    {
        return array("idProf","nomProf","prenomProf","mailUniversitaire","img_id");
    }

    protected function getClePrimaire(): string
    {
        return "nomProf";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        $image=((new ImageRepository()))->getImage($DataObjectTableau["img_id"]);
        return new Prof(
            $DataObjectTableau["idProf"],
            $DataObjectTableau["nomProf"],
            $DataObjectTableau["prenomProf"],
            $DataObjectTableau["mailUniversitaire"],
            $image["img_blob"]
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