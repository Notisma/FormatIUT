<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\AbstractRepository;

class   EtudiantRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Etudiants";
    }

    protected function getNomsColonnes(): array
    {
        return array("numEtudiant","prenomEtudiant","nomEtudiant","loginEtudiant","mdpEtudiant","sexeEtu","mailUniversitaire","mailPerso","telephone","groupe","parcours","validationPedagogique","codeEtape","idResidence","img_id");
    }

    protected function getClePrimaire(): string
    {
        return "numEtudiant";
    }

    public function construireDepuisTableau(array $DataObjectTableau): AbstractDataObject
    {
        $image=((new ImageRepository()))->getImage($DataObjectTableau["img_id"]);
        return new Etudiant(
            $DataObjectTableau["numEtudiant"],
            $DataObjectTableau["prenomEtudiant"],
            $DataObjectTableau["nomEtudiant"],
            $DataObjectTableau["loginEtudiant"],
            $DataObjectTableau["sexeEtu"],
            $DataObjectTableau["mailUniversitaire"],
            $DataObjectTableau["mailPerso"],
            $DataObjectTableau["telephone"],
            $DataObjectTableau["groupe"],
            $DataObjectTableau["parcours"],
            $DataObjectTableau["validationPedagogique"],
            $DataObjectTableau["codeEtape"],
            $DataObjectTableau["idResidence"],
            $image["img_blob"]

        );
    }

    /**
     * @return void
     * rajoute dans la BD un étudiant qui postule à une offre
     */
    public function EtudiantPostuler( $numEtu, $numOffre){
        $sql="INSERT INTO regarder VALUES (:TagEtu,:TagOffre,'En Attente')";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "TagEtu"=>$numEtu,
            "TagOffre"=>$numOffre
        );
        $pdoStatement->execute($values);
    }

    /**
     * @param $numEtu
     * @param $idOffre
     * @return mixed
     * permet de savoir si un étudiant à postuler à cet Offre mais n'a pas changé d'état depuis
     */

    public function EtudiantAPostuler($numEtu,$idOffre){
        $sql="SELECT * FROM regarder WHERE numEtudiant=:TagEtu AND idOffre=:TagOffre AND Etat='En Attente'";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagEtu"=>$numEtu,"TagOffre"=>$idOffre);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }


    /**
     * @param $idOffre
     * @return mixed
     * retourne le nombre de postulation faites au total pour cet offre
     */

    public function nbPostulation($idOffre){
        $sql="SELECT COUNT(numEtudiant)as nb FROM regarder WHERE idOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idOffre);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["nb"];
    }

    /**
     * @param $idEtudiant
     * @return mixed
     * retourne si l'étudiant à déjà une formation
     */

    public function aUneFormation($idEtudiant){
        $sql="SELECT * FROM Formation WHERE idEtudiant=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idEtudiant);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }

    /**
     * @param $numEtudiant
     * @param $idOffre
     * @return mixed
     * retourne si l'étudiant à déjà postuler à cette offre
     */
    public function aPostuler($numEtudiant,$idOffre){
        $sql="SELECT * FROM regarder WHERE numEtudiant=:TagEtu AND idOffre=:TagOffre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagEtu"=>$numEtudiant,"TagOffre"=>$idOffre);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }

    /**
     * @param $numEtudiant
     * @param $idImage
     * @return void
     * permet à un étudiant d'update son image de profil
     */

    public function updateImage($numEtudiant,$idImage){
        $sql="UPDATE ".$this->getNomTable()." SET img_id=:TagImage WHERE ".$this->getClePrimaire()."=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagImage"=>$idImage,"Tag"=>$numEtudiant);
        $pdoStatement->execute($values);
    }

    /**
     * @param $idOffre
     * @return array
     * retourne la liste des étudiant qui sont actuellement dans la table regarder de cette offre
     */

    public function EtudiantsEnAttente($idOffre){
        $sql="SELECT numEtudiant FROM regarder r WHERE idOffre=:Tag AND NOT EXISTS(SELECT * FROM Formation f WHERE r.numEtudiant=f.idEtudiant)";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idOffre);
        $pdoStatement->execute($values);
        $listeEtu=array();
        foreach ($pdoStatement as $item) {
            $listeEtu[]=$this->getObjectParClePrimaire($item["numEtudiant"]);
        }
        return $listeEtu;
    }

    /**
     * @param $numEtudiant
     * @param $etat
     * @return mixed
     * retourne le nombre de fois où l'étudiant est dans un certain état
     */

    public function nbEnEtat($numEtudiant,$etat){
        $sql="SELECT COUNT(idOffre) as nb FROM regarder WHERE numEtudiant=:Tag AND Etat=:TagEtat";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$numEtudiant,"TagEtat"=>$etat);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()["nb"];
    }

    public function estEtudiant(string $login) : bool{
        $sql="SELECT COUNT(*) FROM ".$this->getNomTable()." WHERE loginEtudiant=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$login);
        $pdoStatement->execute($values);
        $count=$pdoStatement->fetch();
        if ($count[0]==1) return true;
        return false;
    }

    public function premiereConnexion(array $etudiant){
        $sql="INSERT INTO ".$this->getNomTable()." (numEtudiant,prenomEtudiant,nomEtudiant,loginEtudiant) VALUES (:numTag,:prenomTag,:nomTag,:loginTag)";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "numTag"=>$etudiant["numEtudiant"],
            "prenomTag"=>$etudiant["prenomEtudiant"],
            "nomTag"=>$etudiant["nomEtudiant"],
            "loginTag"=>$etudiant["loginEtudiant"],
        );
        $pdoStatement->execute($values);
    }

    public function getNumEtudiantParLogin(string $login):int{
        $sql="SELECT numEtudiant FROM ".$this->getNomTable(). " WHERE loginEtudiant=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$login);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch()[0];
    }

}