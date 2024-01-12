<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\Recherche\AffichagesRecherche\AbstractAffichage;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

class FormationRecherche extends AbstractAffichage
{
    private Entreprise $entreprise;

    function getTitreRouge():string
    {
        return htmlspecialchars(parent::getObjet()->getNomOffre());
    }

    function getLienAction():string
    {
        $this->entreprise = ((new EntrepriseRepository())->getObjectParClePrimaire(parent::getObjet()->getIdEntreprise()));
        return '?action=afficherVueDetailOffre&controleur=' . Configuration::getControleurName() . '&idFormation=' . parent::getObjet()->getIdFormation();
    }

    function getTitres():string
    {
        $formation=parent::getObjet();
        $titres = '<h4 class="titre">' . htmlspecialchars($this->entreprise->getNomEntreprise()) . '</h4>
                                <h4 class="titre">' . htmlspecialchars(parent::getObjet()->getTypeOffre());
        if (Configuration::getControleurName() == "AdminMain") {
            $titres.= ' - ';
            if (parent::getObjet()->getEstValide()) {
                $titres .= 'VALIDÉE';
            } else {
                $titres .= 'NON VALIDÉE';
            }
        }
        $titres.= '</h4>
                                <h5 class="titre">' . htmlspecialchars($formation->getSujet()) . '</h5>
                                <div><img src="../ressources/images/equipe.png" alt="candidats"> <h4 class="titre">';
        if (!$formation->estAssignee()) {
            $nb = (new EtudiantRepository())->nbPostulations($formation->getidFormation());
            if ($nb == 0) {
                $titres.= "Aucun";
            } else {
                $titres.= $nb;
            }
            $titres.= " candidat";
            if ($nb > 1) {
                echo "s";
            }
        } else {
            $titres.= "Assignée";
        }
        $titres.=
        '</h4> </div>';
        return $titres;

    }

    function getImage():string
    {
        return Configuration::getUploadPathFromId($this->entreprise->getImg());

    }
}