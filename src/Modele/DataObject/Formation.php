<?php

namespace App\FormatIUT\Modele\DataObject;

use DateTime;

class Formation extends AbstractDataObject
{
    private string $idFormation;
    private DateTime $dateDebut;
    private DateTime $dateFin;
    private int $idEtudiant;
    private ?string $idTuteurPro;
    private float $idEntreprise;
    private ?string $idConvention;
    private ?int $idTuteurUM;

    /**
     * @param string $idFormation
     * @param DateTime $dateDebut
     * @param DateTime $dateFin
     * @param int $idEtudiant
     * @param string|null $idTuteurPro
     * @param float $idEntreprise
     * @param string|null $idConvention
     * @param int|null $idTuteurUM
     * @param int $idOffre
     */
    public function __construct(string $idFormation, DateTime $dateDebut, DateTime $dateFin, int $idEtudiant, ?string $idTuteurPro, float $idEntreprise, ?string $idConvention, ?int $idTuteurUM, int $idOffre)
    {
        $this->idFormation = $idFormation;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->idEtudiant = $idEtudiant;
        $this->idTuteurPro = $idTuteurPro;
        $this->idEntreprise = $idEntreprise;
        $this->idConvention = $idConvention;
        $this->idTuteurUM = $idTuteurUM;
        $this->idOffre = $idOffre;
    }

    public function getIdTuteurPro(): ?string
    {
        return $this->idTuteurPro;
    }

    public function setIdTuteurPro(?string $idTuteurPro): void
    {
        $this->idTuteurPro = $idTuteurPro;
    }

    public function getIdConvention(): ?string
    {
        return $this->idConvention;
    }

    public function setIdConvention(?string $idConvention): void
    {
        $this->idConvention = $idConvention;
    }

    public function getIdTuteurUM(): ?int
    {
        return $this->idTuteurUM;
    }

    public function setIdTuteurUM(?int $idTuteurUM): void
    {
        $this->idTuteurUM = $idTuteurUM;
    }

    private int $idOffre;


    public function formatTableau(): array
    {
        return array(
            "idFormation" => $this->idFormation,
            'dateDebut' => date_format($this->dateDebut, 'Y-m-d'),
            'dateFin' => date_format($this->dateFin, 'Y-m-d'),
            "idEtudiant" => $this->idEtudiant,
            "idTuteurPro" => $this->idTuteurPro,
            "idEntreprise" => $this->idEntreprise,
            "idConvention" => $this->idConvention,
            "idTuteurUM" => $this->idTuteurUM,
            "idOffre" => $this->idOffre
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

    public function getDateDebut(): DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(DateTime $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(DateTime $dateFin): void
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
