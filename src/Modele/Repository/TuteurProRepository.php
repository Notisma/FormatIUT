<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\TuteurPro;

class TuteurProRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "TuteursPro";
    }

    protected function getNomsColonnes(): array
    {
        return array("idTuteurPro", "mailTuteurPro", "telTuteurPro", "fonctionTuteurPro", "nomTuteurPro", "prenomTuteurPro", "idEntreprise");
    }

    protected function getClePrimaire(): string
    {
        return "idTuteurPro";
    }


    /**
     * @param $siret
     * @return array
     * Retourne un tableau de tuteurs pro d'une entreprise
     */
    public function getTuteursDuneEntreprise($siret) {
        $sql = "SELECT * FROM TuteursPro WHERE idEntreprise = :idEntreprise";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("idEntreprise" => $siret);
        $pdoStatement->execute($values);
        $objet = $pdoStatement->fetchAll();
        foreach ($objet as $key => $value) {
            $objet[$key] = $this->construireDepuisTableau($value);
        }
        return $objet;
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new TuteurPro(
            $dataObjectTableau["idTuteurPro"],
            $dataObjectTableau["mailTuteurPro"],
            $dataObjectTableau["telTuteurPro"],
            $dataObjectTableau["fonctionTuteurPro"],
            $dataObjectTableau["nomTuteurPro"],
            $dataObjectTableau["prenomTuteurPro"],
            $dataObjectTableau["idEntreprise"]
        );
    }

}
