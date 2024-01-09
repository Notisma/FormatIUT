<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\UploadsRepository;

class Etudiants extends Utilisateur
{

    public function getRecherche(): array
    {
        return array(
            "Formation",
            "Entreprise"
        );
    }

    public function getControleur(): string
    {
        return "EtuMain";
    }

    public function getImageProfil()
    {
        $etu=(new EtudiantRepository())->getObjectParClePrimaire((new EtudiantRepository())->getNumEtudiantParLogin($this->getLogin()));

        return Configuration::getUploadPathFromId($etu->getImg());
    }

    public function getTypeConnecte(): string
    {
        return "Etudiants";
    }

    public function getFiltresRecherche(): array
    {
        return array(
            "Entreprise"=>array(
                "filtre1"=>array("label"=>"Entreprises Validées","value"=>"entreprise_validee","obligatoire","SQL"=>" AND estValide=1 "),
            ),
            "Formation"=>array(
                "filtre2"=>array("label"=>"Stages","value"=>"formation_stage","SQL"=>" AND typeOffre=\"Stage\" "),
                "filtre3"=>array("label"=>"Alternances","value"=>"formation_alternance","SQL"=>" AND typeOffre=\"Alternance\" "),
                "filtre4"=>array("label"=>"Formations Validées","value"=>"formation_validee","obligatoire","SQL"=>" AND estValide=1"),
                "filtre5"=>array("label"=>"Formations Disponibles","value"=>"formation_disponible","obligatoire","SQL"=>" AND idEtudiant is Null")
            ),

        );
    }
}