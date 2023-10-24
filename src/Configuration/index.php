<?php

namespace App\FormatIUT\Controleur;

// récupère en paramètre un login et un mot de passse, se connecte à ldap et vérifie que le mot de passe est correct pour ce login, puis écrit en json sur la page toutes les informations

use App\FormatIUT\Modele\Repository\ConnexionLdap;

class ControleurConnexionLdap
{

    public static function trouverUser(string $login, string $password)
    {
        ConnexionLdap::connexion();
        if (ConnexionLdap::userExist($login)) {
            if (ConnexionLdap::verifLDap($login, $password)) {
                $infos = ConnexionLdap::getInfoPersonne($login);
                echo json_encode($infos);
            } else {
                echo json_encode("Mot de passe incorrect");
            }
        } else {
            echo json_encode("Utilisateur inconnu");
        }
    }
}
