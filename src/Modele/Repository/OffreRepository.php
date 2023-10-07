<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Offre;
use Cassandra\Bigint;

class OffreRepository extends AbstractRepository
{


    public function creerOffre(Offre $offre){
        $this->creerObjet($offre);
    }
    public function getNomsColonnes() : array{
        return ["idOffre","nomOffre","dateDebut","dateFin","sujet","detailProjet","gratification","dureeHeures","joursParSemaine","nbHeuresHebdo","idEntreprise","typeOffre"];
    }

    public function getNomTable():string{
        return "Offre";
    }

    public function getListeOffre():?array{
        return $this->getListeObjet();
    }

    public function getOffre(int $id):?AbstractDataObject{

        return $this->getObjectParClePrimaire($id);
    }

    public function getListeOffreParEntreprise($idEntreprise,$type): array
    {
        $sql="SELECT * FROM ". $this->getNomTable() ." WHERE idEntreprise=:Tag";
        if ($type=="Stage" || $type=="Alternance"){
            $sql.=" AND typeOffre=:TypeTag";
            $values["TypeTag"]=$type;
        }
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values["Tag"]= $idEntreprise;
        $pdoStatement->execute($values);
        $listeOffre=array();
        foreach ($pdoStatement as $offre){
            $listeOffre[]=$this->construireDepuisTableau($offre);
        }
        return $listeOffre;
    }
    public function getListeIdOffres():array{
        $sql="SELECT idOffre FROM Offre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeId=array();
        foreach ($pdoStatement as $item=>$value) {
            $listeId[]=$value["idOffre"];
        }
        return $listeId;
    }

    public function construireDepuisTableau(array $offre): Offre
    {
        $dateDebut= new \DateTime($offre['dateDebut']);
        $dateFin= new \DateTime($offre['dateFin']);
        //echo $idEntreprise;
        return new Offre($offre['idOffre'], $offre['nomOffre'], $dateDebut, $dateFin, $offre['sujet'], $offre['detailProjet'], $offre['gratification'], $offre['dureeHeures'], $offre['joursParSemaine'], $offre['nbHeuresHebdo'],$offre["idEntreprise"],$offre['typeOffre']);
    }

    protected function getClePrimaire(): string
    {
        return "idOffre";
    }
}