<?php

namespace App\FormatIUT\Modele\DataObject;

interface UtilisateurObject
{
    public function getControleur():string;
    public function getImageProfil():string;
    public function getTypeConnecte():string;
}