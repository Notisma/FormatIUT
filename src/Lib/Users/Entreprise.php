<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurEntrMain;
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

    public function getMenu(): array
    {
        $menu =  array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=afficherFormulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&type=Tous&controleur=EntrMain"),

        );

        if (ControleurEntrMain::getPage() == "Compte Entreprise") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Compte Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php?action=seDeconnecter&controleur=Main");

        return $menu;
    }
}