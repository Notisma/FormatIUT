<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Configuration\ConfigurationLdap;

class ConnexionLdap
{

    private static array $infosUser;

    public static function connexion(string $login, string $mdp)
    {
        //on essaie de se connecter, et si ça crash on affiche une erreur
        //echo $_SERVER['HTTP_HOST'];//.$_SERVER['PHP_SELF'];
        if (strstr("webinfo",$_SERVER['HTTP_HOST'])){
            ConfigurationLdap::setConnexion(ldap_connect(ConfigurationLdap::getHost(), ConfigurationLdap::getPort()));
            ldap_set_option(ConfigurationLdap::getConn(), LDAP_OPT_PROTOCOL_VERSION, 3);
        } else {
            //on se connecte à une page web sur internet, et on lit ce qui est écrit en json
            //on apelle une fonction dans ce même fichier
            $cle = rawurlencode("rJ8D39Z/CPhT2M/0EilvjO");
            $url = "https://webinfo.iutmontp.univ-montp2.fr/~loyet/index.php?login=$login&mdp=$mdp&action=connexion&cle=$cle";
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $infos = explode('"', $json);
            self::$infosUser = $infos;
            if (in_array("Ann2", $infos)) {
                return true;

            }
        }
    }

    public static function getInfoPersonne()
    {
        return array(
            "nom" => self::$infosUser[1],
            "prenom" => self::$infosUser[3],
            "Annee" => self::$infosUser[5],
            "mail" => self::$infosUser[7]
        );

    }


    public static function deconnexion()
    {
        if (strstr("webinfo",$_SERVER['HTTP_HOST'])){
            ldap_close(ConfigurationLdap::getConn());
        } else {
            $cle = rawurlencode("rJ8D39Z/CPhT2M/0EilvjO");
            $url = "https://webinfo.iutmontp.univ-montp2.fr/~loyet/index.php?action=deconnexion&cle=$cle";
        }
    }

}