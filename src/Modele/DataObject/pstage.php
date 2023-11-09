<?php
namespace App\FormatIUT\Modele\DataObject;

use DateTime;


class pstage extends AbstractDataObject
{
    private int $numeroConvention;
    private int $numeroEtudiant;
    private string $nomEtudiant;
    private string $prenomEtudiant;
    private string $telPersoEtu;
    private string $telPortEtu;
    private string $mailPersoEtu;
    private string $mailUnivEtu;
    private string $codeUFR;
    private string $libelleUFR;
    private string $codeDepartement;
    private string $codeEtape;
    private string $libelleEtape;
    private string $dateDebutStage;
    private string $dateFinStage;
    private bool $interruption;
    private string $dateDebutInterruption;
    private string $dateFinInterruption;
    private string $thematique;
    private string $sujet;
    private string $fonctionTache;
    private string $detailProjet;
    private string $dureeStage;
    private int $nbJoursTravail;
    private float $nbHeuresHebdo;
    private float $gratification;
    private string $uniteGratification;
    private string $uniteDureeGratification;
    private bool $conventionValidee;
    private string $nomEnseignantReferent;
    private string $prenomEnseignantReferent;
    private string $mailEnseignantReferent;
    private string $nomSignataire;
    private string $prenomSignataire;
    private string $mailSignataire;
    private string $fonctionSignataire;
    private string $anneeUniversitaire;
    private string $typeConvention;
    private string $commentaireStage;
    private string $commentaireDureeTravail;
    private string $codeELP;
    private string $elementPedagogique;
    private string $codeSexeEtu;
    private string $avantagesNature;
    private string $adresseEtu;
    private int $codePostalEtu;
    private string $paysEtu;
    private string $villeEtu;
    private bool $conventionValideePedagogiquement;
    private bool $avenantConvention;
    private string $detailsAvenant;
    private string $dateCreationConvention;
    private string $modificationConvention;
    private string $origineStage;
    private string $nomEtablissement;
    private int $siret;
    private string $adresseResidence;
    private string $adresseVoie;
    private string $adresseLibCedex;
    private int $codePostal;
    private string $etablissementCommune;
    private string $pays;
    private string $statutJuridique;
    private string $typeStructure;
    private string $effectif;
    private string $codeNAF;
    private string $tel;
    private string $fax;
    private string $mail;
    private string $siteWeb;
    private string $nomServiceAccueil;
    private string $residenceServiceAccueil;
    private string $voieServiceAccueil;
    private string $cedexServiceAccueil;
    private int $postalServiceAccueil;
    private string $communeServiceAccueil;
    private string $paysServiceAccueil;
    private string $nomTuteurProfessionnel;
    private string $prenomTuteurProfessionnel;
    private string $mailTuteurProfessionnel;
    private string $telTuteurProfessionnel;
    private string $fonctionTuteurProfessionnel;

    /**
     * @param int $numeroConvention
     * @param int $numeroEtudiant
     * @param string $nomEtudiant
     * @param string $prenomEtudiant
     * @param string $telPersoEtu
     * @param string $telPortEtu
     * @param string $mailPersoEtu
     * @param string $mailUnivEtu
     * @param int $codeUFR
     * @param string $libelleUFR
     * @param string $codeDepartement
     * @param string $codeEtape
     * @param string $libelleEtape
     * @param string $dateDebutStage
     * @param string $dateFinStage
     * @param bool $interruption
     * @param string $dateDebutInterruption
     * @param string $dateFinInterruption
     * @param string $thematique
     * @param string $sujet
     * @param string $fonctionTache
     * @param string $detailProjet
     * @param int $dureeStage
     * @param int $nbJoursTravail
     * @param float $nbHeuresHebdo
     * @param float $gratification
     * @param string $uniteGratification
     * @param string $uniteDureeGratification
     * @param bool $conventionValidee
     * @param string $nomEnseignantReferent
     * @param string $prenomEnseignantReferent
     * @param string $mailEnseignantReferent
     * @param string $nomSignataire
     * @param string $prenomSignataire
     * @param string $mailSignataire
     * @param string $fonctionSignataire
     * @param string $anneeUniversitaire
     * @param string $typeConvention
     * @param string $commentaireStage
     * @param string $commentaireDureeTravail
     * @param string $codeELP
     * @param string $elementPedagogique
     * @param string $codeSexeEtu
     * @param string $avantagesNature
     * @param string $adresseEtu
     * @param int $codePostalEtu
     * @param string $paysEtu
     * @param string $villeEtu
     * @param bool $conventionValideePedagogiquement
     * @param bool $avenantConvention
     * @param string $detailsAvenant
     * @param string $dateCreationConvention
     * @param string $modificationConvention
     * @param string $origineStage
     * @param string $nomEtablissement
     * @param int $siret
     * @param string $adresseResidence
     * @param string $adresseVoie
     * @param string $adresseLibCedex
     * @param int $codePostal
     * @param string $etablissementCommune
     * @param string $pays
     * @param string $statutJuridique
     * @param string $typeStructure
     * @param int $effectif
     * @param string $codeNAF
     * @param string $tel
     * @param string $fax
     * @param string $mail
     * @param string $siteWeb
     * @param string $nomServiceAccueil
     * @param string $residenceServiceAccueil
     * @param string $voieServiceAccueil
     * @param string $cedexServiceAccueil
     * @param int $postalServiceAccueil
     * @param string $communeServiceAccueil
     * @param string $paysServiceAccueil
     * @param string $nomTuteurProfessionnel
     * @param string $prenomTuteurProfessionnel
     * @param string $mailTuteurProfessionnel
     * @param string $telTuteurProfessionnel
     * @param string $fonctionTuteurProfessionnel
     */
    public function __construct(int $numeroConvention, int $numeroEtudiant, string $nomEtudiant, string $prenomEtudiant, string $telPersoEtu, string $telPortEtu, string $mailPersoEtu, string $mailUnivEtu, string $codeUFR, string $libelleUFR, string $codeDepartement, string $codeEtape, string $libelleEtape, string $dateDebutStage, string $dateFinStage, bool $interruption, string $dateDebutInterruption, string $dateFinInterruption, string $thematique, string $sujet, string $fonctionTache, string $detailProjet, string $dureeStage, int $nbJoursTravail, float $nbHeuresHebdo, float $gratification, string $uniteGratification, string $uniteDureeGratification, bool $conventionValidee, string $nomEnseignantReferent, string $prenomEnseignantReferent, string $mailEnseignantReferent, string $nomSignataire, string $prenomSignataire, string $mailSignataire, string $fonctionSignataire, string $anneeUniversitaire, string $typeConvention, string $commentaireStage, string $commentaireDureeTravail, string $codeELP, string $elementPedagogique, string $codeSexeEtu, string $avantagesNature, string $adresseEtu, int $codePostalEtu, string $paysEtu, string $villeEtu, bool $conventionValideePedagogiquement, bool $avenantConvention, string $detailsAvenant, string $dateCreationConvention, string $modificationConvention, string $origineStage, string $nomEtablissement, int $siret, string $adresseResidence, string $adresseVoie, string $adresseLibCedex, int $codePostal, string $etablissementCommune, string $pays, string $statutJuridique, string $typeStructure, string $effectif, string $codeNAF, string $tel, string $fax, string $mail, string $siteWeb, string $nomServiceAccueil, string $residenceServiceAccueil, string $voieServiceAccueil, string $cedexServiceAccueil, int $postalServiceAccueil, string $communeServiceAccueil, string $paysServiceAccueil, string $nomTuteurProfessionnel, string $prenomTuteurProfessionnel, string $mailTuteurProfessionnel, string $telTuteurProfessionnel, string $fonctionTuteurProfessionnel)
    {
        $this->numeroConvention = $numeroConvention;
        $this->numeroEtudiant = $numeroEtudiant;
        $this->nomEtudiant = $nomEtudiant;
        $this->prenomEtudiant = $prenomEtudiant;
        $this->telPersoEtu = $telPersoEtu;
        $this->telPortEtu = $telPortEtu;
        $this->mailPersoEtu = $mailPersoEtu;
        $this->mailUnivEtu = $mailUnivEtu;
        $this->codeUFR = $codeUFR;
        $this->libelleUFR = $libelleUFR;
        $this->codeDepartement = $codeDepartement;
        $this->codeEtape = $codeEtape;
        $this->libelleEtape = $libelleEtape;
        $this->dateDebutStage = $dateDebutStage;
        $this->dateFinStage = $dateFinStage;
        $this->interruption = $interruption;
        $this->dateDebutInterruption = $dateDebutInterruption;
        $this->dateFinInterruption = $dateFinInterruption;
        $this->thematique = $thematique;
        $this->sujet = $sujet;
        $this->fonctionTache = $fonctionTache;
        $this->detailProjet = $detailProjet;
        $this->dureeStage = $dureeStage;
        $this->nbJoursTravail = $nbJoursTravail;
        $this->nbHeuresHebdo = $nbHeuresHebdo;
        $this->gratification = $gratification;
        $this->uniteGratification = $uniteGratification;
        $this->uniteDureeGratification = $uniteDureeGratification;
        $this->conventionValidee = $conventionValidee;
        $this->nomEnseignantReferent = $nomEnseignantReferent;
        $this->prenomEnseignantReferent = $prenomEnseignantReferent;
        $this->mailEnseignantReferent = $mailEnseignantReferent;
        $this->nomSignataire = $nomSignataire;
        $this->prenomSignataire = $prenomSignataire;
        $this->mailSignataire = $mailSignataire;
        $this->fonctionSignataire = $fonctionSignataire;
        $this->anneeUniversitaire = $anneeUniversitaire;
        $this->typeConvention = $typeConvention;
        $this->commentaireStage = $commentaireStage;
        $this->commentaireDureeTravail = $commentaireDureeTravail;
        $this->codeELP = $codeELP;
        $this->elementPedagogique = $elementPedagogique;
        $this->codeSexeEtu = $codeSexeEtu;
        $this->avantagesNature = $avantagesNature;
        $this->adresseEtu = $adresseEtu;
        $this->codePostalEtu = $codePostalEtu;
        $this->paysEtu = $paysEtu;
        $this->villeEtu = $villeEtu;
        $this->conventionValideePedagogiquement = $conventionValideePedagogiquement;
        $this->avenantConvention = $avenantConvention;
        $this->detailsAvenant = $detailsAvenant;
        $this->dateCreationConvention = $dateCreationConvention;
        $this->modificationConvention = $modificationConvention;
        $this->origineStage = $origineStage;
        $this->nomEtablissement = $nomEtablissement;
        $this->siret = $siret;
        $this->adresseResidence = $adresseResidence;
        $this->adresseVoie = $adresseVoie;
        $this->adresseLibCedex = $adresseLibCedex;
        $this->codePostal = $codePostal;
        $this->etablissementCommune = $etablissementCommune;
        $this->pays = $pays;
        $this->statutJuridique = $statutJuridique;
        $this->typeStructure = $typeStructure;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;
        $this->fax = $fax;
        $this->mail = $mail;
        $this->siteWeb = $siteWeb;
        $this->nomServiceAccueil = $nomServiceAccueil;
        $this->residenceServiceAccueil = $residenceServiceAccueil;
        $this->voieServiceAccueil = $voieServiceAccueil;
        $this->cedexServiceAccueil = $cedexServiceAccueil;
        $this->postalServiceAccueil = $postalServiceAccueil;
        $this->communeServiceAccueil = $communeServiceAccueil;
        $this->paysServiceAccueil = $paysServiceAccueil;
        $this->nomTuteurProfessionnel = $nomTuteurProfessionnel;
        $this->prenomTuteurProfessionnel = $prenomTuteurProfessionnel;
        $this->mailTuteurProfessionnel = $mailTuteurProfessionnel;
        $this->telTuteurProfessionnel = $telTuteurProfessionnel;
        $this->fonctionTuteurProfessionnel = $fonctionTuteurProfessionnel;
    }



    public function formatTableau(): array
    {
        $interruption = $this->interruption ? 1 : 0;
        $conventionValidee = $this->conventionValidee ? 1 : 0;
        $conventionValideePedagogiquement = $this->conventionValideePedagogiquement ? 1 : 0;
        $avenantConvention = $this->avenantConvention ? 1 : 0;

        return array(
            "numeroConvention" => $this->numeroConvention,
            "numeroEtudiant" => $this->numeroEtudiant,
            "nomEtudiant" => $this->nomEtudiant,
            "prenomEtudiant" => $this->prenomEtudiant,
            "telPersoEtu" => $this->telPersoEtu,
            "telPortEtu" => $this->telPortEtu,
            "mailPersoEtu" => $this->mailPersoEtu,
            "mailUnivEtu" => $this->mailUnivEtu,
            "codeUFR" => $this->codeUFR,
            "libelleUFR" => $this->libelleUFR,
            "codeDepartement" => $this->codeDepartement,
            "codeEtape" => $this->codeEtape,
            "libelleEtape" => $this->libelleEtape,
            "dateDebutStage" => $this->dateDebutStage,
            "dateFinStage" => $this->dateFinStage,
            "interruption" => $interruption,
            "dateDebutInterruption" => $this->dateDebutInterruption,
            "dateFinInterruption" => $this->dateFinInterruption,
            "thematique" => $this->thematique,
            "sujet" => $this->sujet,
            "fonctionTache" => $this->fonctionTache,
            "detailProjet" => $this->detailProjet,
            "dureeStage" => $this->dureeStage,
            "nbJoursTravail" => $this->nbJoursTravail,
            "nbHeuresHebdo" => $this->nbHeuresHebdo,
            "gratification" => $this->gratification,
            "uniteGratification" => $this->uniteGratification,
            "uniteDureeGratification" => $this->uniteDureeGratification,
            "conventionValidee" => $conventionValidee,
            "nomEnseignantReferent" => $this->nomEnseignantReferent,
            "prenomEnseignantReferent" => $this->prenomEnseignantReferent,
            "mailEnseignantReferent" => $this->mailEnseignantReferent,
            "nomSignataire" => $this->nomSignataire,
            "prenomSignataire" => $this->prenomSignataire,
            "mailSignataire" => $this->mailSignataire,
            "fonctionSignataire" => $this->fonctionSignataire,
            "anneeUniversitaire" => $this->anneeUniversitaire,
            "typeConvention" => $this->typeConvention,
            "commentaireStage" => $this->commentaireStage,
            "commentaireDureeTravail" => $this->commentaireDureeTravail,
            "codeELP" => $this->codeELP,
            "elementPedagogique" => $this->elementPedagogique,
            "codeSexeEtu" => $this->codeSexeEtu,
            "avantagesNature" => $this->avantagesNature,
            "adresseEtu" => $this->adresseEtu,
            "codePostalEtu" => $this->codePostalEtu,
            "paysEtu" => $this->paysEtu,
            "villeEtu" => $this->villeEtu,
            "conventionValideePedagogiquement" => $conventionValideePedagogiquement,
            "avenantConvention" => $avenantConvention,
            "detailsAvenant" => $this->detailsAvenant,
            "dateCreationConvention" => $this->dateCreationConvention,
            "modificationConvention" => $this->modificationConvention,
            "origineStage" => $this->origineStage,
            "nomEtablissement" => $this->nomEtablissement,
            "siret" => $this->siret,
            "adresseResidence" => $this->adresseResidence,
            "adresseVoie" => $this->adresseVoie,
            "adresseLibCedex" => $this->adresseLibCedex,
            "codePostal" => $this->codePostal,
            "etablissementCommune" => $this->etablissementCommune,
            "pays" => $this->pays,
            "statutJuridique" => $this->statutJuridique,
            "typeStructure" => $this->typeStructure,
            "effectif" => $this->effectif,
            "codeNAF" => $this->codeNAF,
            "tel" => $this->tel,
            "fax" => $this->fax,
            "mail" => $this->mail,
            "siteWeb" => $this->siteWeb,
            "nomServiceAccueil" => $this->nomServiceAccueil,
            "residenceServiceAccueil" => $this->residenceServiceAccueil,
            "voieServiceAccueil"=> $this->voieServiceAccueil,
            "cedexServiceAccueil" => $this->cedexServiceAccueil,
            "postalServiceAccueil" => $this->postalServiceAccueil,
            "communeServiceAccueil" => $this->communeServiceAccueil,
            "paysServiceAccueil" => $this->paysServiceAccueil,
            "nomTuteurProfessionnel" => $this->nomTuteurProfessionnel,
            "prenomTuteurProfessionnel" => $this->prenomTuteurProfessionnel,
            "mailTuteurProfessionnel" => $this->mailTuteurProfessionnel,
            "telTuteurProfessionnel" => $this->telTuteurProfessionnel,
            "fonctionTuteurProfessionnel" => $this->fonctionTuteurProfessionnel);
    }

}

/*ALTER TABLE pstage
ADD numeroConvention INT,
ADD numeroEtudiant INT,
ADD nomEtudiant VARCHAR(255),
ADD prenomEtudiant VARCHAR(255),
ADD telPersoEtu VARCHAR(255),
ADD telPortEtu VARCHAR(255),
ADD mailPersoEtu VARCHAR(255),
ADD mailUnivEtu VARCHAR(255),
ADD codeUFR INT,
ADD libelleUFR VARCHAR(255),
ADD codeDepartement VARCHAR(255),
ADD dateDebutStage DATE,
ADD dateFinStage DATE,
ADD interruption tinyint,
ADD dateDebutInterruption DATE,
ADD dateFinInterruption DATE,
ADD thematique VARCHAR(255),
ADD sujet VARCHAR(255),
ADD fonctionTache VARCHAR(255),
ADD detailProjet VARCHAR(255),
ADD dureeStage INT,
ADD nbJoursTravail INT,
ADD nbHeuresHebdo FLOAT,
ADD gratification FLOAT,
ADD uniteGratification VARCHAR(255),
ADD uniteDureeGratification VARCHAR(255),
ADD conventionValidee tinyint,
ADD nomEnseignantReferent VARCHAR(255),
ADD prenomEnseignantReferent VARCHAR(255),
ADD mailEnseignantReferent VARCHAR(255),
ADD nomSignataire VARCHAR(255),
ADD prenomSignataire VARCHAR(255),
ADD mailSignataire VARCHAR(255),
ADD fonctionSignataire VARCHAR(255),
ADD anneeUniversitaire VARCHAR(255),
ADD typeConvention VARCHAR(255),
ADD commentaireStage VARCHAR(255),
ADD commentaireDureeTravail VARCHAR(255),
ADD codeELP VARCHAR(255),
ADD elementPedagogique VARCHAR(255),
ADD codeSexeEtu VARCHAR(255),
ADD avantagesNature VARCHAR(255),
ADD adresseEtu VARCHAR(255),
ADD codePostalEtu INT,
ADD paysEtu VARCHAR(255),
ADD villeEtu VARCHAR(255),
ADD conventionValideePedagogiquement tinyint,
ADD avenantConvention tinyint,
ADD detailsAvenant VARCHAR(255),
ADD dateCreationConvention DATE,
ADD modificationConvention DATE,
ADD origineStage VARCHAR(255),
ADD nomEtablissement VARCHAR(255),
ADD siret INT,
ADD adresseResidence VARCHAR(255),
ADD adresseVoie VARCHAR(255),
ADD adresseLibCedex VARCHAR(255),
ADD codePostal INT,
ADD etablissementCommune VARCHAR(255),
ADD pays VARCHAR(255),
ADD statutJuridique VARCHAR(255),
ADD typeStructure VARCHAR(255),
ADD effectif INT,
ADD codeNAF VARCHAR(255),
ADD tel VARCHAR(255),
ADD fax VARCHAR(255),
ADD mail VARCHAR(255),
ADD siteWeb VARCHAR(255),
ADD nomServiceAccueil VARCHAR(255),
ADD residenceServiceAccueil VARCHAR(255),
ADD cedexServiceAccueil VARCHAR(255),
ADD postalServiceAccueil INT,
ADD communeServiceAccueil VARCHAR(255),
ADD paysServiceAccueil VARCHAR(255),
ADD nomTuteurProfessionnel VARCHAR(255),
ADD prenomTuteurProfessionnel VARCHAR(255),
ADD mailTuteurProfessionnel VARCHAR(255),
ADD telTuteurProfessionnel VARCHAR(255),
ADD fonctionTuteurProfessionnel VARCHAR(255);*/




