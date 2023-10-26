<?php
namespace App\FormatIUT\Modele\DataObject;

class Regarder extends AbstractDataObject{
    private float $numEtudiant;
    private int $idOffre;
    private string $Etat;

    private string $cv_id;

    private string $lm_id;


    /**
     * @return float
     */
    public function getNumEtudiant(): float
    {
        return $this->numEtudiant;
    }

    /**
     * @param float $numEtudiant
     */
    public function setNumEtudiant(float $numEtudiant): void
    {
        $this->numEtudiant = $numEtudiant;
    }

    /**
     * @return int
     */
    public function getIdOffre(): int
    {
        return $this->idOffre;
    }

    /**
     * @param int $idOffre
     */
    public function setIdOffre(int $idOffre): void
    {
        $this->idOffre = $idOffre;
    }

    /**
     * @return string
     */
    public function getEtat(): string
    {
        return $this->Etat;
    }

    /**
     * @param string $Etat
     */
    public function setEtat(string $Etat): void
    {
        $this->Etat = $Etat;
    }

    /**
     * @return string
     */
    public function getCvId(): string
    {
        return $this->cv_id;
    }

    /**
     * @param string $cv_id
     */
    public function setCvId(string $cv_id): void
    {
        $this->cv_id = $cv_id;
    }

    /**
     * @return string
     */
    public function getLmId(): string
    {
        return $this->lm_id;
    }

    /**
     * @param string $lm_id
     */
    public function setLmId(string $lm_id): void
    {
        $this->lm_id = $lm_id;
    }


    public function __construct(float $numEtudiant, int $idOffre, string $Etat, string $cv_id, string $lm_id)
    {
        $this->numEtudiant = $numEtudiant;
        $this->idOffre = $idOffre;
        $this->Etat = $Etat;
        $this->cv_id = $cv_id;
        $this->lm_id = $lm_id;
    }


    public function formatTableau(): array{
        return array(
            "numEtudiant"=> $this->numEtudiant,
            "idOffre"=> $this->idOffre,
            "Etat" => $this->Etat,
            "cv_id"=> $this->cv_id,
            "lm_id"=> $this->lm_id
        );
    }
}