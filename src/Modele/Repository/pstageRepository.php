<?php
namespace App\FormatIUT\Modele\Repository;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\pstage;

class pstageRepository extends AbstractRepository {
    public function getNomTable(): string
    {
        return "pstage";
    }
    public function getClePrimaire(): string
    {
        return "numeroEtudiant";
    }
    public function getNomsColonnes(): array
    {
        return array("numeroEtudiant", "nomEtudiant", "prenomEtudiant", "age", "annee", "stage");
    }
   public function construireDepuisTableau(array $DataObjectTableau): pstage
   {
       if($DataObjectTableau[5]==0){
           $boolean = false;
       }
       else{
           $boolean=true;
       }
      return new pstage($DataObjectTableau[0], $DataObjectTableau[1], $DataObjectTableau[2], $DataObjectTableau[3], $DataObjectTableau[4], $boolean);
   }
}