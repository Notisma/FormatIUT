<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class FormationRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Formation";
    }

    protected function getNomsColonnes(): array
    {
        return array("idFormation","dateDebut","dateFin","idEtudiant","idEntreprise","idOffre");
    }

    protected function getClePrimaire(): string
    {
        return "idFormation";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Formation(
            $DataObjectTableau["idFormation"],
            $DataObjectTableau["dateDebut"],
            $DataObjectTableau["dateFin"],
            $DataObjectTableau["idEtudiant"],
            $DataObjectTableau["idEntreprise"],
            $DataObjectTableau["idOffre"]
        );
    }
    public function ListeIdTypeFormation():array{
        $sql="SELECT idOffre FROM Offre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeID=array();
        foreach ($pdoStatement as $item=>$value) {
            $listeID[]=$value["idOffre"];
        }
        return $listeID;
    }

    public function assigner($formation){
        $objet=$this->construireDepuisTableau($formation);
        $sql = "INSERT INTO ".$this->getNomTable()."(idFormation,dateDebut,dateFin,idEtudiant,idEntreprise,idOffre) VALUES (";
        foreach ($this->getNomsColonnes() as $nomsColonne) {
            if ($nomsColonne!=$this->getNomsColonnes()[0]){
                $sql.=",";
            }
            $sql.=":".$nomsColonne."Tag";
            $values[$nomsColonne."Tag"]=$objet->formatTableau()[$nomsColonne];
        }
        $sql.=")";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
    }

}