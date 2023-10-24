<?php

namespace App\FormatIUT\Modele\Repository;

use App\FormatIUT\Configuration\ConfigurationLdap;

class ConnexionLdap
{


    public static function connexion(){
        ConfigurationLdap::setConnexion(ldap_connect(ConfigurationLdap::getHost(),ConfigurationLdap::getPort()));
        ldap_set_option(ConfigurationLdap::getConn(),LDAP_OPT_PROTOCOL_VERSION, 3);
    }
    public static function userExist(string $login) :bool{
        self::connexion();
        $ldap_searchfilter = "(uid=$login)";
        $search = ldap_search(ConfigurationLdap::getConn(), ConfigurationLdap::getBasedn(), $ldap_searchfilter, array());
        $user_result = ldap_get_entries(ConfigurationLdap::getConn(), $search);
        return $user_result["count"] == 1;
    }
    public static function verifLDap(string $login,string $password) : bool{
        self::connexion();
        $ldap_searchfilter = "(uid=$login)";
        $search = ldap_search(ConfigurationLdap::getConn(), ConfigurationLdap::getBasedn(), $ldap_searchfilter, array());
        $user_result = ldap_get_entries(ConfigurationLdap::getConn(), $search);
// on verifie que l’entree existe bien
        $user_exist = $user_result["count"] == 1;
        $passwd_ok=false;
// si l’utilisateur existe bien,
        //que pour Ann2 pour l'instant
        if ($user_exist) {
            $dn = "uid=".$login.",ou=Ann2,ou=Etudiants,ou=people,dc=info,dc=iutmontp,dc=univ-montp2,dc=fr";
            $passwd_ok = ldap_bind(ConfigurationLdap::getConn(), $dn, $password);
        }
        return $passwd_ok;
    }

    public static function listePersonnes(){
        self::connexion();
        //On recherche toutes les entres du LDAP qui sont des personnes
        $search = ldap_search(ConfigurationLdap::getConn(), ConfigurationLdap::getBasedn(), "(objectClass=person)");
//On recupere toutes les entres de la recherche effectuees auparavant
        $resultats = ldap_get_entries(ConfigurationLdap::getConn(), $search);
//Pour chaque utilisateur, on recupere les informations utiles
        var_dump($resultats);

        for ($i=0; $i < count($resultats) - 1 ; $i++) {
//On stocke le login, nom/prnom, la classe et la promotion de l’utilisateur courant
            $nomprenom = explode(" ", $resultats[$i]["displayname"][0]);
            $promotion = explode("=", explode(",", $resultats[$i]["dn"])[1])[1];
        }
    }
    public static function getInfoPersonne(string $login){
        self::connexion();
        $search = ldap_search(ConfigurationLdap::getConn(), ConfigurationLdap::getBasedn(), "(uid=$login)");
        $resultats = ldap_get_entries(ConfigurationLdap::getConn(), $search);
        $infos=array(
            $nomprenom = explode(" ", $resultats[0]["displayname"][0]),
            $promotion = explode("=", explode(",", $resultats[0]["dn"])[1])[1],
        );
        return $infos;
    }
}