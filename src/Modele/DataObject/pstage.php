<?php
namespace App\FormatIUT\Modele\DataObject;

class pstage extends AbstractDataObject {
    private int $numeroEtudiant;
    private string $nomEtudiant;
    private string $prenomEtudiant;
    private int $age;
    private int $annee;
    private bool $stage;

    /**
     * @param int $numeroEtudiant
     * @param string $nomEtudiant
     * @param string $prenomEtudiant
     * @param int $age
     * @param int $annee
     * @param bool $stage
     */
    public function __construct(int $numeroEtudiant, string $nomEtudiant, string $prenomEtudiant, int $age, int $annee, bool $stage)
    {
        $this->numeroEtudiant = $numeroEtudiant;
        $this->nomEtudiant = $nomEtudiant;
        $this->prenomEtudiant = $prenomEtudiant;
        $this->age = $age;
        $this->annee = $annee;
        $this->stage = $stage;
    }

    public function getNumeroEtudiant(): int
    {
        return $this->numeroEtudiant;
    }

    public function setNumeroEtudiant(int $numeroEtudiant): void
    {
        $this->numeroEtudiant = $numeroEtudiant;
    }

    public function getNomEtudiant(): string
    {
        return $this->nomEtudiant;
    }

    public function setNomEtudiant(string $nomEtudiant): void
    {
        $this->nomEtudiant = $nomEtudiant;
    }

    public function getPrenomEtudiant(): string
    {
        return $this->prenomEtudiant;
    }

    public function setPrenomEtudiant(string $prenomEtudiant): void
    {
        $this->prenomEtudiant = $prenomEtudiant;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getAnnee(): int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): void
    {
        $this->annee = $annee;
    }

    public function isStage(): bool
    {
        return $this->stage;
    }

    public function setStage(bool $stage): void
    {
        $this->stage = $stage;
    }

    public function formatTableau(): array {
        if($this->stage == true){
            $boolean=1;
        } else{
            $boolean=0;
        }
        return array(
            'numeroEtudiant'=>$this->numeroEtudiant,
            'nomEtudiant'=>$this->nomEtudiant,
            'prenomEtudiant'=>$this->prenomEtudiant,
            'age'=>$this->age,
            'annee'=>$this->annee,
            'stage'=>$boolean
        );
    }
}
?>