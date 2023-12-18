<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

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
    }

    public function getTypeConnecte(): string
    {
        return "Etudiants";
    }
}