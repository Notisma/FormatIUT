<?php

namespace App\FormatIUT\Lib\Users;

abstract class Utilisateur
{
    private string $login;

    /**
     * @return string
     */
    public function __construct(string $login)
    {
        $this->login=$login;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public abstract function getRecherche():array;

    public abstract function getControleur():string;
    public abstract function getImageProfil();
    public abstract function getTypeConnecte() :string;
    public abstract function getFiltresRecherche() : array;


}