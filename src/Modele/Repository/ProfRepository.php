<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Prof;

class ProfRepository extends RechercheRepository
{

    protected function getNomTable(): string
    {
        return "Profs";
    }

    protected function getNomsColonnes(): array
    {
        return array("loginProf", "nomProf", "prenomProf", "mailUniversitaire", "estAdmin", "img_id");
    }

    protected function getColonnesRecherche(): array
    {
        return array("loginProf", "nomProf", "prenomProf");
    }

    protected function getClePrimaire(): string
    {
        return "loginProf";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        $estAdmin = 0;
        if ($dataObjectTableau["estAdmin"]) {
            $estAdmin = 1;
        }

        return new Prof(
            $dataObjectTableau["loginProf"],
            $dataObjectTableau["nomProf"],
            $dataObjectTableau["prenomProf"],
            $dataObjectTableau["mailUniversitaire"],
            $estAdmin,
            $dataObjectTableau["img_id"]
        );
    }

    public function estProf(string $login): bool
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE loginProf=:Tag";
        $pdoStetement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $login);
        $pdoStetement->execute($values);
        $count = $pdoStetement->fetch();
        if ($count[0] > 0) return true;
        else return false;
    }

    public function getParNom(string $nomProf): ?Prof
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE nomProf=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $nomProf);
        $pdoStatement->execute($values);
        $prof = $pdoStatement->fetch();
        if (!$prof) {
            return null;
        } else {
            return $prof;
        }
    }

    /**
     * @return Prof[]
     */
    public function getAdmins(): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE estAdmin=1";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $arr = array();
        foreach ($pdoStatement as $tuple) $arr[] = $this->construireDepuisTableau($tuple);
        return $arr;
    }

    public function getEtudiantsTutores(string $login): array
    {
        $sql = "SELECT idEtudiant FROM Formations WHERE loginTuteurUM =:loginTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("loginTag" => $login);
        $pdoStatement->execute($values);
        $arr = array();
        foreach ($pdoStatement as $var){
            $etu = (new EtudiantRepository())->getObjectParClePrimaire($var[0]);
            $arr[] = $etu;
        }
        return $arr;
    }

    public function mettreAJourInfos(string $nom, string $prenom, string $login): void
    {
        $sql = "UPDATE Profs SET nomProf = :nomTag, prenomProf = :prenomTag WHERE loginProf = :loginTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("nomTag" => $nom, "prenomTag" => $prenom, "loginTag" => $login);
        $pdoStatement->execute($values);
    }

    public function getParLogin(string $login):Prof
    {
        $sql="SELECT * FROM ".$this->getNomTable()." WHERE loginProf=:Tag";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values=array("Tag"=>$login);
        $pdoStatement->execute($values);
        return self::construireDepuisTableau($pdoStatement->fetch());
    }
}
