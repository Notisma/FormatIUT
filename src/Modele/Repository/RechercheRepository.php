<?php

namespace App\FormatIUT\Modele\Repository;

abstract class RechercheRepository extends AbstractRepository
{
    protected abstract function getColonnesRecherche(): array;

    public function recherche(array $motsclefs, array $filtres): array
    {
        foreach ($motsclefs as $mot) {
            $mot = strtolower($mot);
            $sql = "SELECT * FROM " . $this->getNomTable() . " " . strtoupper($this->getNomTable())[0] . " WHERE (";
            foreach ($this->getColonnesRecherche() as $colonne) {
                if ($colonne != $this->getColonnesRecherche()[0]) {
                    $sql .= " OR ";
                }
                $sql .= " LOWER($colonne) LIKE :tag$colonne";
                $values["tag" . $colonne] = "%$mot%";
            }
        }
        $sql .= ")";
        foreach ($filtres as $filtre) {
            if (!empty($filtre))
                $sql .= " AND " . $filtre;
        }
        //var_dump($sql);
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $liste = array();
        foreach ($pdoStatement as $item) {
            $liste[] = $this->construireDepuisTableau($item);
        }
        return $liste;
    }
}