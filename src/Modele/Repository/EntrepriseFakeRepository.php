<?php

namespace App\FormatIUT\Modele\Repository;

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
        return new EntrepriseFake($entrepriseFormatTableau['numSiret'],
            $entrepriseFormatTableau['nomEntreprise'],
            $entrepriseFormatTableau['statutJuridique'],
            $entrepriseFormatTableau['effectif'],
            $entrepriseFormatTableau['codeNAF'],
            $entrepriseFormatTableau['tel'],
            $entrepriseFormatTableau['adresseEntreprise'],
            $entrepriseFormatTableau['idVille'],
            $entrepriseFormatTableau["email"],
        );
    }

    protected function getClePrimaire(): string
    {
        return "numSiret";
    }
}
