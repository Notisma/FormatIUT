<?php
namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Regarder;
use App\FormatIUT\Modele\DataObject\Residence;

class ResidenceRepository extends AbstractRepository{
    public function getNomTable(): string
    {
       return "Residence";
    }
    public function getClePrimaire(): string
    {
        return "idResidence";
    }
    public function getNomsColonnes(): array
    {
        return ["idResidence", "voie", "libCedex", "idVille"];
    }

    public function construireDepuisTableau(array $residence): AbstractDataObject
    {
        return new Residence($residence['idResidence'], $residence['voie'], $residence['libCedex'], $residence['idVille']);
    }

    public function getResidenceParEtu($numEtu) {
        $sql = "SELECT r.idResidence, voie, libCedex, idVille FROM Residence r JOIN Etudiants e ON e.idResidence = r.idResidence WHERE numEtudiant =:tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu"=>$numEtu);
        $pdoStatement->execute($values);
        if($pdoStatement->fetch() == false){
            return false;
        }
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}