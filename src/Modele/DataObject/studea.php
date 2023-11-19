<?php

namespace App\FormatIUT\Modele\DataObject;

class studea extends AbstractDataObject
{

    private string $archivee;
    private string $gereEnDehorsDeStudea;
    private string $statutOPCO;
    private string $id;
    private string $etablissement;
    private string $formation;
    private string $anneeDebut;
    private string $anneeFin;
    private string $genreAlternant;
    private string $nomAlternant;
    private string $prenomAlternant;
    private string $dateSaisieParEntreprise;
    private string $validationPedagogiqueDesMissions;
    private string $ficheEnErreur;
    private string $codeErreur;
    private string $contratEtConventionEnvoyeALEntreprise;
    private string $contratOuConventionSigne;
    private string $dateNaissance;
    private string $communeNaissance;
    private string $paysNaissance;
    private string $nationalite;
    private string $travailleurHandicape;
    private string $titulairePermisDeConduire;
    private string $numeroSecuriteSociale;
    private string $pasDeNumeroDeSecuriteSociale;
    private string $sportifHautNiveau;
    private string $telephone1;
    private string $telephone2;
    private string $email1;
    private string $email2;
    private string $adresse;
    private string $complement;
    private string $codePostal;
    private string $ville;
    private string $genreRepresentantLegal;
    private string $nomRepresentantLegal;
    private string $prenomRepresentantLegal;
    private string $adresse2;
    private string $complement2;
    private string $codePostal2;
    private string $ville2;
    private string $codeINE;
    private string $situationAvantContrat;
    private string $paysDernierDiplomePrepare;
    private string $departementDernierDiplomePrepare;
    private string $etablissementDernierDiplomePrepare;
    private string $UAIEtablissementDernierDiplomePrepare;
    private string $typeDiplome;
    private string $annee;
    private string $intitule;
    private string $obtention;
    private string $derniereAnneeOuClasseSuivie;
    private string $dernierDiplomeObtenu;
    private string $entrepriseTemporaire;
    private string $nomContratTemporaire;
    private string $prenomContratTemporaire;
    private string $mailContratTemporaire;
    private string $telephoneContratTemporaire;
    private string $siret;
    private string $typeEmployeur;
    private string $raisonSociale;
    private string $codeNAF;
    private string $caisseRetraiteComplementaire;
    private string $effectifTotal;
    private string $adresseEntreprise;
    private string $complementAdresse;
    private string $codePostalEntreprise;
    private string $villeEntreprise;
    private string $adresse2Entreprise;
    private string $complementAdresse2;
    private string $codePostal2Entreprise;
    private string $ville2Entreprise;
    private string $genreDirecteur;
    private string $nomDirecteur;
    private string $prenomDirecteur;
    private string $fonctionDirecteur;
    private string $mailDirecteur;
    private string $siretAdministratif;
    private string $typeEmployeurAdministratif;
    private string $raisonSocialeAdministratif;
    private string $codeNAFAdministratif;
    private string $caisseRetraiteComplementaireAdministratif;
    private string $effectifTotalAdministratif;
    private string $adresseAdministratif;
    private string $complementAdresseAdministratif;
    private string $codePostalAdministratif;
    private string $villeAdministratif;
    private string $genreDirecteurAdministratif;
    private string $nomDirecteurAdministratif;
    private string $prenomDirecteurAdministratif;
    private string $fonctionDirecteurAdministratif;
    private string $mailDirecteurAdministratif;
    private string $genreInterlocuteurRH;
    private string $nomInterlocuteurRH;
    private string $prenomInterlocuteurRH;
    private string $fonctionInterlocuteurRH;
    private string $mailInterlocuteurRH;
    private string $OPCO;
    private string $IDCC;
    private string $codeIDCC;
    private string $missionsSaisies;
    private string $fichierJointPourLesMissions;
    private string $mandatCFA;
    private string $typeContrat;
    private string $dateDebutContrat;
    private string $dateFinContrat;
    private string $genreMaitreApprentissage;
    private string $nomMaitreApprentissage;
    private string $prenomMaitreApprentissage;
    private string $fonctionMaitreApprentissage;
    private string $telephoneMaitreApprentissage;
    private string $mailMaitreApprentissage;
    private string $dateNaissanceMaitreApprentissage;
    private bool $aDejaEteMaitreApprentissage;
    private bool $aDejaRecuUneFormationDeMaitreApprentissage;
    private string $genreSecondMaitreApprentissage;
    private string $nomSecondMaitreApprentissage;
    private string $prenomSecondMaitreApprentissage;
    private string $fonctionSecondMaitreApprentissage;
    private string $telephoneSecondMaitreApprentissage;
    private string $mailSecondMaitreApprentissage;
    private string $dateNaissanceSecondMaitreApprentissage;
    private bool $aDejaEteMaitreApprentissage2;
    private bool $aDejaRecuUneFormationDeMaitreApprentissage2;
    private string $responsableFormation;
    private string $validateurDevis;
    private string $dureeContrat;
    private string $coutContrat;
    private string $montantPriseEnChargeNPEC;
    private string $montantResteACharge;
    private string $coutFormationALAnne;
    private string $coutContratAvantNegociation;
    private string $numeroDECA;
    private string $codeDiplome;
    private string $codeRNCP;
    private string $SFP;
    private string $dateEnvoiSFP;
    private string $gestionnaireEnvoi;
    private string $dureeSFP;
    private string $dateDebutFormation;
    private string $dateFinFormation;
    private string $etablissementDocEmployeur;
    private string $dateEtablissementDocEmployeur;

    public function __construct(string $archivee, string $gereEnDehorsDeStudea, string $statutOPCO, string $id, string $etablissement, string $formation, string $anneeDebut, string $anneeFin, string $genreAlternant, string $nomAlternant, string $prenomAlternant, string $dateSaisieParEntreprise, string $validationPedagogiqueDesMissions, string $ficheEnErreur, string $codeErreur, string $contratEtConventionEnvoyeALEntreprise, string $contratOuConventionSigne, string $dateNaissance, string $communeNaissance, string $paysNaissance, string $nationalite, string $travailleurHandicape, string $titulairePermisDeConduire, string $numeroSecuriteSociale, string $pasDeNumeroDeSecuriteSociale, string $sportifHautNiveau, string $telephone1, string $telephone2, string $email1, string $email2, string $adresse, string $complement, string $codePostal, string $ville, string $genreRepresentantLegal, string $nomRepresentantLegal, string $prenomRepresentantLegal, string $adresse2, string $complement2, string $codePostal2, string $ville2, string $codeINE, string $situationAvantContrat, string $paysDernierDiplomePrepare, string $departementDernierDiplomePrepare, string $etablissementDernierDiplomePrepare, string $UAIEtablissementDernierDiplomePrepare, string $typeDiplome, string $annee, string $intitule, string $obtention, string $derniereAnneeOuClasseSuivie, string $dernierDiplomeObtenu, string $entrepriseTemporaire, string $nomContratTemporaire, string $prenomContratTemporaire, string $mailContratTemporaire, string $telephoneContratTemporaire, string $siret, string $typeEmployeur, string $raisonSociale, string $codeNAF, string $caisseRetraiteComplementaire, string $effectifTotal, string $adresseEntreprise, string $complementAdresse, string $codePostalEntreprise, string $villeEntreprise, string $adresse2Entreprise, string $complementAdresse2, string $codePostal2Entreprise, string $ville2Entreprise, string $genreDirecteur, string $nomDirecteur, string $prenomDirecteur, string $fonctionDirecteur, string $mailDirecteur, string $siretAdministratif, string $typeEmployeurAdministratif, string $raisonSocialeAdministratif, string $codeNAFAdministratif, string $caisseRetraiteComplementaireAdministratif, string $effectifTotalAdministratif, string $adresseAdministratif, string $complementAdresseAdministratif, string $codePostalAdministratif, string $villeAdministratif, string $genreDirecteurAdministratif, string $nomDirecteurAdministratif, string $prenomDirecteurAdministratif, string $fonctionDirecteurAdministratif, string $mailDirecteurAdministratif, string $genreInterlocuteurRH, string $nomInterlocuteurRH, string $prenomInterlocuteurRH, string $fonctionInterlocuteurRH, string $mailInterlocuteurRH, string $OPCO, string $IDCC, string $codeIDCC, string $missionsSaisies, string $fichierJointPourLesMissions, string $mandatCFA, string $typeContrat, string $dateDebutContrat, string $dateFinContrat, string $genreMaitreApprentissage, string $nomMaitreApprentissage, string $prenomMaitreApprentissage, string $fonctionMaitreApprentissage, string $telephoneMaitreApprentissage, string $mailMaitreApprentissage, string $dateNaissanceMaitreApprentissage, bool $aDejaEteMaitreApprentissage, bool $aDejaRecuUneFormationDeMaitreApprentissage, string $genreSecondMaitreApprentissage, string $nomSecondMaitreApprentissage, string $prenomSecondMaitreApprentissage, string $fonctionSecondMaitreApprentissage, string $telephoneSecondMaitreApprentissage, string $mailSecondMaitreApprentissage, string $dateNaissanceSecondMaitreApprentissage, bool $aDejaEteMaitreApprentissage2, bool $aDejaRecuUneFormationDeMaitreApprentissage2, string $responsableFormation, string $validateurDevis, string $dureeContrat, string $coutContrat, string $montantPriseEnChargeNPEC, string $montantResteACharge, string $coutFormationALAnne, string $coutContratAvantNegociation, string $numeroDECA, string $codeDiplome, string $codeRNCP, string $SFP, string $dateEnvoiSFP, string $gestionnaireEnvoi, string $dureeSFP, string $dateDebutFormation, string $dateFinFormation, string $etablissementDocEmployeur, string $dateEtablissementDocEmployeur)
    {
        $this->archivee = $archivee;
        $this->gereEnDehorsDeStudea = $gereEnDehorsDeStudea;
        $this->statutOPCO = $statutOPCO;
        $this->id = $id;
        $this->etablissement = $etablissement;
        $this->formation = $formation;
        $this->anneeDebut = $anneeDebut;
        $this->anneeFin = $anneeFin;
        $this->genreAlternant = $genreAlternant;
        $this->nomAlternant = $nomAlternant;
        $this->prenomAlternant = $prenomAlternant;
        $this->dateSaisieParEntreprise = $dateSaisieParEntreprise;
        $this->validationPedagogiqueDesMissions = $validationPedagogiqueDesMissions;
        $this->ficheEnErreur = $ficheEnErreur;
        $this->codeErreur = $codeErreur;
        $this->contratEtConventionEnvoyeALEntreprise = $contratEtConventionEnvoyeALEntreprise;
        $this->contratOuConventionSigne = $contratOuConventionSigne;
        $this->dateNaissance = $dateNaissance;
        $this->communeNaissance = $communeNaissance;
        $this->paysNaissance = $paysNaissance;
        $this->nationalite = $nationalite;
        $this->travailleurHandicape = $travailleurHandicape;
        $this->titulairePermisDeConduire = $titulairePermisDeConduire;
        $this->numeroSecuriteSociale = $numeroSecuriteSociale;
        $this->pasDeNumeroDeSecuriteSociale = $pasDeNumeroDeSecuriteSociale;
        $this->sportifHautNiveau = $sportifHautNiveau;
        $this->telephone1 = $telephone1;
        $this->telephone2 = $telephone2;
        $this->email1 = $email1;
        $this->email2 = $email2;
        $this->adresse = $adresse;
        $this->complement = $complement;
        $this->codePostal = $codePostal;
        $this->ville = $ville;
        $this->genreRepresentantLegal = $genreRepresentantLegal;
        $this->nomRepresentantLegal = $nomRepresentantLegal;
        $this->prenomRepresentantLegal = $prenomRepresentantLegal;
        $this->adresse2 = $adresse2;
        $this->complement2 = $complement2;
        $this->codePostal2 = $codePostal2;
        $this->ville2 = $ville2;
        $this->codeINE = $codeINE;
        $this->situationAvantContrat = $situationAvantContrat;
        $this->paysDernierDiplomePrepare = $paysDernierDiplomePrepare;
        $this->departementDernierDiplomePrepare = $departementDernierDiplomePrepare;
        $this->etablissementDernierDiplomePrepare = $etablissementDernierDiplomePrepare;
        $this->UAIEtablissementDernierDiplomePrepare = $UAIEtablissementDernierDiplomePrepare;
        $this->typeDiplome = $typeDiplome;
        $this->annee = $annee;
        $this->intitule = $intitule;
        $this->obtention = $obtention;
        $this->derniereAnneeOuClasseSuivie = $derniereAnneeOuClasseSuivie;
        $this->dernierDiplomeObtenu = $dernierDiplomeObtenu;
        $this->entrepriseTemporaire = $entrepriseTemporaire;
        $this->nomContratTemporaire = $nomContratTemporaire;
        $this->prenomContratTemporaire = $prenomContratTemporaire;
        $this->mailContratTemporaire = $mailContratTemporaire;
        $this->telephoneContratTemporaire = $telephoneContratTemporaire;
        $this->siret = $siret;
        $this->typeEmployeur = $typeEmployeur;
        $this->raisonSociale = $raisonSociale;
        $this->codeNAF = $codeNAF;
        $this->caisseRetraiteComplementaire = $caisseRetraiteComplementaire;
        $this->effectifTotal = $effectifTotal;
        $this->adresseEntreprise = $adresseEntreprise;
        $this->complementAdresse = $complementAdresse;
        $this->codePostalEntreprise = $codePostalEntreprise;
        $this->villeEntreprise = $villeEntreprise;
        $this->adresse2Entreprise = $adresse2Entreprise;
        $this->complementAdresse2 = $complementAdresse2;
        $this->codePostal2Entreprise = $codePostal2Entreprise;
        $this->ville2Entreprise = $ville2Entreprise;
        $this->genreDirecteur = $genreDirecteur;
        $this->nomDirecteur = $nomDirecteur;
        $this->prenomDirecteur = $prenomDirecteur;
        $this->fonctionDirecteur = $fonctionDirecteur;
        $this->mailDirecteur = $mailDirecteur;
        $this->siretAdministratif = $siretAdministratif;
        $this->typeEmployeurAdministratif = $typeEmployeurAdministratif;
        $this->raisonSocialeAdministratif = $raisonSocialeAdministratif;
        $this->codeNAFAdministratif = $codeNAFAdministratif;
        $this->caisseRetraiteComplementaireAdministratif = $caisseRetraiteComplementaireAdministratif;
        $this->effectifTotalAdministratif = $effectifTotalAdministratif;
        $this->adresseAdministratif = $adresseAdministratif;
        $this->complementAdresseAdministratif = $complementAdresseAdministratif;
        $this->codePostalAdministratif = $codePostalAdministratif;
        $this->villeAdministratif = $villeAdministratif;
        $this->genreDirecteurAdministratif = $genreDirecteurAdministratif;
        $this->nomDirecteurAdministratif = $nomDirecteurAdministratif;
        $this->prenomDirecteurAdministratif = $prenomDirecteurAdministratif;
        $this->fonctionDirecteurAdministratif = $fonctionDirecteurAdministratif;
        $this->mailDirecteurAdministratif = $mailDirecteurAdministratif;
        $this->genreInterlocuteurRH = $genreInterlocuteurRH;
        $this->nomInterlocuteurRH = $nomInterlocuteurRH;
        $this->prenomInterlocuteurRH = $prenomInterlocuteurRH;
        $this->fonctionInterlocuteurRH = $fonctionInterlocuteurRH;
        $this->mailInterlocuteurRH = $mailInterlocuteurRH;
        $this->OPCO = $OPCO;
        $this->IDCC = $IDCC;
        $this->codeIDCC = $codeIDCC;
        $this->missionsSaisies = $missionsSaisies;
        $this->fichierJointPourLesMissions = $fichierJointPourLesMissions;
        $this->mandatCFA = $mandatCFA;
        $this->typeContrat = $typeContrat;
        $this->dateDebutContrat = $dateDebutContrat;
        $this->dateFinContrat = $dateFinContrat;
        $this->genreMaitreApprentissage = $genreMaitreApprentissage;
        $this->nomMaitreApprentissage = $nomMaitreApprentissage;
        $this->prenomMaitreApprentissage = $prenomMaitreApprentissage;
        $this->fonctionMaitreApprentissage = $fonctionMaitreApprentissage;
        $this->telephoneMaitreApprentissage = $telephoneMaitreApprentissage;
        $this->mailMaitreApprentissage = $mailMaitreApprentissage;
        $this->dateNaissanceMaitreApprentissage = $dateNaissanceMaitreApprentissage;
        $this->aDejaEteMaitreApprentissage = $aDejaEteMaitreApprentissage;
        $this->aDejaRecuUneFormationDeMaitreApprentissage = $aDejaRecuUneFormationDeMaitreApprentissage;
        $this->genreSecondMaitreApprentissage = $genreSecondMaitreApprentissage;
        $this->nomSecondMaitreApprentissage = $nomSecondMaitreApprentissage;
        $this->prenomSecondMaitreApprentissage = $prenomSecondMaitreApprentissage;
        $this->fonctionSecondMaitreApprentissage = $fonctionSecondMaitreApprentissage;
        $this->telephoneSecondMaitreApprentissage = $telephoneSecondMaitreApprentissage;
        $this->mailSecondMaitreApprentissage = $mailSecondMaitreApprentissage;
        $this->dateNaissanceSecondMaitreApprentissage = $dateNaissanceSecondMaitreApprentissage;
        $this->aDejaEteMaitreApprentissage2 = $aDejaEteMaitreApprentissage2;
        $this->aDejaRecuUneFormationDeMaitreApprentissage2 = $aDejaRecuUneFormationDeMaitreApprentissage2;
        $this->responsableFormation = $responsableFormation;
        $this->validateurDevis = $validateurDevis;
        $this->dureeContrat = $dureeContrat;
        $this->coutContrat = $coutContrat;
        $this->montantPriseEnChargeNPEC = $montantPriseEnChargeNPEC;
        $this->montantResteACharge = $montantResteACharge;
        $this->coutFormationALAnne = $coutFormationALAnne;
        $this->coutContratAvantNegociation = $coutContratAvantNegociation;
        $this->numeroDECA = $numeroDECA;
        $this->codeDiplome = $codeDiplome;
        $this->codeRNCP = $codeRNCP;
        $this->SFP = $SFP;
        $this->dateEnvoiSFP = $dateEnvoiSFP;
        $this->gestionnaireEnvoi = $gestionnaireEnvoi;
        $this->dureeSFP = $dureeSFP;
        $this->dateDebutFormation = $dateDebutFormation;
        $this->dateFinFormation = $dateFinFormation;
        $this->etablissementDocEmployeur = $etablissementDocEmployeur;
        $this->dateEtablissementDocEmployeur = $dateEtablissementDocEmployeur;
    }

    public function getArchivee(): string
    {
        return $this->archivee;
    }

    public function getGereEnDehorsDeStudea(): string
    {
        return $this->gereEnDehorsDeStudea;
    }

    public function getStatutOPCO(): string
    {
        return $this->statutOPCO;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEtablissement(): string
    {
        return $this->etablissement;
    }

    public function getFormation(): string
    {
        return $this->formation;
    }

    public function getAnneeDebut(): string
    {
        return $this->anneeDebut;
    }

    public function getAnneeFin(): string
    {
        return $this->anneeFin;
    }

    public function getGenreAlternant(): string
    {
        return $this->genreAlternant;
    }

    public function getNomAlternant(): string
    {
        return $this->nomAlternant;
    }

    public function getPrenomAlternant(): string
    {
        return $this->prenomAlternant;
    }

    public function getDateSaisieParEntreprise(): string
    {
        return $this->dateSaisieParEntreprise;
    }

    public function getValidationPedagogiqueDesMissions(): string
    {
        return $this->validationPedagogiqueDesMissions;
    }

    public function getFicheEnErreur(): string
    {
        return $this->ficheEnErreur;
    }

    public function getCodeErreur(): string
    {
        return $this->codeErreur;
    }

    public function getContratEtConventionEnvoyeALEntreprise(): string
    {
        return $this->contratEtConventionEnvoyeALEntreprise;
    }

    public function getContratOuConventionSigne(): string
    {
        return $this->contratOuConventionSigne;
    }

    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    public function getCommuneNaissance(): string
    {
        return $this->communeNaissance;
    }

    public function getPaysNaissance(): string
    {
        return $this->paysNaissance;
    }

    public function getNationalite(): string
    {
        return $this->nationalite;
    }

    public function getTravailleurHandicape(): string
    {
        return $this->travailleurHandicape;
    }

    public function getTitulairePermisDeConduire(): string
    {
        return $this->titulairePermisDeConduire;
    }

    public function getNumeroSecuriteSociale(): string
    {
        return $this->numeroSecuriteSociale;
    }

    public function getPasDeNumeroDeSecuriteSociale(): string
    {
        return $this->pasDeNumeroDeSecuriteSociale;
    }

    public function getSportifHautNiveau(): string
    {
        return $this->sportifHautNiveau;
    }

    public function getTelephone1(): string
    {
        return $this->telephone1;
    }

    public function getTelephone2(): string
    {
        return $this->telephone2;
    }

    public function getEmail1(): string
    {
        return $this->email1;
    }

    public function getEmail2(): string
    {
        return $this->email2;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function getComplement(): string
    {
        return $this->complement;
    }

    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function getGenreRepresentantLegal(): string
    {
        return $this->genreRepresentantLegal;
    }

    public function getNomRepresentantLegal(): string
    {
        return $this->nomRepresentantLegal;
    }

    public function getPrenomRepresentantLegal(): string
    {
        return $this->prenomRepresentantLegal;
    }

    public function getAdresse2(): string
    {
        return $this->adresse2;
    }

    public function getComplement2(): string
    {
        return $this->complement2;
    }

    public function getCodePostal2(): string
    {
        return $this->codePostal2;
    }

    public function getVille2(): string
    {
        return $this->ville2;
    }

    public function getCodeINE(): string
    {
        return $this->codeINE;
    }

    public function getSituationAvantContrat(): string
    {
        return $this->situationAvantContrat;
    }

    public function getPaysDernierDiplomePrepare(): string
    {
        return $this->paysDernierDiplomePrepare;
    }

    public function getDepartementDernierDiplomePrepare(): string
    {
        return $this->departementDernierDiplomePrepare;
    }

    public function getEtablissementDernierDiplomePrepare(): string
    {
        return $this->etablissementDernierDiplomePrepare;
    }

    public function getUAIEtablissementDernierDiplomePrepare(): string
    {
        return $this->UAIEtablissementDernierDiplomePrepare;
    }

    public function getTypeDiplome(): string
    {
        return $this->typeDiplome;
    }

    public function getAnnee(): string
    {
        return $this->annee;
    }

    public function getIntitule(): string
    {
        return $this->intitule;
    }

    public function getObtention(): string
    {
        return $this->obtention;
    }

    public function getDerniereAnneeOuClasseSuivie(): string
    {
        return $this->derniereAnneeOuClasseSuivie;
    }

    public function getDernierDiplomeObtenu(): string
    {
        return $this->dernierDiplomeObtenu;
    }

    public function getEntrepriseTemporaire(): string
    {
        return $this->entrepriseTemporaire;
    }

    public function getNomContratTemporaire(): string
    {
        return $this->nomContratTemporaire;
    }

    public function getPrenomContratTemporaire(): string
    {
        return $this->prenomContratTemporaire;
    }

    public function getMailContratTemporaire(): string
    {
        return $this->mailContratTemporaire;
    }

    public function getTelephoneContratTemporaire(): string
    {
        return $this->telephoneContratTemporaire;
    }

    public function getSiret(): string
    {
        return $this->siret;
    }

    public function getTypeEmployeur(): string
    {
        return $this->typeEmployeur;
    }

    public function getRaisonSociale(): string
    {
        return $this->raisonSociale;
    }

    public function getCodeNAF(): string
    {
        return $this->codeNAF;
    }

    public function getCaisseRetraiteComplementaire(): string
    {
        return $this->caisseRetraiteComplementaire;
    }

    public function getEffectifTotal(): string
    {
        return $this->effectifTotal;
    }

    public function getAdresseEntreprise(): string
    {
        return $this->adresseEntreprise;
    }

    public function getComplementAdresse(): string
    {
        return $this->complementAdresse;
    }

    public function getCodePostalEntreprise(): string
    {
        return $this->codePostalEntreprise;
    }

    public function getVilleEntreprise(): string
    {
        return $this->villeEntreprise;
    }

    public function getAdresse2Entreprise(): string
    {
        return $this->adresse2Entreprise;
    }

    public function getComplementAdresse2(): string
    {
        return $this->complementAdresse2;
    }

    public function getCodePostal2Entreprise(): string
    {
        return $this->codePostal2Entreprise;
    }

    public function getVille2Entreprise(): string
    {
        return $this->ville2Entreprise;
    }

    public function getGenreDirecteur(): string
    {
        return $this->genreDirecteur;
    }

    public function getNomDirecteur(): string
    {
        return $this->nomDirecteur;
    }

    public function getPrenomDirecteur(): string
    {
        return $this->prenomDirecteur;
    }

    public function getFonctionDirecteur(): string
    {
        return $this->fonctionDirecteur;
    }

    public function getMailDirecteur(): string
    {
        return $this->mailDirecteur;
    }

    public function getSiretAdministratif(): string
    {
        return $this->siretAdministratif;
    }

    public function getTypeEmployeurAdministratif(): string
    {
        return $this->typeEmployeurAdministratif;
    }

    public function getRaisonSocialeAdministratif(): string
    {
        return $this->raisonSocialeAdministratif;
    }

    public function getCodeNAFAdministratif(): string
    {
        return $this->codeNAFAdministratif;
    }

    public function getCaisseRetraiteComplementaireAdministratif(): string
    {
        return $this->caisseRetraiteComplementaireAdministratif;
    }

    public function getEffectifTotalAdministratif(): string
    {
        return $this->effectifTotalAdministratif;
    }

    public function getAdresseAdministratif(): string
    {
        return $this->adresseAdministratif;
    }

    public function getComplementAdresseAdministratif(): string
    {
        return $this->complementAdresseAdministratif;
    }

    public function getCodePostalAdministratif(): string
    {
        return $this->codePostalAdministratif;
    }

    public function getVilleAdministratif(): string
    {
        return $this->villeAdministratif;
    }

    public function getGenreDirecteurAdministratif(): string
    {
        return $this->genreDirecteurAdministratif;
    }

    public function getNomDirecteurAdministratif(): string
    {
        return $this->nomDirecteurAdministratif;
    }

    public function getPrenomDirecteurAdministratif(): string
    {
        return $this->prenomDirecteurAdministratif;
    }

    public function getFonctionDirecteurAdministratif(): string
    {
        return $this->fonctionDirecteurAdministratif;
    }

    public function getMailDirecteurAdministratif(): string
    {
        return $this->mailDirecteurAdministratif;
    }

    public function getGenreInterlocuteurRH(): string
    {
        return $this->genreInterlocuteurRH;
    }

    public function getNomInterlocuteurRH(): string
    {
        return $this->nomInterlocuteurRH;
    }

    public function getPrenomInterlocuteurRH(): string
    {
        return $this->prenomInterlocuteurRH;
    }

    public function getFonctionInterlocuteurRH(): string
    {
        return $this->fonctionInterlocuteurRH;
    }

    public function getMailInterlocuteurRH(): string
    {
        return $this->mailInterlocuteurRH;
    }

    public function getOPCO(): string
    {
        return $this->OPCO;
    }

    public function getIDCC(): string
    {
        return $this->IDCC;
    }

    public function getCodeIDCC(): string
    {
        return $this->codeIDCC;
    }

    public function getMissionsSaisies(): string
    {
        return $this->missionsSaisies;
    }

    public function getFichierJointPourLesMissions(): string
    {
        return $this->fichierJointPourLesMissions;
    }

    public function getMandatCFA(): string
    {
        return $this->mandatCFA;
    }

    public function getTypeContrat(): string
    {
        return $this->typeContrat;
    }

    public function getDateDebutContrat(): string
    {
        return $this->dateDebutContrat;
    }

    public function getDateFinContrat(): string
    {
        return $this->dateFinContrat;
    }

    public function getGenreMaitreApprentissage(): string
    {
        return $this->genreMaitreApprentissage;
    }

    public function getNomMaitreApprentissage(): string
    {
        return $this->nomMaitreApprentissage;
    }

    public function getPrenomMaitreApprentissage(): string
    {
        return $this->prenomMaitreApprentissage;
    }

    public function getFonctionMaitreApprentissage(): string
    {
        return $this->fonctionMaitreApprentissage;
    }

    public function getTelephoneMaitreApprentissage(): string
    {
        return $this->telephoneMaitreApprentissage;
    }

    public function getMailMaitreApprentissage(): string
    {
        return $this->mailMaitreApprentissage;
    }

    public function getDateNaissanceMaitreApprentissage(): string
    {
        return $this->dateNaissanceMaitreApprentissage;
    }

    public function isADejaEteMaitreApprentissage(): bool
    {
        return $this->aDejaEteMaitreApprentissage;
    }

    public function isADejaRecuUneFormationDeMaitreApprentissage(): bool
    {
        return $this->aDejaRecuUneFormationDeMaitreApprentissage;
    }

    public function getGenreSecondMaitreApprentissage(): string
    {
        return $this->genreSecondMaitreApprentissage;
    }

    public function getNomSecondMaitreApprentissage(): string
    {
        return $this->nomSecondMaitreApprentissage;
    }

    public function getPrenomSecondMaitreApprentissage(): string
    {
        return $this->prenomSecondMaitreApprentissage;
    }

    public function getFonctionSecondMaitreApprentissage(): string
    {
        return $this->fonctionSecondMaitreApprentissage;
    }

    public function getTelephoneSecondMaitreApprentissage(): string
    {
        return $this->telephoneSecondMaitreApprentissage;
    }

    public function getMailSecondMaitreApprentissage(): string
    {
        return $this->mailSecondMaitreApprentissage;
    }

    public function getDateNaissanceSecondMaitreApprentissage(): string
    {
        return $this->dateNaissanceSecondMaitreApprentissage;
    }

    public function isADejaEteMaitreApprentissage2(): bool
    {
        return $this->aDejaEteMaitreApprentissage2;
    }

    public function isADejaRecuUneFormationDeMaitreApprentissage2(): bool
    {
        return $this->aDejaRecuUneFormationDeMaitreApprentissage2;
    }

    public function getResponsableFormation(): string
    {
        return $this->responsableFormation;
    }

    public function getValidateurDevis(): string
    {
        return $this->validateurDevis;
    }

    public function getDureeContrat(): string
    {
        return $this->dureeContrat;
    }

    public function getCoutContrat(): string
    {
        return $this->coutContrat;
    }

    public function getMontantPriseEnChargeNPEC(): string
    {
        return $this->montantPriseEnChargeNPEC;
    }

    public function getMontantResteACharge(): string
    {
        return $this->montantResteACharge;
    }

    public function getCoutFormationALAnne(): string
    {
        return $this->coutFormationALAnne;
    }

    public function getCoutContratAvantNegociation(): string
    {
        return $this->coutContratAvantNegociation;
    }

    public function getNumeroDECA(): string
    {
        return $this->numeroDECA;
    }

    public function getCodeDiplome(): string
    {
        return $this->codeDiplome;
    }

    public function getCodeRNCP(): string
    {
        return $this->codeRNCP;
    }

    public function getSFP(): string
    {
        return $this->SFP;
    }

    public function getDateEnvoiSFP(): string
    {
        return $this->dateEnvoiSFP;
    }

    public function getGestionnaireEnvoi(): string
    {
        return $this->gestionnaireEnvoi;
    }

    public function getDureeSFP(): string
    {
        return $this->dureeSFP;
    }

    public function getDateDebutFormation(): string
    {
        return $this->dateDebutFormation;
    }

    public function getDateFinFormation(): string
    {
        return $this->dateFinFormation;
    }

    public function getEtablissementDocEmployeur(): string
    {
        return $this->etablissementDocEmployeur;
    }

    public function getDateEtablissementDocEmployeur(): string
    {
        return $this->dateEtablissementDocEmployeur;
    }

    public function formatTableau(): array
    {
        if ($this->aDejaEteMaitreApprentissage) {
            $maitreApprentissage = 1;
        } else {
            $maitreApprentissage = 0;
        }
        if ($this->aDejaRecuUneFormationDeMaitreApprentissage) {
            $formationMaitreApprentissage = 1;
        } else {
            $formationMaitreApprentissage = 0;
        }
        if ($this->aDejaEteMaitreApprentissage2) {
            $maitreApprentissage2 = 1;
        } else {
            $maitreApprentissage2 = 0;
        }
        if ($this->aDejaRecuUneFormationDeMaitreApprentissage2) {
            $formationMaitreApprentissage2 = 1;
        } else {
            $formationMaitreApprentissage2 = 0;
        }

        return array(
            "archiveeTag" => $this->archivee,
            "gereEnDehorsDeStudeaTag" => $this->gereEnDehorsDeStudea,
            "statutOPCOTag" => $this->statutOPCO,
            "idTag" => $this->id,
            "etablissementTag" => $this->etablissement,
            "formationTag" => $this->formation,
            "anneeDebutTag" => $this->anneeDebut,
            "anneeFinTag" => $this->anneeFin,
            "genreAlternantTag" => $this->genreAlternant,
            "nomAlternantTag" => $this->nomAlternant,
            "prenomAlternantTag" => $this->prenomAlternant,
            "dateSaisieParEntrepriseTag" => $this->dateSaisieParEntreprise,
            "validationPedagogiqueDesMissionsTag" => $this->validationPedagogiqueDesMissions,
            "ficheEnErreurTag" => $this->ficheEnErreur,
            "codeErreurTag" => $this->codeErreur,
            "contratEtConventionEnvoyeALEntrepriseTag" => $this->contratEtConventionEnvoyeALEntreprise,
            "contratOuConventionSigneTag" => $this->contratOuConventionSigne,
            "dateNaissanceTag" => $this->dateNaissance,
            "communeNaissanceTag" => $this->communeNaissance,
            "paysNaissanceTag" => $this->paysNaissance,
            "nationaliteTag" => $this->nationalite,
            "travailleurHandicapeTag" => $this->travailleurHandicape,
            "titulairePermisDeConduireTag" => $this->titulairePermisDeConduire,
            "numeroSecuriteSocialeTag" => $this->numeroSecuriteSociale,
            "pasDeNumeroDeSecuriteSocialeTag" => $this->pasDeNumeroDeSecuriteSociale,
            "sportifHautNiveauTag" => $this->sportifHautNiveau,
            "telephone1Tag" => $this->telephone1,
            "telephone2Tag" => $this->telephone2,
            "email1Tag" => $this->email1,
            "email2Tag" => $this->email2,
            "adresseTag" => $this->adresse,
            "complementTag" => $this->complement,
            "codePostalTag" => $this->codePostal,
            "villeTag" => $this->ville,
            "genreRepresentantLegalTag" => $this->genreRepresentantLegal,
            "nomRepresentantLegalTag" => $this->nomRepresentantLegal,
            "prenomRepresentantLegalTag" => $this->prenomRepresentantLegal,
            "adresse2Tag" => $this->adresse2,
            "complement2Tag" => $this->complement2,
            "codePostal2Tag" => $this->codePostal2,
            "ville2Tag" => $this->ville2,
            "codeINETag" => $this->codeINE,
            "situationAvantContratTag" => $this->situationAvantContrat,
            "paysDernierDiplomePrepareTag" => $this->paysDernierDiplomePrepare,
            "departementDernierDiplomePrepareTag" => $this->departementDernierDiplomePrepare,
            "etablissementDernierDiplomePrepareTag" => $this->etablissementDernierDiplomePrepare,
            "UAIEtablissementDernierDiplomePrepareTag" => $this->UAIEtablissementDernierDiplomePrepare,
            "typeDiplomeTag" => $this->typeDiplome,
            "anneeTag" => $this->annee,
            "intituleTag" => $this->intitule,
            "obtentionTag" => $this->obtention,
            "derniereAnneeOuClasseSuivieTag" => $this->derniereAnneeOuClasseSuivie,
            "dernierDiplomeObtenuTag" => $this->dernierDiplomeObtenu,
            "entrepriseTemporaireTag" => $this->entrepriseTemporaire,
            "nomContratTemporaireTag" => $this->nomContratTemporaire,
            "prenomContratTemporaireTag" => $this->prenomContratTemporaire,
            "mailContratTemporaireTag" => $this->mailContratTemporaire,
            "telephoneContratTemporaireTag" => $this->telephoneContratTemporaire,
            "siretTag" => $this->siret,
            "typeEmployeurTag" => $this->typeEmployeur,
            "raisonSocialeTag" => $this->raisonSociale,
            "codeNAFTag" => $this->codeNAF,
            "caisseRetraiteComplementaireTag" => $this->caisseRetraiteComplementaire,
            "effectifTotalTag" => $this->effectifTotal,
            "adresseEntrepriseTag" => $this->adresseEntreprise,
            "complementAdresseTag" => $this->complementAdresse,
            "codePostalEntrepriseTag" => $this->codePostalEntreprise,
            "villeEntrepriseTag" => $this->villeEntreprise,
            "adresse2EntrepriseTag" => $this->adresse2Entreprise,
            "complementAdresse2Tag" => $this->complementAdresse2,
            "codePostal2EntrepriseTag" => $this->codePostal2Entreprise,
            "ville2EntrepriseTag" => $this->ville2Entreprise,
            "genreDirecteurTag" => $this->genreDirecteur,
            "nomDirecteurTag" => $this->nomDirecteur,
            "prenomDirecteurTag" => $this->prenomDirecteur,
            "fonctionDirecteurTag" => $this->fonctionDirecteur,
            "mailDirecteurTag" => $this->mailDirecteur,
            "siretAdministratifTag" => $this->siretAdministratif,
            "typeEmployeurAdministratifTag" => $this->typeEmployeurAdministratif,
            "raisonSocialeAdministratifTag" => $this->raisonSocialeAdministratif,
            "codeNAFAdministratifTag" => $this->codeNAFAdministratif,
            "caisseRetraiteComplementaireAdministratifTag" => $this->caisseRetraiteComplementaireAdministratif,
            "effectifTotalAdministratifTag" => $this->effectifTotalAdministratif,
            "adresseAdministratifTag" => $this->adresseAdministratif,
            "complementAdresseAdministratifTag" => $this->complementAdresseAdministratif,
            "codePostalAdministratifTag" => $this->codePostalAdministratif,
            "villeAdministratifTag" => $this->villeAdministratif,
            "genreDirecteurAdministratifTag" => $this->genreDirecteurAdministratif,
            "nomDirecteurAdministratifTag" => $this->nomDirecteurAdministratif,
            "prenomDirecteurAdministratifTag" => $this->prenomDirecteurAdministratif,
            "fonctionDirecteurAdministratifTag" => $this->fonctionDirecteurAdministratif,
            "mailDirecteurAdministratifTag" => $this->mailDirecteurAdministratif,
            "genreInterlocuteurRHTag" => $this->genreInterlocuteurRH,
            "nomInterlocuteurRHTag" => $this->nomInterlocuteurRH,
            "prenomInterlocuteurRHTag" => $this->prenomInterlocuteurRH,
            "fonctionInterlocuteurRHTag" => $this->fonctionInterlocuteurRH,
            "mailInterlocuteurRHTag" => $this->mailInterlocuteurRH,
            "OPCOTag" => $this->OPCO,
            "IDCCTag" => $this->IDCC,
            "codeIDCCTag" => $this->codeIDCC,
            "missionsSaisiesTag" => $this->missionsSaisies,
            "fichierJointPourLesMissionsTag" => $this->fichierJointPourLesMissions,
            "mandatCFATag" => $this->mandatCFA,
            "typeContratTag" => $this->typeContrat,
            "dateDebutContratTag" => $this->dateDebutContrat,
            "dateFinContratTag" => $this->dateFinContrat,
            "genreMaitreApprentissageTag" => $this->genreMaitreApprentissage,
            "nomMaitreApprentissageTag" => $this->nomMaitreApprentissage,
            "prenomMaitreApprentissageTag" => $this->prenomMaitreApprentissage,
            "fonctionMaitreApprentissageTag" => $this->fonctionMaitreApprentissage,
            "telephoneMaitreApprentissageTag" => $this->telephoneMaitreApprentissage,
            "mailMaitreApprentissageTag" => $this->mailMaitreApprentissage,
            "dateNaissanceMaitreApprentissageTag" => $this->dateNaissanceMaitreApprentissage,
            "aDejaEteMaitreApprentissageTag" => $maitreApprentissage,
            "aDejaRecuUneFormationDeMaitreApprentissageTag" => $formationMaitreApprentissage,
            "genreSecondMaitreApprentissageTag" => $this->genreSecondMaitreApprentissage,
            "nomSecondMaitreApprentissageTag" => $this->nomSecondMaitreApprentissage,
            "prenomSecondMaitreApprentissageTag" => $this->prenomSecondMaitreApprentissage,
            "fonctionSecondMaitreApprentissageTag" => $this->fonctionSecondMaitreApprentissage,
            "telephoneSecondMaitreApprentissageTag" => $this->telephoneSecondMaitreApprentissage,
            "mailSecondMaitreApprentissageTag" => $this->mailSecondMaitreApprentissage,
            "dateNaissanceSecondMaitreApprentissageTag" => $this->dateNaissanceSecondMaitreApprentissage,
            "aDejaEteMaitreApprentissage2Tag" => $maitreApprentissage2,
            "aDejaRecuUneFormationDeMaitreApprentissage2Tag" => $formationMaitreApprentissage2,
            "responsableFormationTag" => $this->responsableFormation,
            "validateurDevisTag" => $this->validateurDevis,
            "dureeContratTag" => $this->dureeContrat,
            "coutContratTag" => $this->coutContrat,
            "montantPriseEnChargeNPETag" => $this->montantPriseEnChargeNPEC,
            "montantResteAChargeTag" => $this->montantResteACharge,
            "coutFormationALAnneTag" => $this->coutFormationALAnne,
            "coutContratAvantNegociationTag" => $this->coutContratAvantNegociation,
            "numeroDECATag" => $this->numeroDECA,
            "codeDiplomeTag" => $this->codeDiplome,
            "codeRNCPTag" => $this->codeRNCP,
            "SFPTag" => $this->SFP,
            "dateEnvoiSFPTag" => $this->dateEnvoiSFP,
            "gestionnaireEnvoiTag" => $this->gestionnaireEnvoi,
            "dureeSFPTag" => $this->dureeSFP,
            "dateDebutFormationTag" => $this->dateDebutFormation,
            "dateFinFormationTag" => $this->dateFinFormation,
            "etablissementDocEmployeurTag" => $this->etablissementDocEmployeur,
            "dateEtablissementDocEmployeurTag" => $this->dateEtablissementDocEmployeur
        );
    }

}
