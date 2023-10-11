<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Etudiant extends AbstractDataObject
{

    //TODO finir de relier à la BD
    private float $numEtudiant;
    private string $login;

    /**
     * @param float $numEtudiant
     * @param string $login
     */
    public function __construct(float $numEtudiant, string $login)
    {
        $this->numEtudiant = $numEtudiant;
        $this->login = $login;
    }

    public function getNumEtudiant(): float
    {
        return $this->numEtudiant;
    }

    public function setNumEtudiant(float $numEtudiant): void
    {
        $this->numEtudiant = $numEtudiant;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }



    public function formatTableau(): array
    {
        return array(
            "numEtudiant"=>$this->numEtudiant,
            "login"=>$this->login
        );
    }
}