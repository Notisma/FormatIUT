<?php

namespace App\FormatIUT\Modele\DataObject;

use DateTime;

class Convention extends AbstractDataObject
{
    private string $idConvention;
    private ?int $conventionValidee;
    private DateTime $dateCreation;
    private DateTime $dateTransmission;
    private int $retourSigne;
    private string $assurance;
    private string $objectifOffre;
    private string $typeCovention;

    /**
     * @param string $idConvetion
     * @param int $conventionValidee
     * @param DateTime $dateDebut
     * @param DateTime $dateFin
     * @param int $retourSigne
     * @param string $assurance
     * @param string $objectifOffre
     * @param string $typeCovention
     */
    public function __construct(string $idConvetion, int $conventionValidee, DateTime $dateDebut, DateTime $dateFin, int $retourSigne, string $assurance, string $objectifOffre, string $typeCovention)
    {
        $this->idConvention = $idConvetion;
        $this->conventionValidee = $conventionValidee;
        $this->dateCreation = $dateDebut;
        $this->dateTransmission = $dateFin;
        $this->retourSigne = $retourSigne;
        $this->assurance = $assurance;
        $this->objectifOffre = $objectifOffre;
        $this->typeCovention = $typeCovention;
    }

    public function formatTableau(): array
    {
        return ['idConvention' => $this->idConvention,
            'conventionValidee' => $this->conventionValidee,
            'dateCreation' => date_format($this->dateCreation, 'Y-m-d'),
            'dateTransmission' => date_format($this->dateTransmission, 'Y-m-d'),
            'retourSigne' => $this->retourSigne,
            'assurance' => $this->assurance,
            'objectifOffre' => $this->objectifOffre,
            'typeConvention' => $this->typeCovention];
    }

    public function getIdConvention(): string
    {
        return $this->idConvention;
    }

    public function setIdConvention(string $idConvention): void
    {
        $this->idConvention = $idConvention;
    }

    public function getConventionValidee(): int
    {
        return $this->conventionValidee;
    }

    public function setConventionValidee(int $conventionValidee): void
    {
        $this->conventionValidee = $conventionValidee;
    }

    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function getDateTransmission(): DateTime
    {
        return $this->dateTransmission;
    }

    public function setDateTransmission(DateTime $dateTransmission): void
    {
        $this->dateTransmission = $dateTransmission;
    }

    public function getRetourSigne(): int
    {
        return $this->retourSigne;
    }

    public function setRetourSigne(int $retourSigne): void
    {
        $this->retourSigne = $retourSigne;
    }

    public function getAssurance(): string
    {
        return $this->assurance;
    }

    public function setAssurance(string $assurance): void
    {
        $this->assurance = $assurance;
    }

    public function getObjectifOffre(): string
    {
        return $this->objectifOffre;
    }

    public function setObjectifOffre(string $objectifOffre): void
    {
        $this->objectifOffre = $objectifOffre;
    }

    public function getTypeCovention(): string
    {
        return $this->typeCovention;
    }

    public function setTypeCovention(string $typeCovention): void
    {
        $this->typeCovention = $typeCovention;
    }


}
