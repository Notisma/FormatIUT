<?php
namespace App\FormatIUT\Lib;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Entreprise $entreprise): void
    {
        $siretURL = rawurlencode($entreprise->getSiret());
        $nonceURL = rawurlencode($entreprise->getNonce());
        $absoluteURL = Configuration::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=validerEmail&controleur=Main&login=$siretURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation</a>";

        // Temporairement avant d'envoyer un vrai mail
        MessageFlash::ajouter("info", $corpsEmail);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        // À compléter
        $user =(new EntrepriseRepository())->getObjectParClePrimaire($login);
        if (!is_null($user)){
            if ($user->formatTableau()["nonce"]==$nonce){
                $user->setEmail($user->getEmailAValider());
                $user->setEmailAValider("");
                $user->setNonce("");
                (new EntrepriseRepository())->modifierObjet($user);
                return true;
            }
        }
        return false;
    }

    public static function aValideEmail(Entreprise $entreprise) : bool
    {
        // À compléter
        if ($entreprise->getEmail()!="") return true;
        return false;
    }
}