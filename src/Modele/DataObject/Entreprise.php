<?php

namespace App\FormatIUT\Modele\DataObject;

class Entreprise
{
    private int $siret;
    private string $nomEntreprise;
    private string $statutJuridique;
    private int $effectif;
    private string $codeNAF;
    private string $tel;

    public function __construct(int $siret, string $nomEntreprise, string $statutJuridique, int $effectif, string $codeNAF, string $tel)
    {
        $this->siret = $siret;
        $this->nomEntreprise = $nomEntreprise;
        $this->statutJuridique = $statutJuridique;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;

    }

    public static function construireDepuisTableau(array $entrepriseFormatTableau): Entreprise
    {
        return new Entreprise($entrepriseFormatTableau['numSiret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel']);
    }

    public function formatTableau(): array
    {
        return ['numSiret' => $this->siret, 'nomEntreprise' => $this->nomEntreprise,
            'statutJuridique' => $this->statutJuridique, 'effectif' => $this->effectif, 'codeNAF' => $this->codeNAF,
            'tel' => $this->tel];
    }

    public function __toString(): string
    {
        return $this->nomEntreprise;
    }


    public function getSiret(): int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): void
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
