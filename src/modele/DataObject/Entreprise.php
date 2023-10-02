<?php
namespace App\Covoiturage\Modele;

class Entreprise{
    private int $siret;
    private string $nomEntreprise;
    private string $statutJuridique;
    private int $effectif;
    private string $codeNAF;
    private string $tel;
    private int $idOffre;


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

    public function getIdOffre(): int
    {
        return $this->idOffre;
    }

    public function setIdOffre(int $idOffre): void
    {
        $this->idOffre = $idOffre;
    }

    public function __construct(int $siret, string $nomEntreprise, string $statutJuridique, int $effectif, string $codeNAF, string $tel, int $idOffre)
    {
        $this->siret = $siret;
        $this->nomEntreprise = $nomEntreprise;
        $this->statutJuridique = $statutJuridique;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;
        $this->idOffre = $idOffre;
    }

    public static function construireDepuisTableau(array $entrepriseFormatTableau) : Entreprise
    {
        return new Entreprise( $entrepriseFormatTableau['siret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel'],
            $entrepriseFormatTableau['idOffre']);
    }

    public function formatTableau(): array{
        return ['siret' => $this->siret, 'nomEntreprise' => $this->nomEntreprise,
            'statutJuridique' => $this->statutJuridique, 'effectif' => $this->effectif, 'codeNAF' => $this->codeNAF,
            'tel' => $this->tel, 'idOffre' => $this->idOffre];
    }



}

?>
