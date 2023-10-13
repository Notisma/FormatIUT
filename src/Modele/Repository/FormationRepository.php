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
        return array("idFormation","dateDebut","dateFin","idEtudiant","idTuteurPro","idEntreprise",'idConvention',"idTuteurUM","idOffre");
    }

    protected function getClePrimaire(): string
    {
        return "idFormation";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        $dateDebut= new \DateTime($DataObjectTableau['dateDebut']);
        $dateFin= new \DateTime($DataObjectTableau['dateFin']);

        return new Formation(
            $DataObjectTableau["idFormation"],
            $dateDebut,
            $dateFin,
            $DataObjectTableau["idEtudiant"],
            $DataObjectTableau["idTuteurPro"],
            $DataObjectTableau["idEntreprise"],
            $DataObjectTableau["idConvention"],
            $DataObjectTableau["idTuteurUM"],
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

    //(idFormation,dateDebut,dateFin,idEtudiant,idEntreprise,idOffre)

    public function estFormation(AbstractDataObject $offre) : ?AbstractDataObject{
        $sql="SELECT * FROM ".$this->getNomTable()." WHERE idOffre=:Tag ";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$offre->getIdOffre());
        $pdoStatement->execute($values);
        $formation=$pdoStatement->fetch();
        if (!$formation){
            return null;
        }
        return $this->construireDepuisTableau($formation);

    }

}