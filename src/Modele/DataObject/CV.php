<?php

namespace App\FormatIUT\Modele\DataObject;

class CV extends AbstractDataObject
{
    private string $idCV;
    private string $contenuCV;

    /**
     * @return string
     */
    public function getIdCV(): string
    {
        return $this->idCV;
    }

    /**
     * @param string $idCV
     */
    public function setIdCV(string $idCV): void
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

    public function __construct(string $idCV, string $contenuCV)
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