<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Formation;

class FormationRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Formation";
    }

    protected function getNomsColonnes(): array
    {
        return array("idFormation", "dateDebut", "dateFin", "idEtudiant", "idTuteurPro", "idEntreprise", 'idConvention', "idTuteurUM", "idOffre");
    }

    protected function getClePrimaire(): string
    {
        return "idFormation";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        $dateDebut = new \DateTime($dataObjectTableau['dateDebut']);
        $dateFin = new \DateTime($dataObjectTableau['dateFin']);

        return new Formation(
            $dataObjectTableau["idFormation"],
            $dateDebut,
            $dateFin,
            $dataObjectTableau["idEtudiant"],
            $dataObjectTableau["idTuteurPro"],
            $dataObjectTableau["idEntreprise"],
            $dataObjectTableau["idConvention"],
            $dataObjectTableau["idTuteurUM"],
            $dataObjectTableau["idOffre"]
        );
    }

    public function listeIdTypeFormation(): array
    {
        $sql = "SELECT idOffre FROM Offre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeID = array();
        foreach ($pdoStatement as $item => $value) {
            $listeID[] = $value["idOffre"];
        }
        return $listeID;
    }

    //(idFormation,dateDebut,dateFin,idEtudiant,idEntreprise,idOffre)

    public function estFormation(string $offre): ?AbstractDataObject
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE idOffre=:Tag ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $offre);
        $pdoStatement->execute($values);
        $formation = $pdoStatement->fetch();
        if (!$formation) {
            return null;
        }
        return $this->construireDepuisTableau($formation);

    }

    public function ajouterConvention($idEtu, $idConvention): void
    {
        $sql = "UPDATE Formation SET idConvention =:tagConvention WHERE idEtudiant=:tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagConvention" => $idConvention, "tagEtu" => $idEtu);
        $pdoStatement->execute($values);
    }

}
