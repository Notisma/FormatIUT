<?php

namespace App\FormatIUT\Configuration;

class ConfigurationLdap
{
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