<?php

use App\FormatIUT\Modele\Repository\ConnexionLdap;

// récupère en paramètre un login et un mot de passse, se connecte à ldap et vérifie que le mot de passe est correct pour ce login, puis écrit en json sur la page toutes les informations


        echo "test";
        App\FormatIUT\Modele\Repository\ConnexionLdap::connexion();
        if (ConnexionLdap::userExist($_REQUEST['login'])) {
            if (ConnexionLdap::verifLDap($_REQUEST["login"], $_REQUEST["mdp"])) {
                $infos = ConnexionLdap::getInfoPersonne($_REQUEST["mdp"]);
                echo json_encode($infos);
            } else {
                echo json_encode("Mot de passe incorrect");
            }
        } else {
            echo json_encode("Utilisateur inconnu");
        }
