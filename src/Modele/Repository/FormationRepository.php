<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Formation;
use DateTime;

class FormationRepository extends AbstractRepository
{

    protected function getNomTable(): string
    {
        return "Formations";
    }

    protected function getNomsColonnes(): array
    {
        return array("idFormation", "nomOffre", "dateDebut", "dateFin", "sujet","detailProjet","dureeHeure","joursParSemaine","gratification","uniteGratification","uniteDureeGratification","nbHeuresHebdo","offreValidee","objectifOffre","dateCreationOffre","typeOffre","anneeMax","anneeMin","estValide","validationPedagogique","convention","conventionValidee","dateCreationConvention","dateTransmissionConvention","retourSigne","assurance","avenant","idEtudiant","idTuteurPro","idEntreprise","idTuteurUM");
    }

    protected function getClePrimaire(): string
    {
        return "idFormation";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Formation( $dataObjectTableau["idFormation"],$dataObjectTableau["nomOffre"],$dataObjectTableau["dateDebut"],$dataObjectTableau["dateFin"], $dataObjectTableau["sujet"],$dataObjectTableau["detailProjet"],$dataObjectTableau["dureeHeure"],$dataObjectTableau["joursParSemaine"],$dataObjectTableau["gratification"],$dataObjectTableau["uniteGratification"],$dataObjectTableau["uniteDureeGratification"],$dataObjectTableau["nbHeuresHebdo"],$dataObjectTableau["offreValidee"],$dataObjectTableau["objectifOffre"],$dataObjectTableau["dateCreationOffre"],$dataObjectTableau["typeOffre"],$dataObjectTableau["anneeMax"],$dataObjectTableau["anneeMin"],$dataObjectTableau["estValide"],$dataObjectTableau["validationPedagogique"],$dataObjectTableau["convention"],$dataObjectTableau["conventionValidee"],$dataObjectTableau["dateCreationConvention"],$dataObjectTableau["dateTransmissionConvention"],$dataObjectTableau["retourSigne"],$dataObjectTableau["assurance"],$dataObjectTableau["avenant"],$dataObjectTableau["idEtudiant"],$dataObjectTableau["idTuteurPro"],$dataObjectTableau["idEntreprise"],$dataObjectTableau["idTuteurUM"]);
    }

    public function listeIdTypeFormation(): array
    {
        $sql = "SELECT idFormation FROM Formations";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeID = array();
        foreach ($pdoStatement as $item => $value) {
            $listeID[] = $value["idFormation"];
        }
        return $listeID;
    }

    //(idFormation,dateDebut,dateFin,idEtudiant,idEntreprise,idOffre)

    public function estFormation(string $offre): ?AbstractDataObject
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE idFormation=:Tag AND idEtudiant IS NOT NULL";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $offre);
        $pdoStatement->execute($values);
        $formation = $pdoStatement->fetch();
        if (!$formation) {
            return null;
        }
        return $this->construireDepuisTableau($formation);

    }

    public function ajouterConvention($idEtu, $convention): void
    {
        $sql = "UPDATE Formations SET convention =:tagConvention WHERE idEtudiant=:tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagConvention" => $convention, "tagEtu" => $idEtu);
        $pdoStatement->execute($values);
    }
    public function getListeOffresDispoParType($type): array
    {
        $values = array();
        $sql = "SELECT * FROM " . $this->getNomTable() . " o ";
        $sql .= " WHERE NOT EXISTS (SELECT idFormation FROM Formations f WHERE f.idFormation=o.idFormation)";
        if ($type == "Stage" || $type == "Alternance") {
            $sql .= " AND typeOffre=:TypeTag";
            $values["TypeTag"] = $type;
        }
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
        $listeOffre = array();
        foreach ($pdoStatement as $offre) {
            $listeOffre[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffre;
    }
    /**
     * @param $idEntreprise
     * @return array
     * retourne la liste des offres disponibles pour une entreprise
     */
    public function offresParEntrepriseDispo($idEntreprise): array
    {
        $sql = "SELECT * 
                FROM " . $this->getNomTable() . " o
                WHERE idEntreprise=:Tag 
                AND NOT EXISTS (
                SELECT idFormation FROM Formations f
                WHERE f.idFormation=o.idFormation)";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeOffre = array();
        foreach ($pdoStatement as $item) {
            $listeOffre[] = $this->construireDepuisTableau($item);
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
    public function getListeOffreParEntreprise($idEntreprise, $type, $etat): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " o WHERE idEntreprise=:Tag";
        if ($type == "Stage" || $type == "Alternance") {
            $sql .= " AND typeOffre=:TypeTag";
            $values["TypeTag"] = $type;
        }
        if ($etat == "Dispo") {
            $sql .= " AND NOT EXISTS (SELECT idFormation FROM Formation f WHERE o.idFormation=f.idFormation)";
        } else if ($etat == "Assigné") {
            $sql .= " AND EXISTS (SELECT idFormation FROM Formation f WHERE f.idFormation=o.idFormation)";
        }
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values["Tag"] = $idEntreprise;
        $pdoStatement->execute($values);
        $listeOffre = array();
        foreach ($pdoStatement as $offre) {
            $listeOffre[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffre;
    }
    /**
     * @param $numEtudiant
     * @return array
     * retourne la liste des offres auquel à déjà postuler un étudiant
     */

    public function listeOffresEtu($numEtudiant): array
    {
        $sql = "SELECT * FROM Formations o JOIN Postuler r ON o.idFormation = r.idFormation WHERE numEtudiant = :TagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "TagEtu" => $numEtudiant
        );
        $pdoStatement->execute($values);
        $listOffre = array();
        foreach ($pdoStatement as $offre) {
            $listOffre[] = $this->construireDepuisTableau($offre);
        }
        return $listOffre;

    }
    /**
     * @return array
     * retourne la liste des id des offres
     */

    public function getListeIdOffres(): array
    {
        $sql = "SELECT idFormation FROM Formations";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeId = array();
        foreach ($pdoStatement as $item => $value) {
            $listeId[] = $value["idFormation"];
        }
        return $listeId;
    }
    /**
     * @param string $type
     * @return array
     * retourne la liste des ids pour un type donné
     */
    public function listeIdTypeOffre(string $type): array
    {
        $sql = "SELECT idFormation FROM Formations WHERE typeOffre=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $type);
        $pdoStatement->execute($values);
        $listeID = array();
        foreach ($pdoStatement as $item => $value) {
            $listeID[] = $value["idFormation"];
        }
        return $listeID;
    }
    /**
     * @param $idEntreprise
     * @return array
     * retourne la liste des id des offres pour une entreprise
     */

    public function listeIdOffreEntreprise($idEntreprise): array
    {
        $sql = "SELECT idFormation FROM Formations WHERE idEntreprise=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeID = array();
        foreach ($pdoStatement as $item => $value) {
            $listeID[] = $value["idFormation"];
        }
        return $listeID;
    }
    public function offresNonValides(): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE estValide=0";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }
    public function offresPourEtudiant($numEtudiant): array
    {
        //retourne l'offre à laquelle l'étudiant est assigné. Si il n'est assigné à aucune offre, retourne la liste des offres auxquelles il a postulé
        $sql = "SELECT * FROM " . $this->getNomTable() . " o JOIN Postuler r ON o.idFormation=r.idFormation WHERE numEtudiant=:Tag ORDER BY Etat DESC";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $numEtudiant);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }
    public function offresPourEntreprise($idEntreprise): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE idEntreprise=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }
    public function trouverOffreDepuisForm($numEtu): ?Formation
    {
        $sql = "SELECT * FROM Formations WHERE idEtudiant = :tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
    public function trouverOffreValide($numEtu, $typeOffre): Formation
    {
        $sql = "SELECT * FROM Formations f JOIN Postuler r ON r.idFormation = f.idFormation WHERE numEtudiant=:tagEtu AND typeOffre=:tagType AND Etat='Validée'";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu, "tagType" => $typeOffre);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}
