<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\Entreprise;
use DateTime;

class  EntrepriseRepository extends RechercheRepository
{
    protected function getNomTable(): string
    {
        return "Entreprises";
    }

    protected function getNomsColonnes(): array
    {
        return ["numSiret", "nomEntreprise", "statutJuridique", "effectif", "codeNAF", "tel", "adresseEntreprise", "idVille", "img_id", "mdpHache", "email", "emailAValider", "nonce", "estValide","dateCreationCompte"];
    }
    protected function getColonnesRecherche(): array
    {
        return array("nomEntreprise");
    }

    /**
     * @param array $entrepriseFormatTableau
     * @return Entreprise permet de construire une entreprise depuis un tableau
     */
    public function construireDepuisTableau(array $entrepriseFormatTableau): Entreprise
    {
        $valide = 0;
        if (isset($entrepriseFormatTableau["estValide"]) && $entrepriseFormatTableau["estValide"]) {
            $valide = 1;
        }

        return new Entreprise($entrepriseFormatTableau['numSiret'], $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel'],
            $entrepriseFormatTableau['adresseEntreprise'],
            $entrepriseFormatTableau['idVille'],
            $entrepriseFormatTableau["img_id"],
            $entrepriseFormatTableau["mdpHache"],
            $entrepriseFormatTableau["email"],
            $entrepriseFormatTableau["emailAValider"],
            $entrepriseFormatTableau["nonce"],
            $valide,
            $entrepriseFormatTableau["dateCreationCompte"]
        );
    }

    protected function getClePrimaire(): string
    {
        return "numSiret";
    }

    /**
     * @param string $mail
     * @return Entreprise|null permet de trouver une entreprise depuis son mail
     */
    public function getEntrepriseParMail(string $mail): ?Entreprise
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE  email=:Tag ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("Tag" => $mail);
        $pdoStatement->execute($values);
        $objet = $pdoStatement->fetch();
        if (!$objet) {
            return null;
        }
        return $this->construireDepuisTableau($objet);
    }

    public function entreprisesNonValide(): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable() . " WHERE estValide=0";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $listeEntreprises = array();
        foreach ($pdoStatement as $entreprise) {
            $listeEntreprises[] = $this->construireDepuisTableau($entreprise);
        }
        return $listeEntreprises;
    }

    /**
     * @param int $siret
     * @param string $nom
     * @param string $statut
     * @param int $effectif
     * @param string $codeNAF
     * @param string $tel
     * @param string $adresse
     * @return void permet de mettre à jour les informations d'une entreprise
     */
    public function mettreAJourInfos(int $siret, string $nom, string $statut, int $effectif, string $codeNAF, string $tel, string $adresse)
    {
        $sql = "UPDATE Entreprises SET nomEntreprise = :nomTag, statutJuridique = :statutTag, effectif = :effTag, codeNAF = :codeTag, tel = :telTag, adresseEntreprise = :adTag WHERE numSiret = :siretTag";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("nomTag" => $nom,
            "statutTag" => $statut,
            "effTag" => $effectif,
            "codeTag" => $codeNAF,
            "telTag" => $tel,
            "adTag" => $adresse,
            "siretTag" => $siret);
        $pdoStatement->execute($values);
    }

    /**
     * @param $numEtu
     * @return Entreprise permet de trouver l'entreprise d'un étudiant
     */
    public function trouverEntrepriseDepuisForm($numEtu): Entreprise
    {
        $sql = "SELECT numSiret,nomEntreprise,statutJuridique,effectif,codeNAF,tel,adresseEntreprise,idVille,img_id, mdpHache, email, emailAValider,nonce ,e.estValide, dateCreationCompte
        FROM Formations f JOIN Entreprises e ON f.idEntreprise = e.numSiret WHERE idEtudiant = :tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());

    }

    /**
     * @param int $idEntreprise
     * @return array permet de trouver les offres valides d'une entreprise
     */
    public function getOffresNonValidesDeEntreprise(int $idEntreprise): array
    {
        $sql = "SELECT * FROM Formations WHERE idEntreprise = :tagId AND estValide = 0";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagId" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = (new FormationRepository())->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }

    /**
     * @param int $idEntreprise
     * @return array permet de trouver les offres non valides d'une entreprise
     */
    public function getOffresValidesDeEntreprise(int $idEntreprise): array
    {
        $sql = "SELECT * FROM Formations WHERE idEntreprise = :tagId AND estValide = 1";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagId" => $idEntreprise);
        $pdoStatement->execute($values);
        $listeOffres = array();
        foreach ($pdoStatement as $offre) {
            $listeOffres[] = (new FormationRepository())->construireDepuisTableau($offre);
        }
        return $listeOffres;
    }
}
