<?php

namespace App\FormatIUT\Lib\Users;

abstract class Utilisateur
{
    private string $login;

    public function __construct(string $login)
    {
        $this->login=$login;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string le controleur à utiliser, associé à l'utilisateur
     */
    public abstract function getControleur():string;

    /**
     * @return string l'image de profil de l'utilisateur connecté
     */
    public abstract function getImageProfil():string;

    /**
     * @return string le type de connexion de l'utilisateur connecté
     */
    public abstract function getTypeConnecte() :string;

    /**
     * @return array le contenu du bandeau déroulant
     */
    public abstract function getMenu():array;

    /**
     * @return array tableau des éléments recherchable et les filtres associés
     */
    public abstract function getFiltresRecherche() : array;


}