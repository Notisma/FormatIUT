<?php

namespace App\FormatIUT\Modele\DataObject;

class LM extends AbstractDataObject
{
    private int $idLM;
    private string $contenuLM;

    /**
     * @return int
     */
    public function getIdLM(): int
    {
        return $this->idLM;
    }

    /**
     * @param int $idLM
     */
    public function setIdLM(int $idLM): void
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

    public function __construct(int $idLM, string $contenuLM)
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