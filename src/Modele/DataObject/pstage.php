<?php
namespace App\FormatIUT\Modele\DataObject;
use http\Message\Body;
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
    private int $codeUFR;
    private string $libelleUFR;
    private string $codeDepartement;
    private DateTime $dateDebutStage;
    private DateTime $dateFinStage;
    private bool $interruption;
    private DateTime $dateDebutInterruption;
    private DateTime $dateFinInterruption;
    private string $thematique;
    private string $sujet;
    private string $fonctionTache;
    private string $detailProjet;
    private int $dureeStage;
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
    private DateTime $dateCreationConvention;
    private DateTime $modificationConvention;
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
    private int $effectif;
    private string $codeNAF;
    private string $tel;
    private string $fax;
    private string $mail;
    private string $siteWeb;
    private string $nomServiceAccueil;
    private string $residenceServiceAccueil;
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
     * @param DateTime $dateDebutStage
     * @param DateTime $dateFinStage
     * @param bool $interruption
     * @param DateTime $dateDebutInterruption
     * @param DateTime $dateFinInterruption
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
     * @param DateTime $dateCreationConvention
     * @param DateTime $modificationConvention
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
    public function __construct(int $numeroConvention, int $numeroEtudiant, string $nomEtudiant, string $prenomEtudiant, string $telPersoEtu, string $telPortEtu, string $mailPersoEtu, string $mailUnivEtu, int $codeUFR, string $libelleUFR, string $codeDepartement, DateTime $dateDebutStage, DateTime $dateFinStage, bool $interruption, DateTime $dateDebutInterruption, DateTime $dateFinInterruption, string $thematique, string $sujet, string $fonctionTache, string $detailProjet, int $dureeStage, int $nbJoursTravail, float $nbHeuresHebdo, float $gratification, string $uniteGratification, string $uniteDureeGratification, bool $conventionValidee, string $nomEnseignantReferent, string $prenomEnseignantReferent, string $mailEnseignantReferent, string $nomSignataire, string $prenomSignataire, string $mailSignataire, string $fonctionSignataire, string $anneeUniversitaire, string $typeConvention, string $commentaireStage, string $commentaireDureeTravail, string $codeELP, string $elementPedagogique, string $codeSexeEtu, string $avantagesNature, string $adresseEtu, int $codePostalEtu, string $paysEtu, string $villeEtu, bool $conventionValideePedagogiquement, bool $avenantConvention, string $detailsAvenant, DateTime $dateCreationConvention, DateTime $modificationConvention, string $origineStage, string $nomEtablissement, int $siret, string $adresseResidence, string $adresseVoie, string $adresseLibCedex, int $codePostal, string $etablissementCommune, string $pays, string $statutJuridique, string $typeStructure, int $effectif, string $codeNAF, string $tel, string $fax, string $mail, string $siteWeb, string $nomServiceAccueil, string $residenceServiceAccueil, string $cedexServiceAccueil, int $postalServiceAccueil, string $communeServiceAccueil, string $paysServiceAccueil, string $nomTuteurProfessionnel, string $prenomTuteurProfessionnel, string $mailTuteurProfessionnel, string $telTuteurProfessionnel, string $fonctionTuteurProfessionnel)
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

    public function setNumeroConvention(int $numeroConvention): void
    {
        $this->numeroConvention = $numeroConvention;
    }

    public function getNumeroEtudiant(): int
    {
        return $this->numeroEtudiant;
    }

    public function setNumeroEtudiant(int $numeroEtudiant): void
    {
        $this->numeroEtudiant = $numeroEtudiant;
    }

    public function getNomEtudiant(): string
    {
        return $this->nomEtudiant;
    }

    public function setNomEtudiant(string $nomEtudiant): void
    {
        $this->nomEtudiant = $nomEtudiant;
    }

    public function getPrenomEtudiant(): string
    {
        return $this->prenomEtudiant;
    }

    public function setPrenomEtudiant(string $prenomEtudiant): void
    {
        $this->prenomEtudiant = $prenomEtudiant;
    }

    public function getTelPersoEtu(): string
    {
        return $this->telPersoEtu;
    }

    public function setTelPersoEtu(string $telPersoEtu): void
    {
        $this->telPersoEtu = $telPersoEtu;
    }

    public function getTelPortEtu(): string
    {
        return $this->telPortEtu;
    }

    public function setTelPortEtu(string $telPortEtu): void
    {
        $this->telPortEtu = $telPortEtu;
    }

    public function getMailPersoEtu(): string
    {
        return $this->mailPersoEtu;
    }

    public function setMailPersoEtu(string $mailPersoEtu): void
    {
        $this->mailPersoEtu = $mailPersoEtu;
    }

    public function getMailUnivEtu(): string
    {
        return $this->mailUnivEtu;
    }

    public function setMailUnivEtu(string $mailUnivEtu): void
    {
        $this->mailUnivEtu = $mailUnivEtu;
    }

    public function getCodeUFR(): int
    {
        return $this->codeUFR;
    }

    public function setCodeUFR(int $codeUFR): void
    {
        $this->codeUFR = $codeUFR;
    }

    public function getLibelleUFR(): string
    {
        return $this->libelleUFR;
    }

    public function setLibelleUFR(string $libelleUFR): void
    {
        $this->libelleUFR = $libelleUFR;
    }

    public function getCodeDepartement(): string
    {
        return $this->codeDepartement;
    }

    public function setCodeDepartement(string $codeDepartement): void
    {
        $this->codeDepartement = $codeDepartement;
    }

    public function getDateDebutStage(): DateTime
    {
        return $this->dateDebutStage;
    }

    public function setDateDebutStage(DateTime $dateDebutStage): void
    {
        $this->dateDebutStage = $dateDebutStage;
    }

    public function getDateFinStage(): DateTime
    {
        return $this->dateFinStage;
    }

    public function setDateFinStage(DateTime $dateFinStage): void
    {
        $this->dateFinStage = $dateFinStage;
    }

    public function isInterruption(): bool
    {
        return $this->interruption;
    }

    public function setInterruption(bool $interruption): void
    {
        $this->interruption = $interruption;
    }

    public function getDateDebutInterruption(): DateTime
    {
        return $this->dateDebutInterruption;
    }

    public function setDateDebutInterruption(DateTime $dateDebutInterruption): void
    {
        $this->dateDebutInterruption = $dateDebutInterruption;
    }

    public function getDateFinInterruption(): DateTime
    {
        return $this->dateFinInterruption;
    }

    public function setDateFinInterruption(DateTime $dateFinInterruption): void
    {
        $this->dateFinInterruption = $dateFinInterruption;
    }

    public function getThematique(): string
    {
        return $this->thematique;
    }

    public function setThematique(string $thematique): void
    {
        $this->thematique = $thematique;
    }

    public function getSujet(): string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): void
    {
        $this->sujet = $sujet;
    }

    public function getFonctionTache(): string
    {
        return $this->fonctionTache;
    }

    public function setFonctionTache(string $fonctionTache): void
    {
        $this->fonctionTache = $fonctionTache;
    }

    public function getDetailProjet(): string
    {
        return $this->detailProjet;
    }

    public function setDetailProjet(string $detailProjet): void
    {
        $this->detailProjet = $detailProjet;
    }

    public function getDureeStage(): int
    {
        return $this->dureeStage;
    }

    public function setDureeStage(int $dureeStage): void
    {
        $this->dureeStage = $dureeStage;
    }

    public function getNbJoursTravail(): int
    {
        return $this->nbJoursTravail;
    }

    public function setNbJoursTravail(int $nbJoursTravail): void
    {
        $this->nbJoursTravail = $nbJoursTravail;
    }

    public function getNbHeuresHebdo(): float
    {
        return $this->nbHeuresHebdo;
    }

    public function setNbHeuresHebdo(float $nbHeuresHebdo): void
    {
        $this->nbHeuresHebdo = $nbHeuresHebdo;
    }

    public function getGratification(): float
    {
        return $this->gratification;
    }

    public function setGratification(float $gratification): void
    {
        $this->gratification = $gratification;
    }

    public function getUniteGratification(): string
    {
        return $this->uniteGratification;
    }

    public function setUniteGratification(string $uniteGratification): void
    {
        $this->uniteGratification = $uniteGratification;
    }

    public function getUniteDureeGratification(): string
    {
        return $this->uniteDureeGratification;
    }

    public function setUniteDureeGratification(string $uniteDureeGratification): void
    {
        $this->uniteDureeGratification = $uniteDureeGratification;
    }

    public function isConventionValidee(): bool
    {
        return $this->conventionValidee;
    }

    public function setConventionValidee(bool $conventionValidee): void
    {
        $this->conventionValidee = $conventionValidee;
    }

    public function getNomEnseignantReferent(): string
    {
        return $this->nomEnseignantReferent;
    }

    public function setNomEnseignantReferent(string $nomEnseignantReferent): void
    {
        $this->nomEnseignantReferent = $nomEnseignantReferent;
    }

    public function getPrenomEnseignantReferent(): string
    {
        return $this->prenomEnseignantReferent;
    }

    public function setPrenomEnseignantReferent(string $prenomEnseignantReferent): void
    {
        $this->prenomEnseignantReferent = $prenomEnseignantReferent;
    }

    public function getMailEnseignantReferent(): string
    {
        return $this->mailEnseignantReferent;
    }

    public function setMailEnseignantReferent(string $mailEnseignantReferent): void
    {
        $this->mailEnseignantReferent = $mailEnseignantReferent;
    }

    public function getNomSignataire(): string
    {
        return $this->nomSignataire;
    }

    public function setNomSignataire(string $nomSignataire): void
    {
        $this->nomSignataire = $nomSignataire;
    }

    public function getPrenomSignataire(): string
    {
        return $this->prenomSignataire;
    }

    public function setPrenomSignataire(string $prenomSignataire): void
    {
        $this->prenomSignataire = $prenomSignataire;
    }

    public function getMailSignataire(): string
    {
        return $this->mailSignataire;
    }

    public function setMailSignataire(string $mailSignataire): void
    {
        $this->mailSignataire = $mailSignataire;
    }

    public function getFonctionSignataire(): string
    {
        return $this->fonctionSignataire;
    }

    public function setFonctionSignataire(string $fonctionSignataire): void
    {
        $this->fonctionSignataire = $fonctionSignataire;
    }

    public function getAnneeUniversitaire(): string
    {
        return $this->anneeUniversitaire;
    }

    public function setAnneeUniversitaire(string $anneeUniversitaire): void
    {
        $this->anneeUniversitaire = $anneeUniversitaire;
    }

    public function getTypeConvention(): string
    {
        return $this->typeConvention;
    }

    public function setTypeConvention(string $typeConvention): void
    {
        $this->typeConvention = $typeConvention;
    }

    public function getCommentaireStage(): string
    {
        return $this->commentaireStage;
    }

    public function setCommentaireStage(string $commentaireStage): void
    {
        $this->commentaireStage = $commentaireStage;
    }

    public function getCommentaireDureeTravail(): string
    {
        return $this->commentaireDureeTravail;
    }

    public function setCommentaireDureeTravail(string $commentaireDureeTravail): void
    {
        $this->commentaireDureeTravail = $commentaireDureeTravail;
    }

    public function getCodeELP(): string
    {
        return $this->codeELP;
    }

    public function setCodeELP(string $codeELP): void
    {
        $this->codeELP = $codeELP;
    }

    public function getElementPedagogique(): string
    {
        return $this->elementPedagogique;
    }

    public function setElementPedagogique(string $elementPedagogique): void
    {
        $this->elementPedagogique = $elementPedagogique;
    }

    public function getCodeSexeEtu(): string
    {
        return $this->codeSexeEtu;
    }

    public function setCodeSexeEtu(string $codeSexeEtu): void
    {
        $this->codeSexeEtu = $codeSexeEtu;
    }

    public function getAvantagesNature(): string
    {
        return $this->avantagesNature;
    }

    public function setAvantagesNature(string $avantagesNature): void
    {
        $this->avantagesNature = $avantagesNature;
    }

    public function getAdresseEtu(): string
    {
        return $this->adresseEtu;
    }

    public function setAdresseEtu(string $adresseEtu): void
    {
        $this->adresseEtu = $adresseEtu;
    }

    public function getCodePostalEtu(): int
    {
        return $this->codePostalEtu;
    }

    public function setCodePostalEtu(int $codePostalEtu): void
    {
        $this->codePostalEtu = $codePostalEtu;
    }

    public function getPaysEtu(): string
    {
        return $this->paysEtu;
    }

    public function setPaysEtu(string $paysEtu): void
    {
        $this->paysEtu = $paysEtu;
    }

    public function getVilleEtu(): string
    {
        return $this->villeEtu;
    }

    public function setVilleEtu(string $villeEtu): void
    {
        $this->villeEtu = $villeEtu;
    }

    public function isConventionValideePedagogiquement(): bool
    {
        return $this->conventionValideePedagogiquement;
    }

    public function setConventionValideePedagogiquement(bool $conventionValideePedagogiquement): void
    {
        $this->conventionValideePedagogiquement = $conventionValideePedagogiquement;
    }

    public function isAvenantConvention(): bool
    {
        return $this->avenantConvention;
    }

    public function setAvenantConvention(bool $avenantConvention): void
    {
        $this->avenantConvention = $avenantConvention;
    }

    public function getDetailsAvenant(): string
    {
        return $this->detailsAvenant;
    }

    public function setDetailsAvenant(string $detailsAvenant): void
    {
        $this->detailsAvenant = $detailsAvenant;
    }

    public function getDateCreationConvention(): DateTime
    {
        return $this->dateCreationConvention;
    }

    public function setDateCreationConvention(DateTime $dateCreationConvention): void
    {
        $this->dateCreationConvention = $dateCreationConvention;
    }

    public function getModificationConvention(): DateTime
    {
        return $this->modificationConvention;
    }

    public function setModificationConvention(DateTime $modificationConvention): void
    {
        $this->modificationConvention = $modificationConvention;
    }

    public function getOrigineStage(): string
    {
        return $this->origineStage;
    }

    public function setOrigineStage(string $origineStage): void
    {
        $this->origineStage = $origineStage;
    }

    public function getNomEtablissement(): string
    {
        return $this->nomEtablissement;
    }

    public function setNomEtablissement(string $nomEtablissement): void
    {
        $this->nomEtablissement = $nomEtablissement;
    }

    public function getSiret(): int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): void
    {
        $this->siret = $siret;
    }

    public function getAdresseResidence(): string
    {
        return $this->adresseResidence;
    }

    public function setAdresseResidence(string $adresseResidence): void
    {
        $this->adresseResidence = $adresseResidence;
    }

    public function getAdresseVoie(): string
    {
        return $this->adresseVoie;
    }

    public function setAdresseVoie(string $adresseVoie): void
    {
        $this->adresseVoie = $adresseVoie;
    }

    public function getAdresseLibCedex(): string
    {
        return $this->adresseLibCedex;
    }

    public function setAdresseLibCedex(string $adresseLibCedex): void
    {
        $this->adresseLibCedex = $adresseLibCedex;
    }

    public function getCodePostal(): int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): void
    {
        $this->codePostal = $codePostal;
    }

    public function getEtablissementCommune(): string
    {
        return $this->etablissementCommune;
    }

    public function setEtablissementCommune(string $etablissementCommune): void
    {
        $this->etablissementCommune = $etablissementCommune;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function setPays(string $pays): void
    {
        $this->pays = $pays;
    }

    public function getStatutJuridique(): string
    {
        return $this->statutJuridique;
    }

    public function setStatutJuridique(string $statutJuridique): void
    {
        $this->statutJuridique = $statutJuridique;
    }

    public function getTypeStructure(): string
    {
        return $this->typeStructure;
    }

    public function setTypeStructure(string $typeStructure): void
    {
        $this->typeStructure = $typeStructure;
    }

    public function getEffectif(): int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): void
    {
        $this->effectif = $effectif;
    }

    public function getCodeNAF(): string
    {
        return $this->codeNAF;
    }

    public function setCodeNAF(string $codeNAF): void
    {
        $this->codeNAF = $codeNAF;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    public function getFax(): string
    {
        return $this->fax;
    }

    public function setFax(string $fax): void
    {
        $this->fax = $fax;
    }

    public function getMail(): string
    {
        return $this->mail;
    }

    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    public function getSiteWeb(): string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): void
    {
        $this->siteWeb = $siteWeb;
    }

    public function getNomServiceAccueil(): string
    {
        return $this->nomServiceAccueil;
    }

    public function setNomServiceAccueil(string $nomServiceAccueil): void
    {
        $this->nomServiceAccueil = $nomServiceAccueil;
    }

    public function getResidenceServiceAccueil(): string
    {
        return $this->residenceServiceAccueil;
    }

    public function setResidenceServiceAccueil(string $residenceServiceAccueil): void
    {
        $this->residenceServiceAccueil = $residenceServiceAccueil;
    }

    public function getCedexServiceAccueil(): string
    {
        return $this->cedexServiceAccueil;
    }

    public function setCedexServiceAccueil(string $cedexServiceAccueil): void
    {
        $this->cedexServiceAccueil = $cedexServiceAccueil;
    }

    public function getPostalServiceAccueil(): int
    {
        return $this->postalServiceAccueil;
    }

    public function setPostalServiceAccueil(int $postalServiceAccueil): void
    {
        $this->postalServiceAccueil = $postalServiceAccueil;
    }

    public function getCommuneServiceAccueil(): string
    {
        return $this->communeServiceAccueil;
    }

    public function setCommuneServiceAccueil(string $communeServiceAccueil): void
    {
        $this->communeServiceAccueil = $communeServiceAccueil;
    }

    public function getPaysServiceAccueil(): string
    {
        return $this->paysServiceAccueil;
    }

    public function setPaysServiceAccueil(string $paysServiceAccueil): void
    {
        $this->paysServiceAccueil = $paysServiceAccueil;
    }

    public function getNomTuteurProfessionnel(): string
    {
        return $this->nomTuteurProfessionnel;
    }

    public function setNomTuteurProfessionnel(string $nomTuteurProfessionnel): void
    {
        $this->nomTuteurProfessionnel = $nomTuteurProfessionnel;
    }

    public function getPrenomTuteurProfessionnel(): string
    {
        return $this->prenomTuteurProfessionnel;
    }

    public function setPrenomTuteurProfessionnel(string $prenomTuteurProfessionnel): void
    {
        $this->prenomTuteurProfessionnel = $prenomTuteurProfessionnel;
    }

    public function getMailTuteurProfessionnel(): string
    {
        return $this->mailTuteurProfessionnel;
    }

    public function setMailTuteurProfessionnel(string $mailTuteurProfessionnel): void
    {
        $this->mailTuteurProfessionnel = $mailTuteurProfessionnel;
    }

    public function getTelTuteurProfessionnel(): string
    {
        return $this->telTuteurProfessionnel;
    }

    public function setTelTuteurProfessionnel(string $telTuteurProfessionnel): void
    {
        $this->telTuteurProfessionnel = $telTuteurProfessionnel;
    }

    public function getFonctionTuteurProfessionnel(): string
    {
        return $this->fonctionTuteurProfessionnel;
    }

    public function setFonctionTuteurProfessionnel(string $fonctionTuteurProfessionnel): void
    {
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
            "dateDebutStage" => date_format($this->dateDebutStage, 'Y-m-d'),
            "dateFinStage" => date_format($this->dateFinStage, 'Y-m-d'),
            "interruption" => $interruption,
            "dateDebutInterruption" => date_format($this->dateDebutInterruption, 'Y-m-d'),
            "dateFinInterruption" => date_format($this->dateFinInterruption, 'Y-m-d'),
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
            "dateCreationConvention" => date_format($this->dateCreationConvention, 'Y-m-d'),
            "modificationConvention" => date_format($this->modificationConvention, 'Y-m-d'),
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




