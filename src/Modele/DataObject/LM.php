<?php

namespace App\FormatIUT\Modele\DataObject;

class LM extends AbstractDataObject
{
    private string $idLM;
    private string $contenuLM;

    /**
     * @return string
     */
    public function getIdLM(): string
    {
        return $this->idLM;
    }

    /**
     * @param string $idLM
     */
    public function setIdLM(string $idLM): void
    {
        $this->idLM = $idLM;
    }

    /**
     * @return string
     */
    public function getContenuLM(): string
    {
        return $this->contenuLM;
    }

    /**
     * @param string $contenuLM
     */
    public function setContenuLM(string $contenuLM): void
    {
        $this->contenuLM = $contenuLM;
    }

    public function __construct(string $idLM, string $contenuLM)
    {
        $this->idLM = $idLM;
        $this->contenuLM = $contenuLM;
    }


    public function formatTableau(): array{
        return array(
            "idLM"=> $this->idLM,
            "contenuLM" => $this->contenuLM
        );
    }
}