<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Prof;

class ProfRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Profs";
    }

    protected function getNomsColonnes(): array
    {
        return array("idProf", "nomProf", "prenomProf", "mailUniversitaire", "img_id");
    }

    protected function getClePrimaire(): string
    {
        return "nomProf";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        $image = ((new ImageRepository()))->getImage($dataObjectTableau["img_id"]);
        return new Prof(
            $dataObjectTableau["idProf"],
            $dataObjectTableau["nomProf"],
            $dataObjectTableau["prenomProf"],
            $dataObjectTableau["mailUniversitaire"],
            $image["img_link"]
        );
    }

    public function estProf(string $login): bool
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE nomProf=:Tag";
        $pdoStetement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $login);
        $pdoStetement->execute($values);
        $count = $pdoStetement->fetch();
        if ($count > 0) return true;
        else return false;
    }
}
