<?php


// récupère en paramètre un login et un mot de passse, se connecte à ldap et vérifie que le mot de passe est correct pour ce login, puis écrit en json sur la page toutes les informations
if (isset($_REQUEST["login"], $_REQUEST["mdp"], $_REQUEST["action"], $_REQUEST["cle"])) {
    if (rawurldecode($_REQUEST["cle"]) == ControleurConnexionLdap::getCleIndex()) {
        if ($_REQUEST["action"] == "afficherListe") {
            ControleurConnexionLdap::listePersonnes();
        } else {
            ControleurConnexionLdap::connexion();
            if (ControleurConnexionLdap::userExist($_REQUEST["login"])) {
                if (ControleurConnexionLdap::verifLDap($_REQUEST["login"], $_REQUEST["mdp"])) {
                    $infos = ControleurConnexionLdap::getInfoPersonne($_REQUEST["login"]);
                    echo json_encode($infos);
                    echo json_encode("Valider");
                } else {
                    echo json_encode("Mot de passe incorrect");
                }
            } else {
                echo json_encode("Utilisateur inconnu");
            }
        }
        ldap_close(ControleurConnexionLdap::getConn());
    }
}

class ControleurConnexionLdap
{
    private static string $cleIndex = "rJ8D39Z/CPhT2M/0EilvjO";

    /**
     * @return string
     */
    public static function getCleIndex(): string
    {
        return self::$cleIndex;
    }

    public static function trouverUser(string $login, string $password)
    {
        echo "test";
        self::connexion();
        if (self::userExist($login)) {
            if (self::verifLDap($login, $password)) {
                $infos = self::getInfoPersonne($login);
                echo "Valider";
                echo json_encode($infos);
            } else {
                echo json_encode("Mot de passe incorrect");
            }
        } else {
            echo json_encode("Utilisateur inconnu");
        }
    }

    public static function connexion()
    {
        //on essaie de se connecter, et si ça crash on affiche une erreur
        self::setConnexion(ldap_connect(self::getHost(), self::getPort()));
        ldap_set_option(self::getConn(), LDAP_OPT_PROTOCOL_VERSION, 3);
    }

    public static function userExist(string $login): bool
    {
        self::connexion();
        $ldap_searchfilter = "(uid=$login)";
        $search = ldap_search(self::getConn(), self::getBasedn(), $ldap_searchfilter, array());
        $user_result = ldap_get_entries(self::getConn(), $search);
        return $user_result["count"] == 1;
    }

    public static function verifLDap(string $login, string $password): bool
    {
        self::connexion();
        $ldap_searchfilter = "(uid=$login)";
        $search = ldap_search(self::getConn(), self::getBasedn(), $ldap_searchfilter, array());
        $user_result = ldap_get_entries(self::getConn(), $search);
// on verifie que l’entree existe bien
        $user_exist = $user_result["count"] == 1;
        $passwd_ok = false;
// si l’utilisateur existe bien,
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
            $passwd_ok = ldap_bind(self::getConn(), $dn, $password);
        }
        return $passwd_ok;
    }

    public static function listePersonnes()
    {
        self::connexion();
        //On recherche toutes les entres du LDAP qui sont des personnes
        $search = ldap_search(self::getConn(), self::getBasedn(), "(objectClass=person)");
//On recupere toutes les entres de la recherche effectuees auparavant
        $resultats = ldap_get_entries(self::getConn(), $search);
//Pour chaque utilisateur, on recupere les informations utiles
        for ($i = 0; $i < count($resultats) - 1; $i++) {
//On stocke le login, nom/prnom, la classe et la promotion de l’utilisateur courant
            $promotion[$i] = explode("=", explode(",", $resultats[$i]["dn"])[1])[1];
            if ($promotion[$i]!="Personnel" && $promotion[$i]!="people"){

            $nomprenom[$i] = explode(" ", $resultats[$i]["displayname"][0]);

            echo $nomprenom[$i][0]. " ".$nomprenom[$i][1]." : ";
            echo $promotion[$i]."<br>";
            }
        }

    }

    public static function getInfoPersonne(string $login)
    {
        self::connexion();
        $search = ldap_search(self::getConn(), self::getBasedn(), "(uid=$login)");
        $resultats = ldap_get_entries(self::getConn(), $search);
        $dn = explode(",", $resultats[0]["dn"]);
        $infos = array(
            $nomprenom = explode(" ", $resultats[0]["displayname"][0]),
            $resultats[0]["mail"][0],
            explode("=", $dn[sizeof($dn) - 6])[1],
            $promotion = explode("=", explode(",", $resultats[0]["dn"])[1])[1],

        );
        return $infos;
    }

    static private array $config = array(
        'ldap_host' => "10.10.1.30",
        'ldap_basedn' => "dc=info,dc=iutmontp,dc=univ-montp2,dc=fr",
        'ldap_port' => 389,
        'ldap_conn' => false
    );

    public static function getHost(): string
    {
        return self::$config["ldap_host"];
    }

    public static function getBasedn(): string
    {
        return self::$config["ldap_basedn"];
    }

    public static function getPort(): string
    {
        return self::$config["ldap_port"];
    }

    public static function getConn()
    {
        return self::$config["ldap_conn"];
    }

    public static function setConnexion($conn)
    {
        self::$config["ldap_conn"] = $conn;
    }
}
