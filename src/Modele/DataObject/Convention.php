<?php
namespace App\FormatIUT\Modele\DataObject;
use DateTime;
class Convention extends AbstractDataObject{
//TODO FAIRE LA CLASSE
    public function formatTableau(): array{ return []; }

    private int $compteur = 0;
    private string $idConvetion;
    private bool $conventionValidee;
    private DateTime $dateDebut;
    private DateTime $dateFin;

    private string $assurance;
    private string $objectifStage;


}
