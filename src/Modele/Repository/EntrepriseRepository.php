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
        return ["numSiret","nomEntreprise","statutJuridique","effectif","codeNAF","tel","Adresse_Entreprise","idVille","img_id","mdpHache","email","emailAValider","nonce","estValide"];
    }

    public function construireDepuisTableau(array $entrepriseFormatTableau): Entreprise
    {
            return new Entreprise($entrepriseFormatTableau['numSiret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel'],
            $entrepriseFormatTableau['Adresse_Entreprise'],
            $entrepriseFormatTableau['idVille'],
            $entrepriseFormatTableau["img_id"],
        $entrepriseFormatTableau["mdpHache"],
        $entrepriseFormatTableau["email"],
        $entrepriseFormatTableau["emailAValider"],
        $entrepriseFormatTableau["nonce"],
            $entrepriseFormatTableau["estValide"]
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
    public function getEntrepriseParMail(string $mail){
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE  email=:Tag ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $mail);
        $pdoStatement->execute($values);
        $objet = $pdoStatement->fetch();
        if (!$objet) {
            return null;
        }
        return $this->construireDepuisTableau($objet);
    }

    public function entreprisesNonValide(){
        $sql="SELECT * FROM ".$this->getNomTable()." WHERE estValide=0";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $entreprise) {
            $listeEntreprises[]=$this->construireDepuisTableau($entreprise);
        }
        return $listeEntreprises;
    }

}