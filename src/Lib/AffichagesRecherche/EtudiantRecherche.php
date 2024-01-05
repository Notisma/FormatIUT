<?php

namespace App\FormatIUT\Lib\AffichagesRecherche;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

class EtudiantRecherche extends AbstractAffichage
{


    function getTitreRouge()
    {
        return htmlspecialchars(parent::getObjet()->getPrenomEtudiant()) . ' ' . htmlspecialchars(parent::getObjet()->getNomEtudiant());
    }

    public function getLienAction()
    {
        return '?action=afficherDetailEtudiant&controleur=' . Configuration::getControleurName() . '&numEtu=' . parent::getObjet()->getNumEtudiant();
    }

    function getTitres()
    {
        $etudiant = parent::getObjet();
        $titres = '<h4 class="titre">' . htmlspecialchars($etudiant->getParcours()) . '</h4>
                                <h4 class="titre">' . htmlspecialchars($etudiant->getGroupe()) . '</h4>
                                <h5 class="titre">' . htmlspecialchars($etudiant->getMailUniersitaire()) . '</h5>';
        if (Configuration::getControleurName() == 'AdminMain') {
            if ((new EtudiantRepository)->aUneFormation($etudiant->getNumEtudiant())) {
                $titres.= "<div class='statutEtu valide'><img src='../ressources/images/success.png' alt='valide'><p>A une formation validée</p></div>";
            } else {
                $titres.= "<div class='statutEtu nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Aucun stage/alternance</p></div>";
            }
        }
        return $titres;
    }

    function getImage()
    {
        return Configuration::getUploadPathFromId(parent::getObjet()->getImg());
    }
}