<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Entreprise;
use PDO;

// cette classe n'est pas encore faite, sauf deux fonctions utilisées dans Offre
class EntrepriseRepository extends AbstractRepository
{


    protected function getNomTable(): string
    {
        return "Entreprise";
    }

    protected function getNomsColonnes(): array
    {
        return ["numSiret","nomEntreprise","statutJuridique","effectif","codeNAF","tel","Adresse_Entreprise","idVille","img_id"];
    }

    public function construireDepuisTableau(array $entrepriseFormatTableau): Entreprise
    {
        $image=((new ImageRepository()))->getObjectParClePrimaire($entrepriseFormatTableau["img_id"]);
        return new Entreprise($entrepriseFormatTableau['numSiret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel'],
            $entrepriseFormatTableau['Adresse_Entreprise'],
            $entrepriseFormatTableau['idVille'],
            $image["img_blob"]
        );
    }

    protected function getClePrimaire(): string
    {
       return  "numSiret";

    }

    /***
     * @param $Siret
     * @param $idImage
     * @return void
     * remplace l'image de l'entreprise avec une nouvelle donc l'id est donnée en paramètre
     */

    public function updateImage($Siret,$idImage){
        $sql="UPDATE ".$this->getNomTable()." SET img_id=:TagImage WHERE ".$this->getClePrimaire()."=:TagSiret";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagImage"=>$idImage,"TagSiret"=>$Siret);
        $pdoStatement->execute($values);
    }

}