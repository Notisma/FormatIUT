<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Formation extends AbstractDataObject
{
    private string $idFormation;
    private \DateTime $dateDebut;
    private \DateTime $dateFin;
    private int $idEtudiant;
    private float $idEntreprise;
    private int $idOffre;

    /**
     * @param string $idFormation
     * @param \DateTime $dateDebut
     * @param \DateTime $dateFin
     * @param int $idEtudiant
     * @param float $idEntreprise
     * @param int $idOffre
     */
    public function __construct(string $idFormation, \DateTime $dateDebut, \DateTime $dateFin, int $idEtudiant, float $idEntreprise, int $idOffre)
    {
        $this->idFormation = $idFormation;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->idEtudiant = $idEtudiant;
        $this->idEntreprise = $idEntreprise;
        $this->idOffre = $idOffre;
    }

    public function formatTableau(): array
    {
        return array(
            "idFormation"=>$this->idFormation,
            'dateDebut' => date_format($this->dateDebut,'Y-m-d'),
            'dateFin' => date_format($this->dateFin,'Y-m-d'),
            "idEtudiant"=>$this->idEtudiant,
            "idEntreprise"=>$this->idEntreprise,
            "idOffre"=>$this->idOffre
        );
    }

    public function getIdFormation(): string
    {
        return $this->idFormation;
    }

    public function setIdFormation(string $idFormation): void
    {
        $this->idFormation = $idFormation;
    }

    public function getDateDebut(): \DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): \DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function getIdEtudiant(): int
    {
        return $this->idEtudiant;
    }

    public function setIdEtudiant(int $idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }

    public function getIdEntreprise(): float
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(float $idEntreprise): void
    {
        $this->idEntreprise = $idEntreprise;
    }

    public function getIdOffre(): int
    {
        return $this->idOffre;
    }

    public function setIdOffre(int $idOffre): void
    {
        $this->idOffre = $idOffre;
    }


}
