<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Ville extends AbstractDataObject
{

    private string $idVille;
    private string $nomVille;
    private string $paysVille;

    /**
     * @param string $idVille
     * @param string $nomVille
     * @param string $paysVille
     */
    public function __construct(string $idVille, string $nomVille, string $paysVille)
    {
        $this->idVille = $idVille;
        $this->nomVille = $nomVille;
        $this->paysVille = $paysVille;
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

    public function getPaysVille(): string
    {
        return $this->paysVille;
    }

    public function setPaysVille(string $paysVille): void
    {
        $this->paysVille = $paysVille;
    }


    public function formatTableau(): array
    {
        return array(
            "idVille"=>$this->idVille,
            "nomVIlle"=>$this->nomVille,
            "paysVille"=>$this->paysVille
        );
    }
}