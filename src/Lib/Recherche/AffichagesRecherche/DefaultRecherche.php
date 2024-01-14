<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Lib\Recherche\AffichagesRecherche\AbstractAffichage;
use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class DefaultRecherche extends AbstractAffichage
{

    public function __construct(AbstractDataObject $object)
    {
        parent::__construct($object);
    }

    /**
     * @inheritDoc
     * @return string L'information principale de l'objet à afficher pendant la recherche
     */
    function getTitreRouge(): string
    {
        $j= explode("\\",get_class($this->objet));
        return $j[4];
    }

    /**
     * @inheritDoc
     * @return string le lien pour rediriger vers la page de description de l'objet depuis la recherche
     */
    function getLienAction(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     * @return string les informations complémentaires de l'objet à afficher pendant la recherche
     */
    function getTitres(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     * @return string le lien de l'image à afficher pour représenter l'objet pendant la recherche
     */
    function getImage(): string
    {
        return "../ressources/images/rechercher.png";
    }
}