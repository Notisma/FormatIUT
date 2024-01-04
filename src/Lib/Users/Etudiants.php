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
            "filtre1"=>"stage"
        );
    }
}