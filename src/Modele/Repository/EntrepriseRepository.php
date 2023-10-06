<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Entreprise;
use PDO;

// cette classe n'est pas encore faite, sauf deux fonctions utilisées dans Offre
class EntrepriseRepository extends AbstractRepository
{
    // private parce qu'on a pas besoin de mieux pour l'instant, mais on pourra mettre public si besoin
    public function getEntreprises(): array
    {
        return $this->getListeObjet();
    }

    public function getEntrepriseFromSiret(int $siret): ?AbstractDataObject
    {
        return $this->getObjectParClePrimaire($siret);
    }

    protected function getNomTable(): string
    {
        return "Entreprise";
    }

    protected function getNomsColonnes(): array
    {
        // TODO: Implement getNomsColonnes() method.
    }

    public function construireDepuisTableau(array $entrepriseFormatTableau): Entreprise
    {
        return new Entreprise($entrepriseFormatTableau['numSiret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel']);
    }

    protected function getClePrimaire(): string
    {
       return  "numSiret";
    }
}