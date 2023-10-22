<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Ville extends AbstractDataObject
{

    private string $idVille;
    private string $nomVille;

    /**
     * @param string $idVille
     * @param string $nomVille
     */
    public function __construct(string $idVille, string $nomVille)
    {
        $this->idVille = $idVille;
        $this->nomVille = $nomVille;
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




    public function formatTableau(): array
    {
        return array(
            "idVille"=>$this->idVille,
            "nomVIlle"=>$this->nomVille,
        );
    }
}