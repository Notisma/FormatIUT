<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\Offre;

class OffreRepository
{
    public function creerOffre(Offre $offre){
        $sql="INSERT INTO ".$this->getNomTable()." values(";
        foreach ($this->getNomsColonnes() as $formatTableau) {
            if($formatTableau!=$this->getNomsColonnes()[0]){
                $sql.=",";
            }
            $sql.=":Tag".$formatTableau;
            $values["Tag".$formatTableau]=$offre->formatTableau()[$formatTableau];
        }
        $sql.=")";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
    }
    public function getNomsColonnes() : array{
        return ["idOffre","nomOffre","dateDebut","dateFin","sujet","detailProjet","gratification","dureeHeures","joursParSemaine","nbHeuresHebdo","idEntreprise"];
    }

    public function getNomTable():string{
        return "Offre";
    }

    public function getListeOffre():?array{
        $sql="SELECT * FROM ". $this->getNomTable();
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $offre){
            $listeOffre[]=Offre::construireDepuisFormulaire($offre);
        }
        return $listeOffre;
    }

    public function getOffre(int $id):?Offre{
        $sql="SELECT * FROM ". $this->getNomTable() ." WHERE idOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $array=array("Tag"=>$id);
        $pdoStatement->execute($array);
        $offre=$pdoStatement->fetch();
        if (!$offre){
            return null;
        }
        return Offre::construireDepuisTableau($offre);
    }

    public function getListeOffreParEntreprise($idEntreprise,$type): array
    {
        $sql="SELECT * FROM ". $this->getNomTable() ." WHERE idEntreprise=:Tag";
        if ($type=="Stage" || $type=="Alternance"){
            $sql.=" AND typeFormation=:TypeTag";
        }
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "Tag"=>$idEntreprise,
            "TypeTag"=>$type
        );
        $pdoStatement->execute($values);
        $listeOffre=array();
        foreach ($pdoStatement as $offre){
            $listeOffre[]=Offre::construireDepuisTableau($offre);
        }
        return $listeOffre;
    }
}