<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\Users\Utilisateur;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class Entreprise extends Utilisateur
{

    public function getRecherche(): array
    {
        return array(
            "Formation",
            "Etudiant"
        );
    }

    public function getControleur(): string
    {
       return "EntrMain";
    }

    public function getImageProfil()
    {
        $entreprise=(new EntrepriseRepository())->getEntrepriseParMail($this->getLogin());
        return Configuration::getUploadPathFromId($entreprise->getImg());
    }

    public function getTypeConnecte(): string
    {
        return "Entreprise";
    }

    public function getFiltresRecherche(): array
    {
        return array(
            "filtre1"=>"formation_stage",
            "filtre2"=>"formation_alternance",
            "filtre3"=>"formation_validee",
            "filtre4"=>"formation_non_validee",
            "filtre5"=>"formation_entreprise",
            "filtre6"=>"etudiant_A1",
            "filtre7"=>"etudiant_A2",
            "filtre8"=>"etudiant_A3",
            "filtre9"=>"etudiant_concernes"
        );
    }
}