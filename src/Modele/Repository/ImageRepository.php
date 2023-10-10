<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class ImageRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Image";
    }

    protected function getNomsColonnes(): array
    {
        return ["img_id","img_nom","img_taille","img_type","img_blob"];
    }

    protected function getClePrimaire(): string
    {
        return "img_id";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        return new Ville("","","");
    }

    public function getImage($idImg){
        $sql="SELECT * FROM Image WHERE img_id=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idImg);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();

    }


}