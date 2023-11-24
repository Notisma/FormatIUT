<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\pstage;

class pstageRepository extends AbstractRepository
{
    public function getNomTable(): string
    {
        return "pstage";
    }

    public function getClePrimaire(): string
    {
        return "numeroConvention";
    }

    public function getNomsColonnes(): array
    {
        return array(
            "numeroConvention",
            "numeroEtudiant",
            "nomEtudiant",
            "prenomEtudiant",
            "telPersoEtu",
            "telPortEtu",
            "mailPersoEtu",
            "mailUnivEtu",
            "codeUFR",
            "libelleUFR",
            "codeDepartement",
            "codeEtape",
            "libelleEtape",
            "dateDebutStage",
            "dateFinStage",
            "interruption",
            "dateDebutInterruption",
            "dateFinInterruption",
            "thematique",
            "sujet",
            "fonctionTache",
            "detailProjet",
            "dureeStage",
            "nbJoursTravail",
            "nbHeuresHebdo",
            "gratification",
            "uniteGratification",
            "uniteDureeGratification",
            "conventionValidee",
            "nomEnseignantReferent",
            "prenomEnseignantReferent",
            "mailEnseignantReferent",
            "nomSignataire",
            "prenomSignataire",
            "mailSignataire",
            "fonctionSignataire",
            "anneeUniversitaire",
            "typeConvention",
            "commentaireStage",
            "commentaireDureeTravail",
            "codeELP",
            "elementPedagogique",
            "codeSexeEtu",
            "avantagesNature",
            "adresseEtu",
            "codePostalEtu",
            "paysEtu",
            "villeEtu",
            "conventionValideePedagogiquement",
            "avenantConvention",
            "detailsAvenant",
            "dateCreationConvention",
            "modificationConvention",
            "origineStage",
            "nomEtablissement",
            "siret",
            "adresseResidence",
            "adresseVoie",
            "adresseLibCedex",
            "codePostal",
            "etablissementCommune",
            "pays",
            "statutJuridique",
            "typeStructure",
            "effectif",
            "codeNAF",
            "tel",
            "fax",
            "mail",
            "siteWeb",
            "nomServiceAccueil",
            "residenceServiceAccueil",
            "voieServiceAccueil",
            "cedexServiceAccueil",
            "postalServiceAccueil",
            "communeServiceAccueil",
            "paysServiceAccueil",
            "nomTuteurProfessionnel",
            "prenomTuteurProfessionnel",
            "mailTuteurProfessionnel",
            "telTuteurProfessionnel",
            "fonctionTuteurProfessionnel"
        );
    }

    public function construireDepuisTableau(array $dataObjectTableau): pstage
    {

        $interruption = $dataObjectTableau[15] ? true : false;
        $conventionValidee = $dataObjectTableau[28] ? true : false;
        $conventionValideePedagogiquement = $dataObjectTableau[48] ? true : false;
        $avenantConvention = $dataObjectTableau[49] ? true : false;

        return new pstage(
            $dataObjectTableau[0],
            $dataObjectTableau[1],
            $dataObjectTableau[2],
            $dataObjectTableau[3],
            $dataObjectTableau[4],
            $dataObjectTableau[5],
            $dataObjectTableau[6],
            $dataObjectTableau[7],
            $dataObjectTableau[8],
            $dataObjectTableau[9],
            $dataObjectTableau[10],
            $dataObjectTableau[11],
            $dataObjectTableau[12],
            $dataObjectTableau[13],
            $dataObjectTableau[14],
            $interruption,
            $dataObjectTableau[16],
            $dataObjectTableau[17],
            $dataObjectTableau[18],
            $dataObjectTableau[19],
            $dataObjectTableau[20],
            $dataObjectTableau[21],
            $dataObjectTableau[22],
            $dataObjectTableau[23],
            $dataObjectTableau[24],
            $dataObjectTableau[25],
            $dataObjectTableau[26],
            $dataObjectTableau[27],
            $conventionValidee,
            $dataObjectTableau[29],
            $dataObjectTableau[30],
            $dataObjectTableau[31],
            $dataObjectTableau[32],
            $dataObjectTableau[33],
            $dataObjectTableau[34],
            $dataObjectTableau[35],
            $dataObjectTableau[36],
            $dataObjectTableau[37],
            $dataObjectTableau[38],
            $dataObjectTableau[39],
            $dataObjectTableau[40],
            $dataObjectTableau[41],
            $dataObjectTableau[42],
            $dataObjectTableau[43],
            $dataObjectTableau[44],
            $dataObjectTableau[45],
            $dataObjectTableau[46],
            $dataObjectTableau[47],
            $conventionValideePedagogiquement,
            $avenantConvention,
            $dataObjectTableau[50],
            $dataObjectTableau[51],
            $dataObjectTableau[52],
            $dataObjectTableau[53],
            $dataObjectTableau[54],
            $dataObjectTableau[55],
            $dataObjectTableau[56],
            $dataObjectTableau[57],
            $dataObjectTableau[58],
            $dataObjectTableau[59],
            $dataObjectTableau[60],
            $dataObjectTableau[61],
            $dataObjectTableau[62],
            $dataObjectTableau[63],
            $dataObjectTableau[64],
            $dataObjectTableau[65],
            $dataObjectTableau[66],
            $dataObjectTableau[67],
            $dataObjectTableau[68],
            $dataObjectTableau[69],
            $dataObjectTableau[70],
            $dataObjectTableau[71],
            $dataObjectTableau[72],
            $dataObjectTableau[73],
            $dataObjectTableau[74],
            $dataObjectTableau[75],
            $dataObjectTableau[76],
            $dataObjectTableau[77],
            $dataObjectTableau[78],
            $dataObjectTableau[79],
            $dataObjectTableau[80],
            $dataObjectTableau[81]
        );


    }

    public function callProcedure($stage): bool
    {
        $sql = 'CALL insertionPstage(:codeUFRTag, :libelleUFRTag, :codeEtapeTag, :libelleEtapeTag);';
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("codeUFRTag" => $stage->getCodeUFR(), "libelleUFRTag" => $stage->getLibelleUFR(), "codeEtapeTag" => $stage->getCodeEtape(), "libelleEtapeTag" => $stage->getLibelleEtape());
        $pdoStatement->execute($values);
        if ($pdoStatement->fetch()) {
            return true;
        } else {
            return false;
        }
    }

    public function exportCSV(): array
    {
        $sql = "SELECT etu.numEtudiant, prenomEtudiant, nomEtudiant, sexeEtu, mailUniversitaire, mailPerso, telephone, groupe, parcours,nomOffre, dateDebut, dateFin ,sujet, gratification, dureeHeure, typeOffre, etat, entr.numSiret, nomEntreprise, statutJuridique, effectif, codeNAF, tel, vEntr.nomVille, vEntr.codePostal
        FROM Etudiants etu LEFT JOIN Postuler r ON r.numEtudiant = etu.numEtudiant LEFT JOIN Formations offr ON offr.idFormation = r.idFormation LEFT JOIN Entreprises entr ON entr.numSiret = offr.idEntreprise LEFT JOIN Villes vEntr ON vEntr.idVille = entr.idVille";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $pdoStatement->setFetchMode(\PDO::FETCH_NUM);
        $listeObjet = array();
        foreach ($pdoStatement as $item) {
            //echo '<pre>'; print_r($item); echo '</pre>';

            $listeObjet[] = $item;
        }
        return $listeObjet;

    }
}
