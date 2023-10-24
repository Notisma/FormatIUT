<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Configuration\ConfigurationLdap;

class ConnexionLdap
{


    public static function connexion(string $login,string $mdp){
        //on essaie de se connecter, et si ça crash on affiche une erreur
        if (ConfigurationLdap::getConn()) {
            ConfigurationLdap::setConnexion(ldap_connect(ConfigurationLdap::getHost(), ConfigurationLdap::getPort()));
            ldap_set_option(ConfigurationLdap::getConn(), LDAP_OPT_PROTOCOL_VERSION, 3);
        }
        else {
            //on se connecte à une page web sur internet, et on lit ce qui est écrit en json
            //on apelle une fonction dans ce même fichier
            $url = "https://webinfo.iutmontp.univ-montp2.fr/~loyet/index.php?login=$login&mdp=$mdp";
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $infos=explode('"',$json);
            if (in_array("Ann2",$infos)){
                return true;
            }
        }
    }

}