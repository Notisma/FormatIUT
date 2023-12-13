<?php

namespace App\FormatIUT\Modele\DataObject;

class Postuler extends AbstractDataObject
{
    private float $numEtudiant;
    private int $idFormation;
    private string $etat;

    private ?string $cv;

    private ?string $lettre;

    /**
     * @return float
     */
    public function getNumEtudiant(): float
    {
        return $this->numEtudiant;
    }

    /**
     * @param float $numEtudiant
     */
    public function setNumEtudiant(float $numEtudiant): void
    {
        $this->numEtudiant = $numEtudiant;
    }

    /**
     * @return int
     */
    public function getidFormation(): int
    {
        return $this->idFormation;
    }

    /**
     * @param int $idFormation
     */
    public function setidFormation(int $idFormation): void
    {
        $this->idFormation = $idFormation;
    }

    /**
     * @return string
     */
    public function getEtat(): string
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat(string $etat): void
    {
        $this->etat = $etat;
    }


    /**
     * @return string
     */
    public function getCv(): string
    {
        return $this->cv;
    }

    /**
     * @param string $cv
     */
    public function setCv(string $cv): void
    {
        $this->cv = $cv;
    }

    /**
     * @return string
     */
    public function getLettre(): string
    {
        return $this->lettre;
    }

    /**
     * @param string $lettre
     */
    public function setLettre(string $lettre): void
    {
        $this->lettre = $lettre;
    }


    public function __construct(float $numEtudiant, int $idFormation, string $etat, ?string $cv, ?string $lettre)
    {
        $this->numEtudiant = $numEtudiant;
        $this->idFormation = $idFormation;
        $this->etat = $etat;
        $this->cv = $cv;
        $this->lettre = $lettre;
    }


    public function formatTableau(): array
    {
        return array(
            "numEtudiant" => $this->numEtudiant,
            "idFormation" => $this->idFormation,
            "etat" => $this->etat,
            "cv" => $this->cv,
            "lettre" => $this->lettre
        );
    }
}
