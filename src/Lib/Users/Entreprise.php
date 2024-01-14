<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\FiltresSQL;
use App\FormatIUT\Lib\Users\Utilisateur;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use Vtiful\Kernel\Format;

class Entreprise extends Utilisateur
{


    public function getControleur(): string
    {
       return "EntrMain";
    }

    public function getImageProfil():string
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

        if (ControleurEntrMain::getPage() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain");
        }

        if (ControleurEntrMain::getPage() == "Détails d'un Étudiant") {
            $menu[] = array("image" => "../ressources/images/etudiant.png", "label" => "Détails d'un Étudiant", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain");
        }

        if (ControleurEntrMain::getPage() == "Compte Entreprise") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Compte Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php?action=seDeconnecter&controleur=Main");

        return $menu;
    }

    public function getFiltresRecherche(): array
    {
        return array(
            "Formation"=>array(
                "filtre1"=>array("label"=>"Stage","value"=>"formation_stage"),
                "filtre2"=>array("label"=>"Alternance","value"=>"formation_alternance"),
                "filtre3"=>array("label"=>"Formations Validées","value"=>"formation_validee"),
                "filtre4"=>array("label"=>"Formations Non Validées","value"=>"formation_non_validee"),
                "filtre5"=>array("label"=>"Mes Formations","value"=>"formation_entreprise","obligatoire"),
            ),
            "Etudiant"=>array(
                "filtre6"=>array("label"=>"Etudiants A1","value"=>"etudiant_A1"),
                "filtre7"=>array("label"=>"Etudiants A2","value"=>"etudiant_A2"),
                "filtre8"=>array("label"=>"Etudiants A3","value"=>"etudiant_A3"),
                "filtre9"=>array("label"=>"Etudiants Concernés","value"=>"etudiant_concerne","obligatoire")
            )

        );
    }
}