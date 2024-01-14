<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Formation;

class FormationRepository extends RechercheRepository
{

    protected function getNomTable(): string
    {
        return "Formations";
    }

    protected function getNomsColonnes(): array
    {

        return array("idFormation", "nomOffre", "dateDebut", "dateFin", "sujet", "detailProjet", "dureeHeure", "joursParSemaine", "gratification", "uniteGratification", "uniteDureeGratification", "nbHeuresHebdo", "offreValidee", "objectifOffre", "dateCreationOffre", "typeOffre", "anneeMax", "anneeMin", "estValide", "validationPedagogique", "convention", "conventionValidee", "dateCreationConvention", "dateTransmissionConvention", "dateRetourSigne", "assurance", "avenant", "idEtudiant", "idTuteurPro", "idEntreprise", "loginTuteurUM", "tuteurUMvalide");
    }

    protected function getColonnesRecherche(): array
    {
        return array("nomOffre", "sujet", "typeOffre", "detailProjet");
    }

    protected function getClePrimaire(): string
    {
        return "idFormation";
    }

    public function construireDepuisTableau(array $dataObjectTableau): AbstractDataObject
    {
        return new Formation($dataObjectTableau["idFormation"], $dataObjectTableau["nomOffre"], $dataObjectTableau["dateDebut"], $dataObjectTableau["dateFin"], $dataObjectTableau["sujet"], $dataObjectTableau["detailProjet"], $dataObjectTableau["dureeHeure"], $dataObjectTableau["joursParSemaine"], $dataObjectTableau["gratification"], $dataObjectTableau["uniteGratification"], $dataObjectTableau["uniteDureeGratification"], $dataObjectTableau["nbHeuresHebdo"], $dataObjectTableau["offreValidee"], $dataObjectTableau["objectifOffre"], $dataObjectTableau["dateCreationOffre"], $dataObjectTableau["typeOffre"], $dataObjectTableau["anneeMax"], $dataObjectTableau["anneeMin"], $dataObjectTableau["estValide"], $dataObjectTableau["validationPedagogique"], $dataObjectTableau["convention"], $dataObjectTableau["conventionValidee"], $dataObjectTableau["dateCreationConvention"], $dataObjectTableau["dateTransmissionConvention"], $dataObjectTableau["dateRetourSigne"], $dataObjectTableau["assurance"], $dataObjectTableau["avenant"], $dataObjectTableau["idEtudiant"], $dataObjectTableau["idTuteurPro"], $dataObjectTableau["idEntreprise"], $dataObjectTableau["loginTuteurUM"], $dataObjectTableau["tuteurUMvalide"]);
    }


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


    public function getListeOffresDispoParType($type): array
    {
        $etu=(new EtudiantRepository())->getObjectParClePrimaire((new EtudiantRepository())->getNumEtudiantParLogin(ConnexionUtilisateur::getLoginUtilisateurConnecte()));
        $anneeEtudiant = (new EtudiantRepository())->getAnneeEtudiant($etu);
        $values = array();
        $sql = "SELECT * FROM " . $this->getNomTable() . " o ";
        $sql .= " WHERE idEtudiant is null AND estValide=1";
        if ($type == "Stage" || $type == "Alternance") {
            $sql .= " AND (typeOffre=:TypeTag  OR typeOffre=\"Stage/Alternance\")";
            $values["TypeTag"] = $type;
        }
        $sql .= " AND anneeMin <= :TagAnnee AND anneeMax >= :TagAnnee AND estValide=1";
        $values["TagAnnee"]=$anneeEtudiant;
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
     * @param $type
     * @param $etat
     * @return array
     * retourne la liste des id offres pour une entreprise avec différents filtres
     */
    public function getListeOffreParEntreprise($idEntreprise, $type, $etat): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " o WHERE idEntreprise=:Tag";
        if ($type == "Stage" || $type == "Alternance") {
            $sql .= " AND typeOffre=:TypeTag OR typeOffre='Stage/Alternance'";
            $values["TypeTag"] = $type;
        }
        if ($etat == "Dispo") {
            $sql .= " AND idEtudiant IS null";
        } else if ($etat == "Assigné") {
            $sql .= " AND idEtudiant IS not null";
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
     * retourne la liste des offres auxquelles a déjà postulé un étudiant
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
     * @param $type
     * @return array
     * Retourne la liste des id des offres disponibles pour un étudiant, en respectant l'année de l'étudiant
     */
    public function getListeIDFormationsPourEtudiant($type, $etudiant): array
    {
        $anneeEtudiant = (new EtudiantRepository())->getAnneeEtudiant($etudiant);
        $sql = "";
        if ($type == "all" || $type == "Tous") {
            $sql = "SELECT idFormation FROM Formations WHERE idEtudiant IS NULL";
        } else {
            $sql = "SELECT idFormation FROM Formations WHERE idEtudiant IS NULL AND typeOffre=:Tag OR typeOffre='Stage/Alternance'";
        }
        $sql .= " AND anneeMin <= :TagAnnee AND anneeMax >= :TagAnnee AND estValide=1";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagAnnee" => $anneeEtudiant);
        if ($type != "all" || $type != "Tous") {
            $values["Tag"] = $type;
        }
        $pdoStatement->execute($values);
        $listeId = array();
        foreach ($pdoStatement as $item => $value) {
            $listeId[] = $value["idFormation"];
        }
        return $listeId;
    }


    /**
     * @return array
     * retourne la liste des id des offres
     */
    public function getListeidFormations(): array
    {
        $sql = "SELECT idFormation FROM Formations";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeId = array();
        foreach ($pdoStatement as $item => $value) {
            $listeId[] = $value["idFormation"];
        }
        return $listeId;
    }



    public function mettreAChoisir($numEtudiant, $idFormation): void
    {
        $sql = "UPDATE Postuler SET etat='A Choisir' WHERE numEtudiant=:TagEtu AND idFormation=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idFormation);
        $pdoStatement->execute($values);
    }

    /**
     * @param $idEntreprise
     * @return array
     * retourne la liste des id des offres pour une entreprise
     */

    public function listeidFormationEntreprise($idEntreprise): array
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
        $listeOffres = array();
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE estValide=0";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = $this->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }

    /** @return Formation[] */
    public function offresPourEtudiant($numEtudiant): array
    {
        //retourne l'offre à laquelle l'étudiant est assigné. Si il n'est assigné à aucune offre, retourne la liste des offres auxquelles il a postulé
        $sql = "SELECT * FROM " . $this->getNomTable() . " o JOIN Postuler r ON o.idFormation=r.idFormation WHERE numEtudiant=:Tag ORDER BY etat DESC";
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
        $offre = $pdoStatement->fetch();
        if ($offre == false) {
            return null;
        } else {
            return $this->construireDepuisTableau($offre);
        }
    }



    /** Comme au dessus, mais de n'importe quel type */
    public function trouverFormationValidee($numEtu): ?Formation
    {
        $sql = "SELECT * FROM Formations f JOIN Postuler r ON r.idFormation = f.idFormation WHERE numEtudiant = :tagEtu AND etat = 'Validée'";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        $test = $pdoStatement->fetch();
        if (!$test)
            return null;
        else
            return $this->construireDepuisTableau($test);
    }

    public function etudiantsSansConventionsValides(): array
    {
        $listFormations = array();
        $sql = "SELECT *
        FROM Formations
        WHERE dateCreationConvention IS NOT NULL AND conventionValidee = 0 AND idEtudiant IS NOT NULL";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute();
        foreach ($pdoStatement as $formation) {
            $listFormations[] = $this->construireDepuisTableau($formation);
        }
        return $listFormations;
    }

    public static function nbMoyenOffresParEntreprise(): ?float {
        $sql = "SELECT AVG(COALESCE(subquery.nbFormations, 0)) AS MoyenneFormations
                FROM Entreprises e
                LEFT JOIN (SELECT idEntreprise, COUNT(*) AS nbFormations
                FROM Formations
                GROUP BY idEntreprise) AS subquery ON e.numSiret = subquery.idEntreprise;";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $objet = $pdoStatement->fetch();
        if (!$objet) {
            return null;
        }
        return $objet[0];
    }
}
