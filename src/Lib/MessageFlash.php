<?php

namespace App\FormatIUT\Lib;

use App\FormatIUT\Modele\HTTP\Session;

class MessageFlash
{

    private static string $cleFlash = "_messagesFlash";

    /**
     * @param string $type
     * @param string $message
     * @return void ajoute un message flash dans la session
     */
    public static function ajouter(string $type, string $message): void
    {
        $array = array(
            $type => $message
        );
        $session = Session::getInstance();
        if ($session->contient(self::$cleFlash)) {
            $array = MessageFlash::lireMessages(self::$cleFlash);
            $array[$type] = $message;
        }
        $session->enregistrer(self::$cleFlash, $array);
    }


    /**
     * @param string $type
     * @return array retourne un tableau contenant les messages flash du type $type
     */
    public static function lireMessages(string $type): array
    {
        $session = Session::getInstance();
        $array = array();
        if ($session->contient(self::$cleFlash)) {
            $array = $session->lire(self::$cleFlash);
            foreach ($array as $typ => $message) {
                if ($typ == $type) $array[] = $message;
            }
        }
        $session->supprimer(self::$cleFlash);
        return $array;
    }

    /**
     * @return array retourne un tableau contenant tous les messages flash
     */
    public static function lireTousMessages(): array
    {
        $session = Session::getInstance();
        if ($session->contient(self::$cleFlash)) {
            $array = $session->lire(self::$cleFlash);
            $session->supprimer(self::$cleFlash);
            return $array;
        }
        return array();
    }


    /**
     * @return bool permet de savoir si un message flash est présent dans la session
     */
    public static function verifDeconnexion() : bool{
        $message=self::lireMessages("info");
        if (!str_contains($message["info"],"Vous avez été déconnecté")){
            self::ajouter("danger", "Veuillez vous connecter");
        }
        MessageFlash::ajouter("info",$message["info"]);
        return true;
    }

}