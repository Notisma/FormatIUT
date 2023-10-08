<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\Repository\AbstractRepository;

class Entreprise extends AbstractDataObject
{
    private float $siret;
    private string $nomEntreprise;
    private string $statutJuridique;
    private int $effectif;
    private string $codeNAF;
    private string $tel;
    private string $Adresse_Entreprise;
    private string $idVille;

    public function __construct(float $siret, string $nomEntreprise, string $statutJuridique, int $effectif, string $codeNAF, string $tel,string $adresse,string $idVille)
    {
        $this->siret = $siret;
        $this->nomEntreprise = $nomEntreprise;
        $this->statutJuridique = $statutJuridique;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;
        $this->Adresse_Entreprise=$adresse;
        $this->idVille=$idVille;

    }

    public function getVille(): string
    {
        return $this->idVille;
    }

    public function getAdresse(): string
    {
        return $this->Adresse_Entreprise;
    }

    public function setAdresse(string $adresse): void
    {
        $this->Adresse_Entreprise = $adresse;
    }

    public function getIdVille(): string
    {
        return $this->idVille;
    }

    public function setIdVille(string $idVille): void
    {
        $this->idVille = $idVille;
    }


    public function formatTableau(): array
    {
        return ['numSiret' => $this->siret, 'nomEntreprise' => $this->nomEntreprise,
            'statutJuridique' => $this->statutJuridique, 'effectif' => $this->effectif, 'codeNAF' => $this->codeNAF,
            'tel' => $this->tel,"Adresse_Entreprise"=>$this->Adresse_Entreprise,"idVille"=>$this->idVille];
    }

    public function __toString(): string
    {
        return $this->nomEntreprise;
    }


    public function getSiret(): float
    {
        return $this->siret;
    }

    public function setSiret(float $siret): void
    {
        $this->siret = $siret;
    }

    public function getNomEntreprise(): string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): void
    {
        $this->nomEntreprise = $nomEntreprise;
    }

    public function getStatutJuridique(): string
    {
        return $this->statutJuridique;
    }

    public function setStatutJuridique(string $statutJuridique): void
    {
        $this->statutJuridique = $statutJuridique;
    }

    public function getEffectif(): int
    {
        return $this->effectif;
    }

    public function setEffectif(int $effectif): void
    {
        $this->effectif = $effectif;
    }

    public function getCodeNAF(): string
    {
        return $this->codeNAF;
    }

    public function setCodeNAF(string $codeNAF): void
    {
        $this->codeNAF = $codeNAF;
    }

    public function getTel(): string
    {
        return $this->tel;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

}
