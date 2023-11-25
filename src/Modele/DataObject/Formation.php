<?php

namespace App\FormatIUT\Modele\DataObject;
class Formation extends AbstractDataObject
{
    private string $idFormation;
    private ?string $nomOffre;
    private string $dateDebut;
    private string $dateFin;
    private ?string $sujet;
    private ?string $detailProjet;
    private ?int $dureeHeure;
    private ?int $joursParSemaine;
    private ?int $gratification;
    private ?string $uniteGratification;
    private ?int $uniteDureeGratification;
    private ?int $nbHeuresHebdo;
    private ?bool $offreValidee;
    private ?string $objectifOffre;
    private ?string $dateCreationOffre;
    private ?string $typeOffre;
    private ?int $anneeMax;
    private ?int $anneeMin;
    private ?bool $estValide;
    private ?bool $validationPedagogique;
    private ?string $convention;
    private ?bool $conventionValidee;
    private ?string $dateCreationConvention;
    private ?string $dateTransmissionConvention;
    private ?string $dateRetourSigne;
    private ?string $assurance;
    private ?string $avenant;
    private ?int $idEtudiant;
    private ?string $idTuteurPro;
    private float $idEntreprise;
    private ?int $idTuteurUM;

    /**
     * @param string $idFormation
     * @param string|null $nomOffre
     * @param string $dateDebut
     * @param string $dateFin
     * @param string|null $sujet
     * @param string|null $detailProjet
     * @param int|null $dureeHeure
     * @param int|null $joursParSemaine
     * @param int|null $gratification
     * @param string|null $uniteGratification
     * @param int|null $uniteDureeGratification
     * @param int|null $nbHeuresHebdo
     * @param bool|null $offreValidee
     * @param string|null $objectifOffre
     * @param string|null $dateCreationOffre
     * @param string|null $typeOffre
     * @param int|null $anneeMax
     * @param int|null $anneeMin
     * @param bool|null $estValide
     * @param bool|null $validationPedagogique
     * @param string|null $convention
     * @param bool|null $conventionValidee
     * @param string|null $dateCreationConvention
     * @param string|null $dateTransmissionConvention
     * @param string|null $dateRetourSigne
     * @param string|null $assurance
     * @param string|null $avenant
     * @param int|null $idEtudiant
     * @param string|null $idTuteurPro
     * @param float $idEntreprise
     * @param int|null $idTuteurUM
     */
    public function __construct(string $idFormation, ?string $nomOffre, string $dateDebut, string $dateFin, ?string $sujet, ?string $detailProjet, ?int $dureeHeure, ?int $joursParSemaine, ?int $gratification, ?string $uniteGratification, ?int $uniteDureeGratification, ?int $nbHeuresHebdo, ?bool $offreValidee, ?string $objectifOffre, ?string $dateCreationOffre, ?string $typeOffre, ?int $anneeMax, ?int $anneeMin, ?bool $estValide, ?bool $validationPedagogique, ?string $convention, ?bool $conventionValidee, ?string $dateCreationConvention, ?string $dateTransmissionConvention, ?string $dateRetourSigne, ?string $assurance, ?string $avenant, ?int $idEtudiant, ?string $idTuteurPro, float $idEntreprise, ?int $idTuteurUM)
    {
        $this->idFormation = $idFormation;
        $this->nomOffre = $nomOffre;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->sujet = $sujet;
        $this->detailProjet = $detailProjet;
        $this->dureeHeure = $dureeHeure;
        $this->joursParSemaine = $joursParSemaine;
        $this->gratification = $gratification;
        $this->uniteGratification = $uniteGratification;
        $this->uniteDureeGratification = $uniteDureeGratification;
        $this->nbHeuresHebdo = $nbHeuresHebdo;
        $this->offreValidee = $offreValidee;
        $this->objectifOffre = $objectifOffre;
        $this->dateCreationOffre = $dateCreationOffre;
        $this->typeOffre = $typeOffre;
        $this->anneeMax = $anneeMax;
        $this->anneeMin = $anneeMin;
        $this->estValide = $estValide;
        $this->validationPedagogique = $validationPedagogique;
        $this->convention = $convention;
        $this->conventionValidee = $conventionValidee;
        $this->dateCreationConvention = $dateCreationConvention;
        $this->dateTransmissionConvention = $dateTransmissionConvention;
        $this->dateRetourSigne = $dateRetourSigne;
        $this->assurance = $assurance;
        $this->avenant = $avenant;
        $this->idEtudiant = $idEtudiant;
        $this->idTuteurPro = $idTuteurPro;
        $this->idEntreprise = $idEntreprise;
        $this->idTuteurUM = $idTuteurUM;
    }

    /**
     * @return string
     */
    public function getIdFormation(): string
    {
        return $this->idFormation;
    }

    /**
     * @param string $idFormation
     */
    public function setIdFormation(string $idFormation): void
    {
        $this->idFormation = $idFormation;
    }

    /**
     * @return string|null
     */
    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    /**
     * @param string|null $nomOffre
     */
    public function setNomOffre(?string $nomOffre): void
    {
        $this->nomOffre = $nomOffre;
    }

    /**
     * @return string
     */
    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }

    /**
     * @param string $dateDebut
     */
    public function setDateDebut(string $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return string
     */
    public function getDateFin(): string
    {
        return $this->dateFin;
    }

    /**
     * @param string $dateFin
     */
    public function setDateFin(string $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string|null
     */
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    /**
     * @param string|null $sujet
     */
    public function setSujet(?string $sujet): void
    {
        $this->sujet = $sujet;
    }

    /**
     * @return string|null
     */
    public function getDetailProjet(): ?string
    {
        return $this->detailProjet;
    }

    /**
     * @param string|null $detailProjet
     */
    public function setDetailProjet(?string $detailProjet): void
    {
        $this->detailProjet = $detailProjet;
    }

    /**
     * @return int|null
     */
    public function getDureeHeure(): ?int
    {
        return $this->dureeHeure;
    }

    /**
     * @param int|null $dureeHeure
     */
    public function setDureeHeure(?int $dureeHeure): void
    {
        $this->dureeHeure = $dureeHeure;
    }

    /**
     * @return int|null
     */
    public function getJoursParSemaine(): ?int
    {
        return $this->joursParSemaine;
    }

    /**
     * @param int|null $joursParSemaine
     */
    public function setJoursParSemaine(?int $joursParSemaine): void
    {
        $this->joursParSemaine = $joursParSemaine;
    }

    /**
     * @return int|null
     */
    public function getGratification(): ?int
    {
        return $this->gratification;
    }

    /**
     * @param int|null $gratification
     */
    public function setGratification(?int $gratification): void
    {
        $this->gratification = $gratification;
    }

    /**
     * @return string|null
     */
    public function getUniteGratification(): ?string
    {
        return $this->uniteGratification;
    }

    /**
     * @param string|null $uniteGratification
     */
    public function setUniteGratification(?string $uniteGratification): void
    {
        $this->uniteGratification = $uniteGratification;
    }

    /**
     * @return int|null
     */
    public function getUniteDureeGratification(): ?int
    {
        return $this->uniteDureeGratification;
    }

    /**
     * @param int|null $uniteDureeGratification
     */
    public function setUniteDureeGratification(?int $uniteDureeGratification): void
    {
        $this->uniteDureeGratification = $uniteDureeGratification;
    }

    /**
     * @return int|null
     */
    public function getNbHeuresHebdo(): ?int
    {
        return $this->nbHeuresHebdo;
    }

    /**
     * @param int|null $nbHeuresHebdo
     */
    public function setNbHeuresHebdo(?int $nbHeuresHebdo): void
    {
        $this->nbHeuresHebdo = $nbHeuresHebdo;
    }

    /**
     * @return bool|null
     */
    public function getOffreValidee(): ?bool
    {
        return $this->offreValidee;
    }

    /**
     * @param bool|null $offreValidee
     */
    public function setOffreValidee(?bool $offreValidee): void
    {
        $this->offreValidee = $offreValidee;
    }

    /**
     * @return string|null
     */
    public function getObjectifOffre(): ?string
    {
        return $this->objectifOffre;
    }

    /**
     * @param string|null $objectifOffre
     */
    public function setObjectifOffre(?string $objectifOffre): void
    {
        $this->objectifOffre = $objectifOffre;
    }

    /**
     * @return string
     */
    public function getDateCreationOffre(): string
    {
        return $this->dateCreationOffre;
    }

    /**
     * @param string $dateCreationOffre
     */
    public function setDateCreationOffre(string $dateCreationOffre): void
    {
        $this->dateCreationOffre = $dateCreationOffre;
    }

    /**
     * @return string|null
     */
    public function getTypeOffre(): ?string
    {
        return $this->typeOffre;
    }

    /**
     * @param string|null $typeOffre
     */
    public function setTypeOffre(?string $typeOffre): void
    {
        $this->typeOffre = $typeOffre;
    }

    /**
     * @return int|null
     */
    public function getAnneeMax(): ?int
    {
        return $this->anneeMax;
    }

    /**
     * @param int|null $anneeMax
     */
    public function setAnneeMax(?int $anneeMax): void
    {
        $this->anneeMax = $anneeMax;
    }

    /**
     * @return int|null
     */
    public function getAnneeMin(): ?int
    {
        return $this->anneeMin;
    }

    /**
     * @param int|null $anneeMin
     */
    public function setAnneeMin(?int $anneeMin): void
    {
        $this->anneeMin = $anneeMin;
    }

    /**
     * @return bool|null
     */
    public function getEstValide(): ?bool
    {
        return $this->estValide;
    }

    /**
     * @param bool|null $estValide
     */
    public function setEstValide(?bool $estValide): void
    {
        $this->estValide = $estValide;
    }

    /**
     * @return bool|null
     */
    public function getValidationPedagogique(): ?bool
    {
        return $this->validationPedagogique;
    }

    /**
     * @param bool|null $validationPedagogique
     */
    public function setValidationPedagogique(?bool $validationPedagogique): void
    {
        $this->validationPedagogique = $validationPedagogique;
    }

    /**
     * @return string|null
     */
    public function getConvention(): ?string
    {
        return $this->convention;
    }

    /**
     * @param string|null $convention
     */
    public function setConvention(?string $convention): void
    {
        $this->convention = $convention;
    }

    /**
     * @return bool|null
     */
    public function getConventionValidee(): ?bool
    {
        return $this->conventionValidee;
    }

    /**
     * @param bool|null $conventionValidee
     */
    public function setConventionValidee(?bool $conventionValidee): void
    {
        $this->conventionValidee = $conventionValidee;
    }

    /**
     * @return string|null
     */
    public function getDateCreationConvention(): ?string
    {
        return $this->dateCreationConvention;
    }

    /**
     * @param string|null $dateCreationConvention
     */
    public function setDateCreationConvention(?string $dateCreationConvention): void
    {
        $this->dateCreationConvention = $dateCreationConvention;
    }

    /**
     * @return string|null
     */
    public function getDateTransmissionConvention(): ?string
    {
        return $this->dateTransmissionConvention;
    }

    /**
     * @param string|null $dateTransmissionConvention
     */
    public function setDateTransmissionConvention(?string $dateTransmissionConvention): void
    {
        $this->dateTransmissionConvention = $dateTransmissionConvention;
    }

    public function getDateRetourSigne(): ?string
    {
        return $this->dateRetourSigne;
    }

    public function setDateRetourSigne(?string $dateRetourSigne): void
    {
        $this->dateRetourSigne = $dateRetourSigne;
    }

    /**
     * @return string|null
     */
    public function getAssurance(): ?string
    {
        return $this->assurance;
    }

    /**
     * @param string|null $assurance
     */
    public function setAssurance(?string $assurance): void
    {
        $this->assurance = $assurance;
    }

    /**
     * @return string|null
     */
    public function getAvenant(): ?string
    {
        return $this->avenant;
    }

    /**
     * @param string|null $avenant
     */
    public function setAvenant(?string $avenant): void
    {
        $this->avenant = $avenant;
    }

    /**
     * @return int|null
     */
    public function getIdEtudiant(): ?int
    {
        return $this->idEtudiant;
    }

    /**
     * @param int $idEtudiant
     */
    public function setIdEtudiant(int $idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }

    /**
     * @return string|null
     */
    public function getIdTuteurPro(): ?string
    {
        return $this->idTuteurPro;
    }

    /**
     * @param string|null $idTuteurPro
     */
    public function setIdTuteurPro(?string $idTuteurPro): void
    {
        $this->idTuteurPro = $idTuteurPro;
    }

    /**
     * @return float
     */
    public function getIdEntreprise(): float
    {
        return $this->idEntreprise;
    }

    /**
     * @param float $idEntreprise
     */
    public function setIdEntreprise(float $idEntreprise): void
    {
        $this->idEntreprise = $idEntreprise;
    }

    /**
     * @return int|null
     */
    public function getIdTuteurUM(): ?int
    {
        return $this->idTuteurUM;
    }

    /**
     * @param int|null $idTuteurUM
     */
    public function setIdTuteurUM(?int $idTuteurUM): void
    {
        $this->idTuteurUM = $idTuteurUM;
    }



    public function formatTableau(): array
    {
        return array(
            "idFormation" => $this->idFormation,
            'nomOffre' => $this->nomOffre,
            'dateDebut'=>$this->dateDebut,
            'dateFin'=>$this->dateFin,
            'sujet'=>$this->sujet,
            'detailProjet'=>$this->detailProjet,
            'dureeHeure'=>$this->dureeHeure,
            'joursParSemaine'=>$this->joursParSemaine,
            'gratification'=>$this->gratification,
            'uniteGratification'=>$this->uniteGratification,
            'uniteDureeGratification'=>$this->uniteDureeGratification,
            'nbHeuresHebdo'=>$this->nbHeuresHebdo,
            'offreValidee'=>$this->offreValidee?1:0,
            'objectifOffre'=>$this->objectifOffre,
            'dateCreationOffre'=>$this->dateCreationOffre,
            'typeOffre'=>$this->typeOffre,
            'anneeMax'=>$this->anneeMax,
            'anneeMin'=>$this->anneeMin,
            'estValide'=>$this->estValide?1:0,
            'validationPedagogique'=>$this->validationPedagogique?1:0,
            'convention'=>$this->convention,
            'conventionValidee'=>$this->conventionValidee?1:0,
            'dateCreationConvention'=>$this->dateCreationConvention,
            'dateTransmissionConvention'=>$this->dateTransmissionConvention,
            'dateRetourSigne'=>$this->dateRetourSigne,
            'assurance'=>$this->assurance,
            'avenant'=>$this->avenant,
            'idEtudiant'=>$this->idEtudiant,
            'idTuteurPro'=>$this->idTuteurPro,
            'idEntreprise'=>$this->idEntreprise,
            'idTuteurUM'=>$this->idTuteurUM
        );
    }

}
