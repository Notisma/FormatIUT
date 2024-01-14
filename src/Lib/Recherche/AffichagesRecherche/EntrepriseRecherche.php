<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class EntrepriseRecherche extends AbstractAffichage
{

    function getTitreRouge(): string
    {
        return htmlspecialchars(parent::getObjet()->getNomEntreprise());
    }

    function getLienAction(): string
    {
        return '?action=afficherDetailEntreprise&controleur=' . ConnexionUtilisateur::getUtilisateurConnecte()->getControleur() . '&siret=' . parent::getObjet()->getSiret();
    }

    function getTitres(): string
    {
        /** @var Entreprise $entreprise */
        $entreprise = parent::getObjet();
        $countValide = count((new EntrepriseRepository)->getOffresValidesDeEntreprise($entreprise->getSiret()));
        $countNonValide = count((new EntrepriseRepository)->getOffresNonValidesDeEntreprise($entreprise->getSiret()));
        $titres = '<h4 class="titre">' . htmlspecialchars($entreprise->getAdresseEntreprise()) . ', ' . htmlspecialchars((new \App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille())->getNomVille()) . '</h4>';
        if (!empty($entreprise->getEmail())) $titres .= '<h5 class="titre">' . htmlspecialchars($entreprise->getEmail()) . '</h5>';

        if (Configuration::getControleurName() == 'AdminMain') {
            $titres .= '<h5 class="titre">' . $countNonValide . ' offres non validées et ' . $countValide . ' offres validées.</h5>';
            if ($entreprise->isEstValide()) {
                $titres .= "<div class='statutEtu valide'><img src='../ressources/images/success.png' alt='valide'><p>Compte validé</p></div>";
            } else {
                $titres .= "<div class='statutEtu nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Compte non validé</p></div>";
            }
        } else {
            if (!empty($entreprise->getTel())) $titres .= '<h5 class="titre">' . $entreprise->getTel() . '</h5>';
        }
        return $titres;
    }

    function getImage(): string
    {
        return Configuration::getUploadPathFromId(parent::getObjet()->getImg());
    }
}