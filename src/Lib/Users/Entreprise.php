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
            "Formation"
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
}