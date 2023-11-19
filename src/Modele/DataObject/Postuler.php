<?php

namespace App\FormatIUT\Modele\DataObject;

class Postuler extends AbstractDataObject
{
    private float $numEtudiant;
    private int $idOffre;
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
    public function getIdOffre(): int
    {
        return $this->idOffre;
    }

    /**
     * @param int $idOffre
     */
    public function setIdOffre(int $idOffre): void
    {
        $this->idOffre = $idOffre;
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


    public function __construct(float $numEtudiant, int $idOffre, string $Etat, ?string $cv, ?string $lettre)
    {
        $this->numEtudiant = $numEtudiant;
        $this->idOffre = $idOffre;
        $this->etat = $Etat;
        $this->cv = $cv;
        $this->lettre = $lettre;
    }


    public function formatTableau(): array
    {
        return array(
            "numEtudiant" => $this->numEtudiant,
            "idOffre" => $this->idOffre,
            "Etat" => $this->etat,
            "cv" => $this->cv,
            "lettre" => $this->lettre
        );
    }
}
