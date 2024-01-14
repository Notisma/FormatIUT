<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Configuration\Configuration;

class ProfRecherche extends AbstractAffichage
{

    /**
     * @return string le titre du prof en rouge
     */
    function getTitreRouge():string
    {
        return htmlspecialchars(parent::getObjet()->getPrenomProf()) . ' ' . htmlspecialchars(parent::getObjet()->getNomProf());
    }

    /**
     * @return string le lien du prof
     */
    function getLienAction():string
    {
        return "?action=afficherVueProf&controleur=AdminMain&loginProf=".$this->objet->getLoginProf();
    }

    /**
     * @return string le texte du prof en noir
     */
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

    /**
     * @return string l'image du prof
     */
    function getImage():string
    {
        return Configuration::getUploadPathFromId(parent::getObjet()->getImg());
    }
}