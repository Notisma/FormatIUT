<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

class EtudiantRecherche extends AbstractAffichage
{


    /**
     * @return string le titre de l'objet à afficher en rouge
     */
    function getTitreRouge():string
    {
        return htmlspecialchars(parent::getObjet()->getPrenomEtudiant()) ." ". htmlspecialchars(parent::getObjet()->getNomEtudiant());
    }

    /**
     * @return string le titre de l'objet à afficher en noir
     */
    public function getLienAction():string
    {
        return '?action=afficherDetailEtudiant&controleur=' .  ConnexionUtilisateur::getUtilisateurConnecte()->getControleur() . '&numEtudiant=' . parent::getObjet()->getNumEtudiant();
    }

    /**
     * @return string le texte de l'objet à afficher en noir
     */
    function getTitres():string
    {
        $etudiant = parent::getObjet();
        $titres = '';
        if (!empty($etudiant->getParcours())) $titres .= '<h4 class="titre">' . htmlspecialchars($etudiant->getParcours()) . '</h4>';
        if (!empty($etudiant->getGroupe())) $titres .= '<h4 class="titre">' . htmlspecialchars($etudiant->getGroupe()) . '</h4>';
        if (!empty($etudiant->getMailUniersitaire())) $titres .= '<h5 class="titre">' . htmlspecialchars($etudiant->getMailUniersitaire()) . '</h5>';
        if (Configuration::getControleurName() == 'AdminMain') {
            if ((new EtudiantRepository)->aUneFormation($etudiant->getNumEtudiant())) {
                $titres.= "<div class='statutEtu valide'><img src='../ressources/images/success.png' alt='valide'><p>A une formation validée</p></div>";
            } else {
                $titres.= "<div class='statutEtu nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Aucun stage/alternance</p></div>";
            }
        }
        return $titres;
    }

    /**
     * @return string l'image de l'objet
     */
    function getImage():string
    {
        return Configuration::getUploadPathFromId(parent::getObjet()->getImg());
    }
}