<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Ville extends AbstractDataObject
{

    private string $idVille;
    private string $nomVille;
    private int $codePostal;

    /**
     * @param string $idVille
     * @param string $nomVille
     * @param string $codePostal
     */
    public function __construct(string $idVille, string $nomVille, int $codePostal)
    {
        $this->idVille = $idVille;
        $this->nomVille = $nomVille;
        $this->codePostal = $codePostal;
    }

    public function getIdVille(): string
    {
        return $this->idVille;
    }

    public function setIdVille(string $idVille): void
    {
        $this->idVille = $idVille;
    }

    public function getNomVille(): string
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): void
    {
        $this->nomVille = $nomVille;
    }

    public function getCodePostal(): int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): void
    {
        $this->codePostal = $codePostal;
    }


    public function formatTableau(): array
    {
        return array(
            "idVille"=>$this->idVille,
            "nomVille"=>$this->nomVille,
            "codePostal"=>$this->codePostal
        );
    }
}