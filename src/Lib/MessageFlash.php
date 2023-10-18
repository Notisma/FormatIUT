<?php
namespace App\FormatIUT\Lib;

use App\FormatIUT\Modele\HTTP\Session;

class MessageFlash
{

    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    //TODO si y'a plusieurs messageFlash du même type, ne fonctionne pas
    //TODO Romain je dis ça je dis rien, mais pour pas que ce soit le bordel on va dire qu'il ne faut pas qu'il y ait plusieurs messages flash en même temps, quelque soit leur type
    public static function ajouter(string $type, string $message): void
    {
        // À compléter
        $array=array(
          $type => $message
        );
        $session=Session::getInstance();
        if ($session->contient(self::$cleFlash)){
            $array=MessageFlash::lireMessages(self::$cleFlash);
            $array[$type]=$message;
        }
        $session->enregistrer(self::$cleFlash,$array);
    }

    public static function contientMessage(string $type): bool
    {
        // À compléter
            $session = Session::getInstance();
            if ($session->contient(self::$cleFlash)) {
                $array = $session->lire(self::$cleFlash);
                return isset($array[$type]);
            }
            return false;
    }

    // Attention : la lecture doit détruire le message
    public static function lireMessages(string $type):array
    {
        // À compléter
        $session=Session::getInstance();
        $array= array();
        if ($session->contient(self::$cleFlash)) {
            $array = $session->lire(self::$cleFlash);
            foreach ($array as $typ=>$message){
                if ($typ==$type) $array[]=$message;
            }
        }
        $session->supprimer(self::$cleFlash);
        return$array;
    }

    public static function lireTousMessages() : array
    {
        // À compléter
        $session=Session::getInstance();
        if($session->contient(self::$cleFlash)) {
            $array = $session->lire(self::$cleFlash);
            $session->supprimer(self::$cleFlash);
            return $array;
        }
        return array();
    }

}