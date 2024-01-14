<?php

namespace App\FormatIUT\Lib\Recherche\AffichagesRecherche;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;
use App\FormatIUT\Configuration\Configuration;


abstract class AbstractAffichage
{
    protected AbstractDataObject $objet;

    public function __construct(AbstractDataObject $object)
    {
        $this->objet=$object;
    }

    /**
     * @return AbstractDataObject retourne l'objet à afficher
     */
    protected function getObjet(): AbstractDataObject
    {
        return $this->objet;
    }

    /**
     * @return string L'information principale de l'objet à afficher pendant la recherche
     */
    abstract function getTitreRouge():string;

    /**
     * @return string le lien pour rediriger vers la page de description de l'objet depuis la recherche
     */
    abstract function getLienAction() : string;

    /**
     * @return string les informations complémentaires de l'objet à afficher pendant la recherche
     */
    abstract function getTitres() :string;

    /**
     * @return string le lien de l'image à afficher pour représenter l'objet pendant la recherche
     */
    abstract function getImage() :string;
}