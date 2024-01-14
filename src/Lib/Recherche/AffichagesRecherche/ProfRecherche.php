<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Configuration\Configuration;

class ProfRecherche extends AbstractAffichage
{

    function getTitreRouge():string
    {
        return htmlspecialchars(parent::getObjet()->getPrenomProf()) . ' ' . htmlspecialchars(parent::getObjet()->getNomProf());
    }

    function getLienAction():string
    {
        return "?action=afficherVueProf&controleur=AdminMain&loginProf=".$this->objet->getLoginProf();
    }

    function getTitres():string
    {
        $titres = '<h4 class="titre">';
        if (parent::getObjet()->isEstAdmin()) {
            $titres.= 'Administrateur';
        } else if ($this->objet->getNomProf()=="secretariat"){
            $titres.="Secretariat";
        }else
        {
            $titres.= 'Professeur';
        }
        $titres.= '</h4>';
        if (!empty(parent::getObjet()->getMailUniversitaire())) $titres .= '<h5 class="titre">' . htmlspecialchars(parent::getObjet()->getMailUniversitaire()) . '</h5>';
        return $titres;
    }

    function getImage():string
    {
        return Configuration::getUploadPathFromId(parent::getObjet()->getImg());
    }
}