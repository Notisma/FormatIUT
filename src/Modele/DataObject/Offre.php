<?php
namespace App\FormatIUT\modele\DataObject;

use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class Offre
{
    private int $idOffre;
    private string $nomOffre;
    private string $dateDebut;
    private string $dateFin;
    private string $sujet;
    private string $detailProjet;
    private float $gratification;
    private int $dureeHeures;
    private int $joursParSemaine;
    private int $nbHeuresHebdo;
    private Entreprise $entreprise;
    private string $typeOffre;

    public function __construct(int $idOffre, string $nomOffre, string $dateDebut, string $dateFin, string $sujet, string $detailProjet, float $gratification, int $dureeHeures, int $joursParSemaine, int $nbHeuresHebdo, ?Entreprise $entreprise, string $type)
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
        $this->entreprise = $entreprise;
        $this->typeOffre = $type;
    }

    public function getTypeOffre(): string
    {
        return $this->typeOffre;
    }
    public function getEntreprise(): Entreprise
    {
        return $this->entreprise;
    }
    public function setEntreprise(Entreprise $entreprise): void
    {
        $this->entreprise = $entreprise;
    }
    public function getIdOffre(): int
    {
        return $this->idOffre;
    }
    public function getNomOffre(): string
    {
        return $this->nomOffre;
    }
    public function setNomOffre(string $nomOffre): void
    {
        $this->nomOffre = $nomOffre;
    }
    public function getDateDebut(): string
    {
        return $this->dateDebut;
    }
    public function setDateDebut(string $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }
    public function getDateFin(): string
    {
        return $this->dateFin;
    }
    public function setDateFin(string $dateFin): void
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

    public function formatTableau(): array
    {
        return ['idOffre' => $this->idOffre, 'nomOffre' => $this->nomOffre, 'dateDebut' => $this->dateDebut,
            'dateFin' => $this->dateFin, 'sujet' => $this->sujet, 'detailProjet' => $this->detailProjet,
            'gratification' => $this->gratification, 'dureeHeures' => $this->dureeHeures,
            'joursParSemaine' => $this->joursParSemaine,
            'nbHeuresHebdo' => $this->nbHeuresHebdo, 'Entreprise' => $this->entreprise, 'typeOffre' => $this->typeOffre];
    }
    public static function construireDepuisTableau(array $offreDB): Offre {
        return new Offre($offreDB['idOffre'],
            $offreDB['nomOffre'],
            $offreDB['dateDebut'],
            $offreDB['dateFin'],
            $offreDB['sujet'],
            $offreDB['detailProjet'],
            $offreDB['gratification'],
            $offreDB['dureeHeures'],
            $offreDB['joursParSemaine'],
            $offreDB['nbHeuresHebdo'],
            EntrepriseRepository::getEntrepriseFromSiret($offreDB['idEntreprise']),
            $offreDB['typeOffre']
        );
    }

    public function __toString() : string { //retourne un résumé de l'offre (pour la liste dans catalogue)
        return "$this->nomOffre (proposé par $this->entreprise)";
    }

}

?>