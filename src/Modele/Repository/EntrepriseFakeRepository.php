<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Modele\DataObject\EntrepriseFake;

class EntrepriseFakeRepository extends RechercheRepository
{
    protected function getNomTable(): string
    {
        return "EntreprisesFake";
    }

    protected function getNomsColonnes(): array
    {
        return ["numSiret", "nomEntreprise", "statutJuridique", "effectif", "codeNAF", "tel", "adresseEntreprise", "idVille", "email"];
    }

    protected function getColonnesRecherche(): array
    {
        return array("nomEntreprise");
    }

    public function construireDepuisTableau(array $entrepriseFakeFormatTableau): EntrepriseFake
    {
        return new EntrepriseFake($entrepriseFakeFormatTableau['numSiret'],
            $entrepriseFakeFormatTableau['nomEntreprise'],
            $entrepriseFakeFormatTableau['statutJuridique'],
            $entrepriseFakeFormatTableau['effectif'],
            $entrepriseFakeFormatTableau['codeNAF'],
            $entrepriseFakeFormatTableau['tel'],
            $entrepriseFakeFormatTableau['adresseEntreprise'],
            $entrepriseFakeFormatTableau['idVille'],
            $entrepriseFakeFormatTableau["email"],
        );
    }

    protected function getClePrimaire(): string
    {
        return "numSiret";
    }
}
