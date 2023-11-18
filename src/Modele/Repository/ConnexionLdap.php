<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Configuration\ConfigurationLdap;

class ConnexionLdap
{

    private static array $infosUser;

    public static function connexion(string $login, string $mdp, string $action)
    {
        //on essaie de se connecter, et si ça crash on affiche une erreur
        //echo $_SERVER['HTTP_HOST'];//.$_SERVER['PHP_SELF'];
        if ($_SERVER["HTTP_HOST"]=="webinfo.iutmontp.univ-montp2.fr") {
            ConfigurationLdap::setConnexion(ldap_connect(ConfigurationLdap::getHost(), ConfigurationLdap::getPort()));
            ldap_set_option(ConfigurationLdap::getConn(), LDAP_OPT_PROTOCOL_VERSION, 3);
            self::$infosUser=self::getInfoLdap($login);
            return self::verifLDap($login, $mdp);

        } else {
            //on se connecte à une page web sur internet, et on lit ce qui est écrit en json
            //on apelle une fonction dans ce même fichier
            $cle = rawurlencode("rJ8D39Z/CPhT2M/0EilvjO");
            $url = "https://webinfo.iutmontp.univ-montp2.fr/~loyet/index.php?login=$login&mdp=$mdp&action=$action&cle=$cle";
            $json = file_get_contents($url);
            $obj = json_decode($json);
            $infos = explode('"', $json);
            if (in_array("Valider", $infos)) {
                self::$infosUser = $infos;
                return true;
            }
        }

    }

    public static function verifLDap(string $login, string $password): bool
    {
        $ldap_searchfilter = "(uid=$login)";
        $search = ldap_search(ConfigurationLdap::getConn(), ConfigurationLdap::getBasedn(), $ldap_searchfilter, array());
        $user_result = ldap_get_entries(ConfigurationLdap::getConn(), $search);
// on verifie que l’entree existe bien
        $user_exist = $user_result["count"] == 1;
        $passwd_ok = false;
// si l’utilisateur existe bien,
        //que pour Ann2 pour l'instant
        foreach (explode(",", $user_result[0]["dn"]) as $item) {
            if (strstr($item, "ou=")) {
                $ou[] = $item;
            }
        }
        //que pour Ann2 pour l'instant
        if ($user_exist) {
            $dn = "uid=" . $login . ",";
            foreach ($ou as $item) {
                $dn .= $item . ",";
            }
            $dn .= "dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
            $passwd_ok = ldap_bind(ConfigurationLdap::getConn(), $dn, $password);
        }
        return $passwd_ok;
    }

    public static function getInfoPersonne()
    {
        if ($_SERVER["HTTP_HOST"] == "webinfo.iutmontp.univ-montp2.fr") {
        $infos = array(
            "nom" => self::$infosUser[0][0],
            "prenom" => self::$infosUser[0][1],
            "mail" => self::$infosUser[1],
            "type" => self::$infosUser[2],

        );
        if ($infos["type"] == "Etudiants") {
            $infos["Annee"] = self::$infosUser[3];
        }
        return $infos;
    }else {
        $infos= array(
            "nom" => self::$infosUser[1],
            "prenom" => self::$infosUser[3],
            "mail" => self::$infosUser[5],
            "type" => self::$infosUser[7],

        );
        if ($infos["type"]=="Etudiants"){
            $infos["Annee"]=self::$infosUser[9];
        }
        return $infos;
    }

    }

    public static function getInfoLdap(string $login){
        //self::connexion($login,);
        $search = ldap_search(ConfigurationLdap::getConn(), ConfigurationLdap::getBasedn(), "(uid=$login)");
        $resultats = ldap_get_entries(ConfigurationLdap::getConn(), $search);
        $dn=explode(",",$resultats[0]["dn"]);
        $infos=array(
            $nomprenom = explode(" ", $resultats[0]["displayname"][0]),
            $resultats[0]["mail"][0],
            explode("=",$dn[sizeof($dn)-6])[1],
            $promotion = explode("=", explode(",", $resultats[0]["dn"])[1])[1],

        );
        return $infos;
    }


    public static function deconnexion()
    {
        if (strstr("webinfo", $_SERVER['HTTP_HOST'])) {
            ldap_close(ConfigurationLdap::getConn());
        } else {
            $cle = rawurlencode("rJ8D39Z/CPhT2M/0EilvjO");
            $url = "https://webinfo.iutmontp.univ-montp2.fr/~loyet/index.php?action=deconnexion&cle=$cle";
        }
    }

}