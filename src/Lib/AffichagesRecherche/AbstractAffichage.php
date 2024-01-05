<?php

namespace App\FormatIUT\Lib\AffichagesRecherche;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Configuration\Configuration;


abstract class AbstractAffichage
{
    protected AbstractDataObject $objet;

    /**
     * @return AbstractDataObject
     */
    protected function getObjet(): AbstractDataObject
    {
        return $this->objet;
    }

    abstract function getTitreRouge();

    public function __construct(AbstractDataObject $object)
    {
        $this->objet=$object;
    }
    abstract function getLienAction();
    abstract function getTitres();
    abstract function getImage();
}