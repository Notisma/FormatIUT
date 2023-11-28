<?php

namespace App\FormatIUT\Modele\DataObject;

class TuteurPro extends AbstractDataObject
{

    private string $idTuteurPro;
    private string $mailTuteurPro;
    private string $telTuteurPro;
    private string $fonctionTuteurPro;
    private string $nomTuteurPro;
    private string $prenomTuteurPro;
    private int $idEntreprise;

    /**
     * @param string $idTuteurPro
     * @param string $mailTuteurPro
     * @param string $telTuteurPro
     * @param string $fonctionTuteurPro
     * @param string $nomTuteurPro
     * @param string $prenomTuteurPro
     * @param int $idEntreprise
     */
    public function __construct(string $idTuteurPro, string $mailTuteurPro, string $telTuteurPro, string $fonctionTuteurPro, string $nomTuteurPro, string $prenomTuteurPro, int $idEntreprise)
    {
        $this->idTuteurPro = $idTuteurPro;
        $this->mailTuteurPro = $mailTuteurPro;
        $this->telTuteurPro = $telTuteurPro;
        $this->fonctionTuteurPro = $fonctionTuteurPro;
        $this->nomTuteurPro = $nomTuteurPro;
        $this->prenomTuteurPro = $prenomTuteurPro;
        $this->idEntreprise = $idEntreprise;
    }

    public function getIdTuteurPro(): string
    {
        return $this->idTuteurPro;
    }

    public function setIdTuteurPro(string $idTuteurPro): void
    {
        $this->idTuteurPro = $idTuteurPro;
    }

    public function getMailTuteurPro(): string
    {
        return $this->mailTuteurPro;
    }

    public function setMailTuteurPro(string $mailTuteurPro): void
    {
        $this->mailTuteurPro = $mailTuteurPro;
    }

    public function getTelTuteurPro(): string
    {
        return $this->telTuteurPro;
    }

    public function setTelTuteurPro(string $telTuteurPro): void
    {
        $this->telTuteurPro = $telTuteurPro;
    }

    public function getFonctionTuteurPro(): string
    {
        return $this->fonctionTuteurPro;
    }

    public function setFonctionTuteurPro(string $fonctionTuteurPro): void
    {
        $this->fonctionTuteurPro = $fonctionTuteurPro;
    }

    public function getNomTuteurPro(): string
    {
        return $this->nomTuteurPro;
    }

    public function setNomTuteurPro(string $nomTuteurPro): void
    {
        $this->nomTuteurPro = $nomTuteurPro;
    }

    public function getPrenomTuteurPro(): string
    {
        return $this->prenomTuteurPro;
    }

    public function setPrenomTuteurPro(string $prenomTuteurPro): void
    {
        $this->prenomTuteurPro = $prenomTuteurPro;
    }

    public function getIdEntreprise(): int
    {
        return $this->idEntreprise;
    }

    public function setIdEntreprise(int $idEntreprise): void
    {
        $this->idEntreprise = $idEntreprise;
    }

    public function formatTableau(): array
    {
        return array(
            "idTuteurPro" => $this->idTuteurPro,
            "mailTuteurPro" => $this->mailTuteurPro,
            "telTuteurPro" => $this->telTuteurPro,
            "fonctionTuteurPro" => $this->fonctionTuteurPro,
            "nomTuteurPro" => $this->nomTuteurPro,
            "prenomTuteurPro" => $this->prenomTuteurPro,
            "idEntreprise" => $this->idEntreprise,
        );
    }
}
