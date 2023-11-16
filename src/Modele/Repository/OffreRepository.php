<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Offre;
use Cassandra\Bigint;

class OffreRepository extends AbstractRepository
{


    public function getNomsColonnes() : array{
        return ["idOffre","nomOffre","dateDebut","dateFin","sujet","detailProjet","gratification","dureeHeures","joursParSemaine","nbHeuresHebdo","idEntreprise","typeOffre", "anneeMin", "anneeMax", "estValide"];
    }

    public function getNomTable():string{
        return "Offre";
    }

    public function getListeOffresDispoParType($type): array
    {
        $values = array();
        $sql="SELECT * FROM " . $this->getNomTable()." o ";
        $sql.= " WHERE NOT EXISTS (SELECT idOffre FROM Formation f WHERE f.idOffre=o.idOffre)";
        if ($type=="Stage" || $type=="Alternance"){
            $sql.=" AND typeOffre=:TypeTag";
            $values["TypeTag"]=$type;
        }
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $listeOffre=array();
        foreach ($pdoStatement as $offre){
            $listeOffre[]=$this->construireDepuisTableau($offre);
        }
        return $listeOffre;
    }

    /**
     * @param $idEntreprise
     * @return array
     * retourne la liste des offres disponibles pour une entreprise
     */
    public function OffresParEntrepriseDispo($idEntreprise){
        $sql="SELECT * 
                FROM ".$this->getNomTable()." o
                WHERE idEntreprise=:Tag 
                AND NOT EXISTS (
                SELECT idOffre FROM Formation f
                WHERE f.idOffre=o.idOffre)";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idEntreprise);
        $pdoStatement->execute($values);
        $listeOffre=array();
        foreach ($pdoStatement as $item) {
            $listeOffre[]=$this->construireDepuisTableau($item);
        }
        return $listeOffre;
    }

    /**
     * @param $idEntreprise
     * @param $type
     * @param $etat
     * @return array
     * retourne la liste des offres pour une entreprise avec différents filtres
     */
    public function getListeOffreParEntreprise($idEntreprise,$type,$etat): array
    {
        $sql="SELECT * FROM ". $this->getNomTable() ." o WHERE idEntreprise=:Tag";
        if ($type=="Stage" || $type=="Alternance"){
            $sql.=" AND typeOffre=:TypeTag";
            $values["TypeTag"]=$type;
        }
        if ($etat=="Dispo") {
            $sql .= " AND NOT EXISTS (SELECT idOffre FROM Formation f WHERE o.idOffre=f.idOffre)";
        }else if ($etat=="Assigné"){
            $sql.= " AND EXISTS (SELECT idOffre FROM Formation f WHERE f.idOffre=o.idOffre)";
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

    /**
     * @param $numEtudiant
     * @return array
     * retourne la liste des offres auquel à déjà postuler un étudiant
     */

    public function listOffreEtu($numEtudiant){
        $sql ="Select * FROM Offre o JOIN regarder r ON o.idOffre = r.idOffre WHERE numEtudiant= :TagEtu";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array(
            "TagEtu"=>$numEtudiant
        );
        $pdoStatement->execute($values);
        $listOffre=array();
        foreach ($pdoStatement as $offre){
            $listOffre[]=$this->construireDepuisTableau($offre);
        }
        return $listOffre;

    }

    /**
     * @return array
     * retourne la liste des id des offres
     */

    public function getListeIdOffres():array{
        $sql="SELECT idOffre FROM Offre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeId=array();
        foreach ($pdoStatement as $item=>$value) {
            $listeId[]=$value["idOffre"];
        }
        return $listeId;
    }

    /**
     * @param string $type
     * @return array
     * retourne la liste des ids pour un type donné
     */
    public function ListeIdTypeOffre(string $type):array{
        $sql="SELECT idOffre FROM Offre WHERE typeOffre=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$type);
        $pdoStatement->execute($values);
        $listeID=array();
        foreach ($pdoStatement as $item=>$value) {
            $listeID[]=$value["idOffre"];
        }
        return $listeID;
    }

    /**
     * @param $idEntreprise
     * @return array
     * retourne la liste des id des offres pour une entreprise
     */

    public function ListeIdOffreEntreprise($idEntreprise):array{
        $sql="SELECT idOffre FROM Offre WHERE idEntreprise=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$idEntreprise);
        $pdoStatement->execute($values);
        $listeID=array();
        foreach ($pdoStatement as $item=>$value) {
            $listeID[]=$value["idOffre"];
        }
        return $listeID;
    }

    public function construireDepuisTableau(array $offre): Offre
    {
        $dateDebut= new \DateTime($offre['dateDebut']);
        $dateFin= new \DateTime($offre['dateFin']);
        //echo $idEntreprise;

        $valide=0;
        if (isset($offre["estValide"]) && $offre["estValide"]) $valide=1;
        return new Offre(
            $offre['idOffre'],
            $offre['nomOffre'],
            $dateDebut,
            $dateFin,
            $offre['sujet'],
            $offre['detailProjet'],
            $offre['gratification'],
            $offre['dureeHeures'],
            $offre['joursParSemaine'],
            $offre['nbHeuresHebdo'],
            $offre["idEntreprise"],
            $offre['typeOffre'],
            $offre['anneeMin'],
            $offre['anneeMax'],
            $valide
        );
    }

    protected function getClePrimaire(): string
    {
        return "idOffre";
    }

    /**
     * @param $numEtudiant
     * @param $idOffre
     * @return void
     * mettre un étudiant en état de choix
     */
    public function mettreAChoisir($numEtudiant,$idOffre){
        $sql="UPDATE regarder SET Etat='A Choisir' WHERE numEtudiant=:TagEtu AND idOffre=:TagOffre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("TagEtu"=>$numEtudiant,"TagOffre"=>$idOffre);
        $pdoStatement->execute($values);
    }

    public function offresNonValides()
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE estValide=0";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $offre) {
            $listeOffres[]=$this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }


    public function offresPourEtudiant($numEtudiant)
    {
        //retourne l'offre à laquelle l'étudiant est assigné. Si il n'est assigné à aucune offre, retourne la liste des offres auxquelles il a postulé
        $sql = "SELECT * FROM " . $this->getNomTable() . " o JOIN regarder r ON o.idOffre=r.idOffre WHERE numEtudiant=:Tag ORDER BY Etat DESC";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $numEtudiant);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[]=$this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }

    public function offresPourEntreprise($idEntreprise)
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE idEntreprise=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[]=$this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }






}