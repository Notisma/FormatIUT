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


    public function getTuteursDuneEntreprise($siret) {
        $sql = "SELECT * FROM TuteursPro WHERE idEntreprise = :idEntreprise";
        $requete = $this->db->prepare($sql);
        $requete->bindValue(":idEntreprise", $siret);
        $requete->execute();
        $dataObjectTableau = $requete->fetchAll();
        $tuteurs = array();
        foreach ($dataObjectTableau as $dataObject) {
            $tuteurs[] = $this->construireDepuisTableau($dataObject);
        }
        return $tuteurs;
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
