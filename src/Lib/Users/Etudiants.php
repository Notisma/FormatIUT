<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;

class Etudiants extends Utilisateur
{

    /**
     * @return string le controleur de l'utilisateur connecté
     */
    public function getControleur(): string
    {
        return "EtuMain";
    }

    /**
     * @return string l'image de profil de l'utilisateur connecté
     */
    public function getImageProfil():string
    {
        $etu = (new EtudiantRepository())->getObjectParClePrimaire((new EtudiantRepository())->getNumEtudiantParLogin($this->getLogin()));

        return Configuration::getUploadPathFromId($etu->getImg());
    }

    /**
     * @return string le type de connexion de l'utilisateur connecté
     */
    public function getTypeConnecte(): string
    {
        return "Etudiants";
    }

    /**
     * @return array[] qui représente le contenu du menu dans le bandeauDéroulant
     */
    public function getMenu(): array
    {
        $etu = (new EtudiantRepository())->getObjectParClePrimaire((new EtudiantRepository())->getNumEtudiantParLogin($this->getLogin()));

        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Etudiants", "lien" => "?action=afficherAccueilEtu&controleur=EtuMain"),
            array("image" => "../ressources/images/stage.png", "label" => "Offres de Stage/Alternance", "lien" => "?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/signet.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&controleur=EtuMain"),
        );

        $formation = (new EtudiantRepository())->aUneFormation($etu->getNumEtudiant());
        if ($formation && ControleurEtuMain::getTitrePageActuelleEtu() != "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => " Mon Offre", "lien" => "?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=" . $formation['idFormation']);
        }
        if (ControleurEtuMain::getTitrePageActuelleEtu() == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfil&controleur=EtuMain");
        }

        if (ControleurEtuMain::getTitrePageActuelleEtu() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/mallette.png", "label" => "Détails de l'offre", "lien" => "?afficherVueDetailOffre&controleur=EtuMain&idFormation=" . $_REQUEST['idFormation']);
        }

        if (ControleurMain::getPageActuelle() == "Résultats de la recherche") {
            $menu[] = array("image" => "../ressources/images/rechercher.png", "label" => "Résultats de la recherche", "lien" => "?action=afficherAccueilEtu&controleur=EtuMain");
        }

        $offre = (new FormationRepository())->trouverOffreDepuisForm($etu->getNumEtudiant());
        if ($offre) {
            if (is_null($offre->getDateCreationConvention())) {
                $offreValidee = (new PostulerRepository())->getOffreValider($etu->getNumEtudiant());
                if ($offreValidee) {
                    $menu[] = array("image" => "../ressources/images/document.png", "label" => "Remplir ma convention", "lien" => "?controleur=EtuMain&action=afficherFormulaireConvention");
                }
            } else $menu[] = array("image" => "../ressources/images/document.png", "label" => "Ma convention", "lien" => "?controleur=EtuMain&action=afficherMaConvention");
        } else {
            $menu[] = array("image" => "../ressources/images/document.png", "label" => "Remplir convention", "lien" => "?controleur=EtuMain&action=afficherFormulaireConventionSansEntreprise");
        }

        $menu[] = array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter&controleur=Main");
        return $menu;
    }

    public function getFiltresRecherche(): array
    {
        return array(
            "Entreprise" => array(
                "filtre1" => array("label" => "Entreprises Validées", "value" => "entreprise_validee", "obligatoire"),
            ),
            "Formation" => array(
                "filtre2" => array("label" => "Stages", "value" => "formation_stage",),
                "filtre3" => array("label" => "Alternances", "value" => "formation_alternance"),
                "filtre4" => array("label" => "Formations Validées", "value" => "formation_validee", "obligatoire"),
                "filtre5" => array("label" => "Formations Disponibles", "value" => "formation_disponible", "obligatoire")
            ),

        );
    }
}