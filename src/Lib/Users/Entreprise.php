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
            "Formation"=>array(
                "filtre1"=>array("label"=>"Stage","value"=>"formation_stage"),
                "filtre2"=>array("label"=>"Alternance","value"=>"formation_alternance"),
                "filtre3"=>array("label"=>"Formations Validées","value"=>"formation_validee"),
                "filtre4"=>array("label"=>"Formations Non Validées","value"=>"formation_non_validee"),
                "filtre5"=>array("label"=>"Mes Formations","value"=>"formation_entreprise"),
            ),
            "Etudiant"=>array(
                "filtre6"=>array("label"=>"Etudiants A1","value"=>"etudiant_A1"),
                "filtre7"=>array("label"=>"Etudiants A2","value"=>"etudiant_A2"),
                "filtre8"=>array("label"=>"Etudiants A3","value"=>"etudiant_A3"),
                "filtre9"=>array("label"=>"Etudiants","value"=>"etudiant_concernes")
            )

        );
    }
}