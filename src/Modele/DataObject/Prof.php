<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Prof extends AbstractDataObject
{
    private int $idProf;
    private string $nomProf;
    private string $prenomProf;
    private string $mailUniversitaire;
    private string $img;

    /**
     * @param int $idProf
     * @param string $nomProf
     * @param string $prenomProf
     * @param string $loginProf
     */
    public function __construct(int $idProf, string $nomProf, string $prenomProf,string $mailUniversitaire,string $img)
    {
        $this->idProf = $idProf;
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->mailUniversitaire=$mailUniversitaire;
        $this->img=$img;
    }

    public function getMailUniversitaire(): string
    {
        return $this->mailUniversitaire;
    }

    public function setMailUniversitaire(string $mailUniversitaire): void
    {
        $this->mailUniversitaire = $mailUniversitaire;
    }


    public function getIdProf(): int
    {
        return $this->idProf;
    }

    public function setIdProf(int $idProf): void
    {
        $this->idProf = $idProf;
    }


    public function getNomProf(): string
    {
        return $this->nomProf;
    }

    public function setNomProf(string $nomProf): void
    {
        $this->nomProf = $nomProf;
    }

    public function getPrenomProf(): string
    {
        return $this->prenomProf;
    }

    public function setPrenomProf(string $prenomProf): void
    {
        $this->prenomProf = $prenomProf;
    }

    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg(string $img): void
    {
        $this->img = $img;
    }



    public function formatTableau(): array
    {
        return array(
            "idProf"=>$this->idProf,
            "nomProf"=>$this->nomProf,
            "prenomProf"=>$this->prenomProf,
            "mailUniversitaire"=>$this->mailUniversitaire,
            "img"=>$this->img,
        );
    }
}