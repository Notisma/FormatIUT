<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Formation;

class EtudiantRepository extends RechercheRepository
{

    protected function getNomTable(): string
    {
        return "Etudiants";
    }

    protected function getNomsColonnes(): array
    {
        return array("numEtudiant", "prenomEtudiant", "nomEtudiant", "loginEtudiant", "sexeEtu", "mailUniversitaire", "mailPerso", "telephone", "groupe", "parcours", "validationPedagogique", "presenceForumIUT", "img_id");
    }

    /**
     * @return string[] permet de définir les colonnes sur lesquelles on peut faire une recherche
     */
    protected function getColonnesRecherche(): array
    {
        return array("prenomEtudiant", "nomEtudiant", "loginEtudiant", "groupe", "parcours");
    }

    protected function getClePrimaire(): string
    {
        return "numEtudiant";
    }

    /**
     * @param array $dataObjectTableau
     * @return Etudiant permet de construire un étudiant depuis un tableau
     */
    public function construireDepuisTableau(array $dataObjectTableau): Etudiant
    {
        return new Etudiant(
            $dataObjectTableau["numEtudiant"],
            $dataObjectTableau["prenomEtudiant"],
            $dataObjectTableau["nomEtudiant"],
            $dataObjectTableau["loginEtudiant"],
            $dataObjectTableau["sexeEtu"],
            $dataObjectTableau["mailUniversitaire"],
            $dataObjectTableau["mailPerso"],
            $dataObjectTableau["telephone"],
            $dataObjectTableau["groupe"],
            $dataObjectTableau["parcours"],
            $dataObjectTableau["validationPedagogique"],
            $dataObjectTableau["presenceForumIUT"],
            $dataObjectTableau['img_id']
        );
    }



    /**
     * @param $numEtu
     * @param $idFormation
     * @return mixed
     * permet de savoir si un étudiant à postuler à cet Offre mais n'a pas changé d'état depuis
     */
    public function etudiantAPostule($numEtu, $idFormation): mixed
    {
        $sql = "SELECT * FROM Postuler WHERE numEtudiant=:TagEtu AND idFormation=:TagOffre AND etat='En Attente'";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtu, "TagOffre" => $idFormation);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }


    /**
     * @param $idFormation
     * @return mixed
     * retourne le nombre de postulations faites au total pour cette offre
     */
    public function nbPostulations($idFormation): mixed
    {
        $sql = "SELECT COUNT(numEtudiant) AS nb FROM Postuler WHERE idFormation=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idFormation);
        $pdoStatement->execute($values);
        return ($pdoStatement->fetch())["nb"];
    }

    /**
     * @param $idEtudiant
     * @return mixed
     * retourne si l'étudiant à déjà une formation
     */
    public function aUneFormation($idEtudiant): mixed
    {
        $sql = "SELECT * FROM Formations WHERE idEtudiant=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idEtudiant);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }

    /**
     * @param $numEtudiant
     * @param $idFormation
     * @return mixed
     * retourne si l'étudiant à déjà postuler à cette offre
     */
    public function aPostule($numEtudiant, $idFormation): mixed
    {
        $sql = "SELECT * FROM Postuler WHERE numEtudiant=:TagEtu AND idFormation=:TagOffre";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idFormation);
        $pdoStatement->execute($values);
        return $pdoStatement->fetch();
    }


    /**
     * @param $idFormation
     * @return array
     * retourne la liste des étudiant qui sont actuellement dans la table Postuler de cette offre
     */
    public function etudiantsEnAttente($idFormation): array
    {
        $sql = "SELECT numEtudiant FROM Postuler r WHERE idFormation=:Tag AND etat!='Annulé'";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idFormation);
        $pdoStatement->execute($values);
        $listeEtu = array();
        foreach ($pdoStatement as $item) {
            $listeEtu[] = $this->getObjectParClePrimaire($item["numEtudiant"]);
        }
        return $listeEtu;
    }

    /**
     * @param string $login
     * @return bool retourne true si l'étudiant existe dans la base de donnée
     */
    public function estEtudiant(string $login): bool
    {
        $sql = "SELECT COUNT(*) FROM " . $this->getNomTable() . " WHERE loginEtudiant=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $login);
        $pdoStatement->execute($values);
        $count = $pdoStatement->fetch();
        if ($count[0] == 1) return true;
        return false;
    }

    /**
     * @param array $etudiant
     * @return void permet de créer un étudiant dans la base de donnée
     */
    public function premiereConnexion(array $etudiant): void
    {
        $sql = "INSERT INTO " . $this->getNomTable() . " (numEtudiant,prenomEtudiant,nomEtudiant,loginEtudiant,mailUniversitaire) VALUES (:numTag,:prenomTag,:nomTag,:loginTag,:mailTag)";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "numTag" => $etudiant["numEtudiant"],
            "prenomTag" => $etudiant["prenomEtudiant"],
            "nomTag" => $etudiant["nomEtudiant"],
            "loginTag" => $etudiant["loginEtudiant"],
            "mailTag" => $etudiant["mailUniversitaire"]
        );
        $pdoStatement->execute($values);
    }

    /**
     * @param string $login
     * @return int|null retourne le numéro étudiant de l'étudiant correspondant au login donné en paramètre
     */
    public function getNumEtudiantParLogin(string $login): ?int
    {
        $sql = "SELECT numEtudiant FROM " . $this->getNomTable() . " WHERE loginEtudiant=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $login);
        $pdoStatement->execute($values);

        $result = $pdoStatement->fetch();
        if (!$result) return null;
        else return $result[0];
    }

    /**
     * @param Etudiant $etudiant
     * @param int $oldNumEtudiant
     * @return void permet de modifier le numéro étudiant et le sexe d'un étudiant
     */
    public function modifierNumEtuSexe(Etudiant $etudiant, int $oldNumEtudiant): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET numEtudiant=:TagNum,sexeEtu=:TagSexe WHERE numEtudiant=:tagOldNum";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "TagNum" => $etudiant->getNumEtudiant(),
            "TagSexe" => $etudiant->getSexeEtu(),
            "tagOldNum" => $oldNumEtudiant
        );
        $pdoStatement->execute($values);
    }

    /**
     * @param Etudiant $etudiant
     * @return void permet de modifier le numéro de téléphone et le mail perso d'un étudiant
     */
    public function modifierTelMailPerso(Etudiant $etudiant): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET telephone=:tag1,mailPerso=:tag2 WHERE numEtudiant=:tagNum";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tag1" => $etudiant->getTelephone(),
            "tag2" => $etudiant->getMailPerso(),
            "tagNum" => $etudiant->getNumEtudiant()
        );
        $pdoStatement->execute($values);
    }

    /**
     * @param Etudiant $etudiant
     * @return void permet de modifier le groupe et le parcours d'un étudiant
     */
    public function modifierGroupeParcours(Etudiant $etudiant): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET groupe=:tag1,parcours=:tag2 WHERE numEtudiant=:tagNum";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array(
            "tag1" => $etudiant->getGroupe(),
            "tag2" => $etudiant->getParcours(),
            "tagNum" => $etudiant->getNumEtudiant()
        );
        $pdoStatement->execute($values);
    }

    /**
     * @param string $adresseMail
     * @param string $telephone
     * @param string $numEtu
     * @return void permet de mettre à jour le mail perso et le numéro de téléphone d'un étudiant
     */
    public function mettreAJourInfos(string $adresseMail, string $telephone, string $numEtu): void
    {
        $sql = "UPDATE Etudiants SET mailPerso = :mailTag, telephone = :telTag WHERE numEtudiant = :numTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("mailTag" => $adresseMail, "telTag" => $telephone, "numTag" => $numEtu);
        $pdoStatement->execute($values);
    }

    /**
     * @return array retourne la liste des étudiants qui n'ont pas de formation
     */
    public function etudiantsSansOffres(): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " etu WHERE NOT EXISTS( SELECT idEtudiant FROM Formations f WHERE f.idEtudiant=etu.numEtudiant ) ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $etudiant) {
            $listeEtudiants[] = $this->construireDepuisTableau($etudiant);
        }
        return $listeEtudiants;
    }

    /**
     * @return array retourne la liste des étudiants qui ont une formation
     */
    public function etudiantsEtats(): array
    {
        $sql = "SELECT numEtudiant,COUNT(idFormation) as AUneOffre
                FROM Etudiants etu 
                LEFT JOIN Formations f ON f.idEtudiant=etu.numEtudiant
                GROUP BY numEtudiant";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        foreach ($pdoStatement as $item) {
            $nb = $item["AUneOffre"];
            unset($item["AUneOffre"]);
            $listeEtudiants[] = array("etudiant" => $this->getObjectParClePrimaire($item["numEtudiant"]), "aUneFormation" => $nb);

        }
        return $listeEtudiants;
    }

    /**
     * @param $idFormation
     * @return array retourne la liste des étudiants qui ont postulé à cette offre
     */
    public function etudiantsCandidats($idFormation): array
    {
        $sql = "SELECT numEtudiant FROM Postuler WHERE idFormation=:Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $idFormation);
        $pdoStatement->execute($values);
        $listeEtudiants = array();
        foreach ($pdoStatement as $item) {
            $listeEtudiants[] = $this->getObjectParClePrimaire($item["numEtudiant"]);
        }
        return $listeEtudiants;
    }

    /**
     * @param $idFormation
     * @param $numEtudiant
     * @return string|null retourne l'état de la candidature d'un étudiant à une offre
     */
    public function getAssociationPourOffre($idFormation, $numEtudiant): ?string
    {
        $sql = "SELECT * FROM Postuler WHERE idFormation=:TagOffre AND numEtudiant=:TagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagOffre" => $idFormation, "TagEtu" => $numEtudiant);
        $pdoStatement->execute($values);
        $resultat = $pdoStatement->fetch();
        if ($resultat) {
            if ($resultat["etat"] == "En attente") {
                return "Candidat en attente";
            } else if ($resultat["etat"] == "Validée") {
                return "Assigné";
            } else if ($resultat["etat"] == "Refusée") {
                return "Refusé par l'entreprise";
            } else if ($resultat["etat"] == "A Choisir") {
                return "Accepté par l'entreprise";
            } else if ($resultat["etat"] == "Annulé") {
                return "Annulé";
            } else {
                $sql = "SELECT * FROM Formations WHERE idEtudiant=:TagEtu AND idFormation=:TagOffre";
                $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
                $values = array("TagEtu" => $numEtudiant, "TagOffre" => $idFormation);
                $pdoStatement->execute($values);
                $resultat = $pdoStatement->fetch();
                if ($resultat) {
                    return "Assigné";
                }
            }
        } else {
            return "Non assigné";
        }
        return null;
    }

    /**
     * @param Etudiant $etudiant
     * @return int retourne l'année de l'étudiant
     */
    public function getAnneeEtudiant(Etudiant $etudiant): int
    {
        return match (substr($etudiant->getGroupe(), 0, 1)) {
            "Q" => 2,
            "G" => 3,
            default => 2,
        };
    }

    /**
     * @param int $numEtu
     * @return Formation|null retourne l'offre validée de l'étudiant
     */
    public function getOffreValidee(int $numEtu): ?Formation
    {
        $sql = "Select * FROM Postuler r JOIN Formations o ON o.idFormation = r.idFormation WHERE numEtudiant = :tagEtu AND etat = 'Validée'";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        $arr = $pdoStatement->fetch();
        if (!$arr) return null;
        else return (new FormationRepository())->construireDepuisTableau($arr);
    }

    /**
     * @param string $login
     * @return Etudiant retourne l'étudiant correspondant au login donné en paramètre
     */
    public function getEtudiantParLogin(string $login): Etudiant
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE loginEtudiant = :Tag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $login);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());
    }
}
