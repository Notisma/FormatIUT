<?php

namespace App\FormatIUT\Modele\DataObject;

class Ville extends AbstractDataObject
{
    private ?int $idVille;
    private ?string $nomVille;
    private ?int $codePostal;

    /**
     * @param ?int $idVille
     * @param ?string $nomVille
     * @param ?int $codePostal
     */
    public function __construct(?int $idVille, ?string $nomVille, ?int $codePostal)
    {
        $this->idVille = $idVille;
        $this->nomVille = $nomVille;
        $this->codePostal = $codePostal;
    }

    public function getIdVille(): ?int
    {
        return $this->idVille;
    }

    public function setIdVille(?int $idVille): void
    {
        $this->idVille = $idVille;
    }

    public function getNomVille(): ?string
    {
        return $this->nomVille;
    }

    public function setNomVille(?string $nomVille): void
    {
        $this->nomVille = $nomVille;
    }

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(?int $codePostal): void
    {
        $this->codePostal = $codePostal;
    }


    public function formatTableau(): array
    {
        return array(
            "idVille" => $this->idVille,
            "nomVille" => $this->nomVille,
            "codePostal" => $this->codePostal
        );
    }
}
