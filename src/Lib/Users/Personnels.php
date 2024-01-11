<?php

namespace App\FormatIUT\Lib\Users;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\Users\Utilisateur;

class Personnels extends Utilisateur
{

    public function getRecherche(): array
    {
        return array(
            "Formation",
            "Entreprise",
            "Etudiant"
        );
    }

    public function getControleur(): string
    {
        return "AdminMain";
    }

    public function getImageProfil()
    {
        return "../ressources/images/admin.png";
    }

    public function getTypeConnecte(): string
    {
        return "Personnels";
    }
    
        public function getMenu(): array
    {
        $menu=$this->getDebutMenu();
        $menu[]=$this->getFinMenu();
        return $menu;
    }

    protected function getDebutMenu()
    {
        $accueil = ConnexionUtilisateur::getTypeConnecte();
        $menu = array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil $accueil", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain"),
            array("image" => "../ressources/images/etudiants.png", "label" => "Liste Étudiants", "lien" => "?action=afficherListeEtudiant&controleur=AdminMain"),
            array("image" => "../ressources/images/liste.png", "label" => "Liste des Offres", "lien" => "?action=afficherListeOffres&controleur=AdminMain"),
            array("image" => "../ressources/images/entreprise.png", "label" => "Liste Entreprises", "lien" => "?action=afficherListeEntreprises&controleur=AdminMain"),
        );
        if (ControleurMain::getPageActuelle() == "Détails de l'offre") {
            $menu[] = array("image" => "../ressources/images/emploi.png", "label" => "Détails de l'offre", "lien" => "?action=afficherAccueilAdmin&controleur=AdminMain");
        }

        if (ControleurAdminMain::getPageActuelleAdmin() == "Mon Compte") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Mon Compte", "lien" => "?action=afficherProfilAdmin");
        }

        if (ControleurAdminMain::getPageActuelleAdmin() == "Détails d'un Étudiant") {
            $menu[] = array("image" => "../ressources/images/profil.png", "label" => "Détails d'un Étudiant", "lien" => "?action=afficherDetailEtudiant&numEtudiant=$_GET[numEtudiant]");
        }

        if (ControleurAdminMain::getPageActuelleAdmin() == "Détails d'une Entreprise") {
            $menu[] = array("image" => "../ressources/images/equipe.png", "label" => "Détails d'une Entreprise", "lien" => "?action=afficherDetailEntreprise&siret=$_GET[siret]");
        }
        return $menu;
    }
    protected function getFinMenu()
    {
        return array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "?action=seDeconnecter&controleur=Main");
    }
}