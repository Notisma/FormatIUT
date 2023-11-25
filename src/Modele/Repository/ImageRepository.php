<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Ville;

class ImageRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Images";
    }

    protected function getNomsColonnes(): array
    {
        return ["img_id", "img_nom", "img_taille", "img_type", "img_link"];
    }

    protected function getClePrimaire(): string
    {
        return "img_id";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Ville("", "", "");
    }

    public function getImage($img_if): mixed
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE " . $this->getClePrimaire() . "=:Tag ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $img_if);
        $pdoStatement->execute($values);
        $objet = $pdoStatement->fetch();
        if (!$objet) {
            return null;
        }
        return $objet;
    }

    /**
     * @param array $values
     * @return void
     * créer une image dans la base de donnée
     */
    public function insert(array $values): void
    {
        $req = "INSERT INTO Images VALUES (" .
            "'" . $values["img_id"] . "', " .
            "'" . $values["img_nom"] . "', " .
            "'" . $values["img_taille"] . "', " .
            "'" . $values["img_type"] . "', " .
            "'" . addslashes($values["img_link"]) . "') ";
        $pdpoStatement = ConnexionBaseDeDonnee::getPdo()->query($req);

    }

    /**
     * @return array
     * retourne la liste des id des différentes images
     */
    public function listeID(): array
    {
        $sql = "SELECT img_id FROM Images";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeID = array();
        foreach ($pdoStatement as $item => $value) {
            $listeID[] = $value["img_id"];
        }
        return $listeID;
    }

    /**
     * @param $Siret
     * @return mixed
     * retourne l'image de photo de profil pour une entreprise
     */

    public function imageParEntreprise($Siret): mixed
    {
        $sql = "SELECT img_id FROM Entreprises WHERE numSiret=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $Siret);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }

    /**
     * @param $numEtudiant
     * @return mixed
     * retourne l'image de photo de profil pour un étudiant
     */

    public function imageParEtudiant($numEtudiant): mixed
    {
        $sql = "SELECT img_id FROM Etudiants WHERE numEtudiant=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $numEtudiant);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }
}
