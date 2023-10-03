<?php
namespace App\FormatIUT\modele\DataObject;

use Cassandra\Date;

class Offre{
    private int $idOffre;
    private string $nomOffre;
    private Date $dateDebut;
    private Date $dateFin;
    private string $sujet;
    private string $detailProjet;
    private float $gratification;
    private int $dureeHeures;
    private int $joursParSemaine;
    private int $nbHeuresHebdo;

    private int $siret;

    public function getIdSiret(){
        return$this->siret;
    }

    public function setIdSiret(int $siret){
        $this->siret = $siret;
    }
    public function getIdOffre(): int
    {
        return $this->idOffre;
    }

    public function setIdOffre(int $idOffre): void
    {
        $this->idOffre = $idOffre;
    }

    public function getNomOffre(): string
    {
        return $this->nomOffre;
    }

    public function setNomOffre(string $nomOffre): void
    {
        $this->nomOffre = $nomOffre;
    }

    public function getDateDebut(): Date
    {
        return $this->dateDebut;
    }

    public function setDateDebut(Date $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): Date
    {
        return $this->dateFin;
    }

    public function setDateFin(Date $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function getSujet(): string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): void
    {
        $this->sujet = $sujet;
    }

    public function getDetailProjet(): string
    {
        return $this->detailProjet;
    }

    public function setDetailProjet(string $detailProjet): void
    {
        $this->detailProjet = $detailProjet;
    }

    public function getGratification(): float
    {
        return $this->gratification;
    }

    public function setGratification(float $gratification): void
    {
        $this->gratification = $gratification;
    }

    public function getDureeHeures(): int
    {
        return $this->dureeHeures;
    }

    public function setDureeHeures(int $dureeHeures): void
    {
        $this->dureeHeures = $dureeHeures;
    }

    public function getJoursParSemaine(): int
    {
        return $this->joursParSemaine;
    }

    public function setJoursParSemaine(int $joursParSemaine): void
    {
        $this->joursParSemaine = $joursParSemaine;
    }

    public function getNbHeuresHebdo(): int
    {
        return $this->nbHeuresHebdo;
    }

    public function setNbHeuresHebdo(int $nbHeuresHebdo): void
    {
        $this->nbHeuresHebdo = $nbHeuresHebdo;
    }

    public function __construct(int $idOffre, string $nomOffre, Date $dateDebut, Date $dateFin, string $sujet, string $detailProjet, float $gratification, int $dureeHeures, int $joursParSemaine, int $nbHeuresHebdo, int $siret)
    {
        $this->idOffre = $idOffre;
        $this->nomOffre = $nomOffre;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->sujet = $sujet;
        $this->detailProjet = $detailProjet;
        $this->gratification = $gratification;
        $this->dureeHeures = $dureeHeures;
        $this->joursParSemaine = $joursParSemaine;
        $this->nbHeuresHebdo = $nbHeuresHebdo;
        $this->siret = $siret;
    }


    public function formatTableau(): array {
        return ['idOffre' => $this->idOffre, 'nomOffre' => $this->nomOffre, 'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin, 'sujet' => $this->sujet, 'detailProjet' => $this->detailProjet,
            'gratification' => $this->gratification, 'dureeHeures' => $this->dureeHeures,
            'joursParSemaine' => $this->joursParSemaine,
            'nbHeuresHebdo' => $this->nbHeuresHebdo, 'siret' => $this->siret];
    }
    public static function offreFormatTableau($offreTab){
        $offreListe = [];
        foreach ($offreTab as $offre){
            $offreListe[] =self::construireDepuisTableau($offre);
        }
        return $offreListe;
    }
}

?>