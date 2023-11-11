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

    public function getNumeroConvention(): int
    {
        return $this->numeroConvention;
    }

    public function getNumeroEtudiant(): int
    {
        return $this->numeroEtudiant;
    }

    public function getNomEtudiant(): string
    {
        return $this->nomEtudiant;
    }

    public function getPrenomEtudiant(): string
    {
        return $this->prenomEtudiant;
    }

    public function getTelPersoEtu(): string
    {
        return $this->telPersoEtu;
    }

    public function getTelPortEtu(): string
    {
        return $this->telPortEtu;
    }

    public function getMailPersoEtu(): string
    {
        return $this->mailPersoEtu;
    }

    public function getMailUnivEtu(): string
    {
        return $this->mailUnivEtu;
    }

    public function getCodeUFR(): string
    {
        return $this->codeUFR;
    }

    public function getLibelleUFR(): string
    {
        return $this->libelleUFR;
    }

    public function getCodeDepartement(): string
    {
        return $this->codeDepartement;
    }

    public function getCodeEtape(): string
    {
        return $this->codeEtape;
    }

    public function getLibelleEtape(): string
    {
        return $this->libelleEtape;
    }

    public function getDateDebutStage(): string
    {
        return $this->dateDebutStage;
    }

    public function getDateFinStage(): string
    {
        return $this->dateFinStage;
    }

    public function isInterruption(): bool
    {
        return $this->interruption;
    }

    public function getDateDebutInterruption(): string
    {
        return $this->dateDebutInterruption;
    }

    public function getDateFinInterruption(): string
    {
        return $this->dateFinInterruption;
    }

    public function getThematique(): string
    {
        return $this->thematique;
    }

    public function getSujet(): string
    {
        return $this->sujet;
    }

    public function getFonctionTache(): string
    {
        return $this->fonctionTache;
    }

    public function getDetailProjet(): string
    {
        return $this->detailProjet;
    }

    public function getDureeStage(): string
    {
        return $this->dureeStage;
    }

    public function getNbJoursTravail(): int
    {
        return $this->nbJoursTravail;
    }

    public function getNbHeuresHebdo(): float
    {
        return $this->nbHeuresHebdo;
    }

    public function getGratification(): float
    {
        return $this->gratification;
    }

    public function getUniteGratification(): string
    {
        return $this->uniteGratification;
    }

    public function getUniteDureeGratification(): string
    {
        return $this->uniteDureeGratification;
    }

    public function isConventionValidee(): bool
    {
        return $this->conventionValidee;
    }

    public function getNomEnseignantReferent(): string
    {
        return $this->nomEnseignantReferent;
    }

    public function getPrenomEnseignantReferent(): string
    {
        return $this->prenomEnseignantReferent;
    }

    public function getMailEnseignantReferent(): string
    {
        return $this->mailEnseignantReferent;
    }

    public function getNomSignataire(): string
    {
        return $this->nomSignataire;
    }

    public function getPrenomSignataire(): string
    {
        return $this->prenomSignataire;
    }

    public function getMailSignataire(): string
    {
        return $this->mailSignataire;
    }

    public function getFonctionSignataire(): string
    {
        return $this->fonctionSignataire;
    }

    public function getAnneeUniversitaire(): string
    {
        return $this->anneeUniversitaire;
    }

    public function getTypeConvention(): string
    {
        return $this->typeConvention;
    }

    public function getCommentaireStage(): string
    {
        return $this->commentaireStage;
    }

    public function getCommentaireDureeTravail(): string
    {
        return $this->commentaireDureeTravail;
    }

    public function getCodeELP(): string
    {
        return $this->codeELP;
    }

    public function getElementPedagogique(): string
    {
        return $this->elementPedagogique;
    }

    public function getCodeSexeEtu(): string
    {
        return $this->codeSexeEtu;
    }

    public function getAvantagesNature(): string
    {
        return $this->avantagesNature;
    }

    public function getAdresseEtu(): string
    {
        return $this->adresseEtu;
    }

    public function getCodePostalEtu(): int
    {
        return $this->codePostalEtu;
    }

    public function getPaysEtu(): string
    {
        return $this->paysEtu;
    }

    public function getVilleEtu(): string
    {
        return $this->villeEtu;
    }

    public function isConventionValideePedagogiquement(): bool
    {
        return $this->conventionValideePedagogiquement;
    }

    public function isAvenantConvention(): bool
    {
        return $this->avenantConvention;
    }

    public function getDetailsAvenant(): string
    {
        return $this->detailsAvenant;
    }

    public function getDateCreationConvention(): string
    {
        return $this->dateCreationConvention;
    }

    public function getModificationConvention(): string
    {
        return $this->modificationConvention;
    }

    public function getOrigineStage(): string
    {
        return $this->origineStage;
    }

    public function getNomEtablissement(): string
    {
        return $this->nomEtablissement;
    }

    public function getSiret(): int
    {
        return $this->siret;
    }

    public function getAdresseResidence(): string
    {
        return $this->adresseResidence;
    }

    public function getAdresseVoie(): string
    {
        return $this->adresseVoie;
    }

    public function getAdresseLibCedex(): string
    {
        return $this->adresseLibCedex;
    }

    public function getCodePostal(): int
    {
        return $this->codePostal;
    }

    public function getEtablissementCommune(): string
    {
        return $this->etablissementCommune;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function getStatutJuridique(): string
    {
        return $this->statutJuridique;
    }

    public function getTypeStructure(): string
    {
        return $this->typeStructure;
    }

    public function getEffectif(): string
    {
        return $this->effectif;
    }

    public function getCodeNAF(): string
    {
        return $this->codeNAF;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function getFax(): string
    {
        return $this->fax;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function getSiteWeb(): string
    {
        return $this->siteWeb;
    }

    public function getNomServiceAccueil(): string
    {
        return $this->nomServiceAccueil;
    }

    public function getResidenceServiceAccueil(): string
    {
        return $this->residenceServiceAccueil;
    }

    public function getVoieServiceAccueil(): string
    {
        return $this->voieServiceAccueil;
    }

    public function getCedexServiceAccueil(): string
    {
        return $this->cedexServiceAccueil;
    }

    public function getPostalServiceAccueil(): int
    {
        return $this->postalServiceAccueil;
    }

    public function getCommuneServiceAccueil(): string
    {
        return $this->communeServiceAccueil;
    }

    public function getPaysServiceAccueil(): string
    {
        return $this->paysServiceAccueil;
    }

    public function getNomTuteurProfessionnel(): string
    {
        return $this->nomTuteurProfessionnel;
    }

    public function getPrenomTuteurProfessionnel(): string
    {
        return $this->prenomTuteurProfessionnel;
    }

    public function getMailTuteurProfessionnel(): string
    {
        return $this->mailTuteurProfessionnel;
    }

    public function getTelTuteurProfessionnel(): string
    {
        return $this->telTuteurProfessionnel;
    }

    public function getFonctionTuteurProfessionnel(): string
    {
        return $this->fonctionTuteurProfessionnel;
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
