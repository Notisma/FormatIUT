<?php

namespace App\FormatIUT\Modele\DataObject;

class CV extends AbstractDataObject
{
    private int $idCV;
    private string $contenuCV;

    /**
     * @return int
     */
    public function getIdCV(): int
    {
        return $this->idCV;
    }

    /**
     * @param int $idCV
     */
    public function setIdCV(int $idCV): void
    {
        $this->idCV = $idCV;
    }

    /**
     * @return string
     */
    public function getContenuCV(): string
    {
        return $this->contenuCV;
    }

    /**
     * @param string $contenuCV
     */
    public function setContenuCV(string $contenuCV): void
    {
        $this->contenuCV = $contenuCV;
    }

    public function __construct(int $idCV, string $contenuCV)
    {
        $this->idCV = $idCV;
        $this->contenuCV = $contenuCV;
    }


    public function formatTableau(): array{
        return array(
            "idCV"=> $this->idCV,
            "contenuCV" => $this->contenuCV
        );
    }

}