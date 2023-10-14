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

    /**
     * @param array $values
     * @return void
     * créer une image dans la base de donnée
     */
    public function insert(array $values){
        $req = "INSERT INTO Image VALUES (" .
            "'" . $values["img_id"] . "', " .
            "'" . $values["img_nom"] . "', " .
            "'" . $values["img_taille"] . "', " .
            "'" . $values["img_type"] . "', " .
            "'" . addslashes ($values["img_blob"]) . "') ";
        $pdpoStatement=ConnexionBaseDeDonnee::getPdo()->query($req);

    }

    /**
     * @return array
     * retourne la liste des id des différentes images
     */
    public function listeID(){
        $sql="SELECT img_id FROM Image";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeID=array();
        foreach ($pdoStatement as $item=>$value) {
            $listeID[]=$value["img_id"];
        }
        return $listeID;
    }

    /**
     * @param $Siret
     * @return mixed
     * retourne l'image de photo de profil pour une entreprise
     */

    public function imageParEntreprise($Siret){
        $sql="SELECT img_id FROM Entreprise WHERE numSiret=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$Siret);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }

    /**
     * @param $numEtudiant
     * @return mixed
     * retourne l'image de photo de profil pour un étudiant
     */

    public function imageParEtudiant($numEtudiant){
        $sql="SELECT img_id FROM Etudiants WHERE numEtudiant=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$numEtudiant);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }
}