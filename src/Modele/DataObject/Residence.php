<?php
namespace App\FormatIUT\Modele\DataObject;

class Residence extends AbstractDataObject{
    private string $idResidence;
    private string $voie;
    private string $libCedex;
    private string $idVille;

    /**
     * @param string $idResidence
     * @param string $voie
     * @param string $lixCedex
     * @param string $idVille
     */
    public function __construct(string $idResidence, string $voie, string $lixCedex, string $idVille)
    {
        $this->idResidence = $idResidence;
        $this->voie = $voie;
        $this->libCedex = $lixCedex;
        $this->idVille = $idVille;
    }

    public function formatTableau(): array{
        return ["idResidence" => $this->idResidence, "voie" => $this->voie, "libCedex"=>$this->libCedex, "idVille"=> $this->idVille]; }

    /**
     * @return string
     */
    public function getIdResidence(): string
    {
        return $this->idResidence;
    }

    /**
     * @param string $idResidence
     */
    public function setIdResidence(string $idResidence): void
    {
        $this->idResidence = $idResidence;
    }

    /**
     * @return string
     */
    public function getVoie(): string
    {
        return $this->voie;
    }

    /**
     * @param string $voie
     */
    public function setVoie(string $voie): void
    {
        $this->voie = $voie;
    }

    /**
     * @return string
     */
    public function getLibCedex(): string
    {
        return $this->libCedex;
    }

    /**
     * @param string $libCedex
     */
    public function setLibCedex(string $libCedex): void
    {
        $this->libCedex = $libCedex;
    }

    /**
     * @return string
     */
    public function getIdVille(): string
    {
        return $this->idVille;
    }

    /**
     * @param string $idVille
     */
    public function setIdVille(string $idVille): void
    {
        $this->idVille = $idVille;
    }


}
