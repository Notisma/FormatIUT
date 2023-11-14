<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\pstage;
use DateTime;

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

    public function construireDepuisTableau(array $DataObjectTableau): pstage
    {

        $interruption = $DataObjectTableau[15] ? true : false;
        $conventionValidee = $DataObjectTableau[28] ? true : false;
        $conventionValideePedagogiquement = $DataObjectTableau[48] ? true : false;
        $avenantConvention = $DataObjectTableau[49] ? true : false;

        return new pstage(
            $DataObjectTableau[0],
            $DataObjectTableau[1],
            $DataObjectTableau[2],
            $DataObjectTableau[3],
            $DataObjectTableau[4],
            $DataObjectTableau[5],
            $DataObjectTableau[6],
            $DataObjectTableau[7],
            $DataObjectTableau[8],
            $DataObjectTableau[9],
            $DataObjectTableau[10],
            $DataObjectTableau[11],
            $DataObjectTableau[12],
            $DataObjectTableau[13],
            $DataObjectTableau[14],
            $interruption,
            $DataObjectTableau[16],
            $DataObjectTableau[17],
            $DataObjectTableau[18],
            $DataObjectTableau[19],
            $DataObjectTableau[20],
            $DataObjectTableau[21],
            $DataObjectTableau[22],
            $DataObjectTableau[23],
            $DataObjectTableau[24],
            $DataObjectTableau[25],
            $DataObjectTableau[26],
            $DataObjectTableau[27],
            $conventionValidee,
            $DataObjectTableau[29],
            $DataObjectTableau[30],
            $DataObjectTableau[31],
            $DataObjectTableau[32],
            $DataObjectTableau[33],
            $DataObjectTableau[34],
            $DataObjectTableau[35],
            $DataObjectTableau[36],
            $DataObjectTableau[37],
            $DataObjectTableau[38],
            $DataObjectTableau[39],
            $DataObjectTableau[40],
            $DataObjectTableau[41],
            $DataObjectTableau[42],
            $DataObjectTableau[43],
            $DataObjectTableau[44],
            $DataObjectTableau[45],
            $DataObjectTableau[46],
            $DataObjectTableau[47],
            $conventionValideePedagogiquement,
            $avenantConvention,
            $DataObjectTableau[50],
            $DataObjectTableau[51],
            $DataObjectTableau[52],
            $DataObjectTableau[53],
            $DataObjectTableau[54],
            $DataObjectTableau[55],
            $DataObjectTableau[56],
            $DataObjectTableau[57],
            $DataObjectTableau[58],
            $DataObjectTableau[59],
            $DataObjectTableau[60],
            $DataObjectTableau[61],
            $DataObjectTableau[62],
            $DataObjectTableau[63],
            $DataObjectTableau[64],
            $DataObjectTableau[65],
            $DataObjectTableau[66],
            $DataObjectTableau[67],
            $DataObjectTableau[68],
            $DataObjectTableau[69],
            $DataObjectTableau[70],
            $DataObjectTableau[71],
            $DataObjectTableau[72],
            $DataObjectTableau[73],
            $DataObjectTableau[74],
            $DataObjectTableau[75],
            $DataObjectTableau[76],
            $DataObjectTableau[77],
            $DataObjectTableau[78],
            $DataObjectTableau[79],
            $DataObjectTableau[80],
            $DataObjectTableau[81]
        );


    }
    public function callProcedure($stage){
        $sql='CALL insertionPstage(:codeUFRTag, :libelleUFRTag, :codeEtapeTag, :libelleEtapeTag);';
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $values = array("codeUFRTag" => $stage->getCodeUFR(), "libelleUFRTag" => $stage->getLibelleUFR(), "codeEtapeTag"=>$stage->getCodeEtape(), "libelleEtapeTag"=>$stage->getLibelleEtape());
        $pdoStatement->execute($values);
        if($pdoStatement->fetch()){
            return true;
        } else{
            return false;
        }
    }

    public function exportCSV(){
        $sql="SELECT etu.numEtudiant, prenomEtudiant, nomEtudiant, sexeEtu, mailUniversitaire, mailPerso, telephone, groupe, parcours, nomOffre, sujet
        FROM Etudiants etu LEFT JOIN regarder r ON r.numEtudiant = etu.numEtudiant LEFT JOIN Offre offr ON offr.idOffre = r.idOffre";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->query($sql);
        $pdoStatement->setFetchMode(\PDO::FETCH_ASSOC);
        foreach ($pdoStatement as $item) {
            $listeObjet[]=$item;

        }
        return $listeObjet;

    }
}