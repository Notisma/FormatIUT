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
     */
    function getTitreRouge(): string
    {
        $j= explode("\\",get_class($this->objet));
        return $j[4];
    }

    /**
     * @inheritDoc
     */
    function getLienAction(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    function getTitres(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    function getImage(): string
    {
        return "../ressources/images/rechercher.png";
    }
}