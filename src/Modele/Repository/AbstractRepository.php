<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Lib\DevUtils;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;

abstract class AbstractRepository
{
    protected abstract function getNomTable(): string;

    protected abstract function getNomsColonnes(): array;

    protected abstract function getClePrimaire(): string;

    public abstract function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject;

    /***
     * @return array|null
     * retourne une liste de l'ensemble des object d'une même classe
     * renvoie null si aucun objet n'est créer
     */
    public function getListeObjet(): ?array
    {
        $sql = 'SELECT * FROM ' . $this->getNomTable();
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeObjet = array();
        foreach ($pdoStatement as $item) {
            $listeObjet[] = $this->construireDepuisTableau($item);
        }
        return $listeObjet;
    }



    /***
     * @param $clePrimaire
     * @return AbstractDataObject|null
     * retourne un objet correspondant à la clé primaire donnée en paramètre
     * si l'objet n'existe pas, renvoie null
     */

    public function getObjectParClePrimaire($clePrimaire): ?AbstractDataObject
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE " . $this->getClePrimaire() . "=:Tag ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $clePrimaire);
        $pdoStatement->execute($values);
        $objet = $pdoStatement->fetch();
        if (!$objet) {
            return null;
        }
        return $this->construireDepuisTableau($objet);
    }


    /*public function getObjectParClesPrimaires($clesPrimaires):?AbstractDataObject{
        $placeholders = implode(',', array_fill(0, count($clesPrimaires), '?'));
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE " . $this->getClePrimaire() . " IN ({$placeholders})";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        foreach ($clesPrimaires as $index => $valeur) {
            $pdoStatement->bindValue($index + 1, $valeur, PDO::PARAM_INT);
        }
        $pdoStatement->execute();
        $objets = $pdoStatement->fetchAll();
        if (!$objets){
            return null;
        }
        $result = array();
        foreach ($objets as $objet) {
            $result[] = $this->construireDepuisTableau($objet);
        }
        return $this->construireDepuisTableau($result);
    }*/

    // ----- CRUD -----

    /***
     * @param AbstractDataObject $object
     * @return string|false last insert ID (for auto-increment)
     * créer un object dans la Base de Donnée avec les informations de l'objet donné en paramètre
     */
    public function creerObjet(AbstractDataObject $object): string|false
    {
        $fields = "";
        $values = "";
        $tags = array();
        foreach ($this->getNomsColonnes() as $nomColonne) {
            if ($nomColonne != $this->getNomsColonnes()[0]) {
                $fields .= ", ";
                $values .= ", ";
            }
            $fields .= $nomColonne;
            $values .= ":" . $nomColonne . "Tag";
            $tags[$nomColonne . "Tag"] = $object->formatTableau()[$nomColonne];
        }
        $sql = "INSERT IGNORE INTO " . $this->getNomTable() . " ($fields) VALUES ($values);";
        $pdo = ConnexionBaseDeDonnee::getPdo();
        $pdoStatement = $pdo->prepare($sql);
        $pdoStatement->execute($tags);

        return $pdo->lastInsertId();
    }


    public function modifierObjet(AbstractDataObject $objet): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET ";
        foreach ($this->getNomsColonnes() as $nomColonne) {
            if ($nomColonne != $this->getNomsColonnes()[0])
                $sql .= ",";
            $sql .= "$nomColonne = :$nomColonne" . "Tag";
            $values[$nomColonne . "Tag"] = $objet->formatTableau()[$nomColonne];
        }
        $where = " WHERE ";
        $clePrimaire = $this->getClePrimaire();
        $clePrimaire = trim($clePrimaire, "()");
        $colonnesClePrimaire = explode(', ', $clePrimaire);
        foreach ($colonnesClePrimaire as $colonne) {
            $where .= "$colonne = :$colonne" . "Tag AND ";
            $values[$colonne . "Tag"] = $objet->formatTableau()[$colonne];
        }
        $where = rtrim($where, " AND ");
        $sql .= $where;
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
    }

    /***
     * @param $clePrimaire
     * @return void
     * supprime dans la Base de donnée l'objet donc la clé primaire est en paramètre
     */

    public function supprimer($clePrimaire): void
    {
        $sql = "DELETE FROM " . $this->getNomTable() . " WHERE " . $this->getClePrimaire() . "=:Tag ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $clePrimaire);
        $pdoStatement->execute($values);
    }

    /**
     * @param $colonne
     * @return int|null
     * Permet de récupérer le nombre d'éléments distincts dans une table pour une colonne donnée
     */
    public function nbElementsDistincts($colonne): ?int {
        $sql = "SELECT COUNT(DISTINCT(" . $colonne . ")) FROM " . $this->getNomTable() . " WHERE ". $colonne ." IS NOT NULL;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objet = $pdoStatement->fetchColumn();
        if (!$objet) {
            return null;
        }
        return $objet;
    }

    /**
     * @param $colonne
     * @param $valeur
     * @return int|null
     * Permet de récupérer le nombre d'éléments distincts dans une table pour une colonne donnée lorsque la valeur donnée est contenue dedans
     */
    public function nbElementsDistinctsQuandContient($colonne, $valeur): ?int {
        $sql = "SELECT COUNT(DISTINCT(" . $this->getClePrimaire() . ")) FROM " . $this->getNomTable() . " WHERE ". $colonne ." LIKE '%" . $valeur . "%';";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objet = $pdoStatement->fetchColumn();
        if (!$objet) {
            return null;
        }
        return $objet;
    }

    /**
     * @param $colonne
     * @param $valeur
     * @return int|null
     * Permet de récupérer le nombre d'éléments distincts dans une table pour une colonne donnée lorsque sa valeur est égale à celle donnée
     */
    public function nbElementsDistinctsQuandEgal($colonne, $valeur): ?int {
        $sql = "SELECT COUNT(DISTINCT(" . $this->getClePrimaire() . ")) FROM " . $this->getNomTable() . " WHERE ". $colonne ." = " . $valeur . ";";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objet = $pdoStatement->fetchColumn();
        if (!$objet) {
            return null;
        }
        return $objet;
    }

    //-------------AUTRES------------




    /**
     * @param $nom
     * @return int|null
     * Permet de récupérer le résultat d'une des fonctions pl/sql en passant son nom en paramètre
     */
    public static function lancerFonctionHistorique($nom) : ?float {
        $sql = "SELECT " . $nom . "();";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objet = $pdoStatement->fetchColumn();
        if (!$objet){
            return false;
        }
        return $objet;
    }

}
