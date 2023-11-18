<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Entreprise;
use PDO;

class EntrepriseRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "Entreprise";
    }

    protected function getNomsColonnes(): array
    {
        return ["numSiret", "nomEntreprise", "statutJuridique", "effectif", "codeNAF", "tel", "Adresse_Entreprise", "idVille", "img_id", "mdpHache", "email", "emailAValider", "nonce", "estValide"];
    }

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
            $entrepriseFormatTableau['Adresse_Entreprise'],
            $entrepriseFormatTableau['idVille'],
            $entrepriseFormatTableau["img_id"],
            $entrepriseFormatTableau["mdpHache"],
            $entrepriseFormatTableau["email"],
            $entrepriseFormatTableau["emailAValider"],
            $entrepriseFormatTableau["nonce"],
            $valide
        );
    }

    protected function getClePrimaire(): string
    {
        return "numSiret";
    }

    /***
     * @param $Siret
     * @param $idImage
     * @return void
     * remplace l'image de l'entreprise avec une nouvelle donc l'id est donnée en paramètre
     */

    public function updateImage($Siret, $idImage): void
    {
        $sql = "UPDATE " . $this->getNomTable() . " SET img_id=:TagImage WHERE " . $this->getClePrimaire() . "=:TagSiret";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("TagImage" => $idImage, "TagSiret" => $Siret);
        $pdoStatement->execute($values);
    }

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

    public function mettreAJourInfos(int $siret, string $nom, string $statut, int $effectif, string $codeNAF, string $tel, string $adresse)
    {
        $sql = "UPDATE Entreprise SET nomEntreprise = :nomTag, statutJuridique = :statutTag, effectif = :effTag, codeNAF = :codeTag, tel = :telTag, Adresse_Entreprise = :adTag WHERE numSiret = :siretTag";
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

    public function trouverEntrepriseDepuisForm($numEtu): Entreprise
    {
        $sql = "Select numSiret,nomEntreprise,statutJuridique,effectif,codeNAF,tel,Adresse_Entreprise,idVille,img_id, mdpHache, email, emailAValider,nonce ,estValide
        FROM Formation f JOIN Entreprise e ON f.idEntreprise = e.numSiret WHERE idEtudiant = :tagEtu";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("tagEtu" => $numEtu);
        $pdoStatement->execute($values);
        return $this->construireDepuisTableau($pdoStatement->fetch());

    }
}
