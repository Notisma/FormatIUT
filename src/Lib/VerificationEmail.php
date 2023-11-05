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
        $corpsEmail = "<h2>Vous avez demandé la création de votre compte sur l'application Format'IUT.</h2><p>Cliquez sur le lien ci-dessous pour valider votre adresse mail.</p><a style='color: blue; text-decoration: underline;'  href=\"$lienValidationEmail\">VALIDER</a> <p>L'équipe de Format'IUT vous souhaite une bonne journée !</p>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8-general-ci';

        mail($entreprise->getEmailAValider(), "Validation adresse email", self::squeletteCorpsMail("VALIDATION EMAIL", $corpsEmail), implode("\r\n", $headers));
        mail("formatiut@gmail.com", "reset mdp", "l'entreprise " . $entreprise->getNomEntreprise() . " a demandé un reset de mdp", implode("\r\n", $headers));

    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        // À compléter
        $user = (new EntrepriseRepository())->getObjectParClePrimaire($login);
        if (!is_null($user)) {
            if ($user->formatTableau()["nonce"] == $nonce) {
                $user->setEmail($user->getEmailAValider());
                $user->setEmailAValider("");
                $user->setNonce("");
                (new EntrepriseRepository())->modifierObjet($user);
                return true;
            }
        }
        return false;
    }

    public static function EnvoyerMailMdpOublie(Entreprise $entreprise): void
    {
        $mailURL = rawurlencode($entreprise->getEmail());
        $nonceURL = rawurlencode($entreprise->getNonce());
        $absoluteURL = Configuration::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=motDePasseARemplir&controleur=Main&login=$mailURL&nonce=$nonceURL";
        $corpsEmail = "<h2>Vous avez demandé la réinitialisation de votre mot de passe de l'application Format'IUT.</h2><p>Cliquez sur le lien ci-dessous pour réinitialiser votre mot de passe.</p><a style='color: blue; text-decoration: underline;'  href=\"$lienValidationEmail\">MODIFIER LE MOT DE PASSE</a> <p>L'équipe de Format'IUT vous souhaite une bonne journée !</p>";
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8-general-ci';

        mail($entreprise->getEmail(), "Reinitialisation de mot de passe", self::squeletteCorpsMail("MOT DE PASSE OUBLIE", $corpsEmail), implode("\r\n", $headers));
        mail("formatiut@gmail.com", "reset mdp", "l'entreprise " . $mailURL . " a demandé un reset de mdp", implode("\r\n", $headers));

        MessageFlash::ajouter("info", "Un email vous a bien été envoyé");
    }

    public static function traiterEmailMdpOublie($login, $nonce): bool
    {
        // À compléter
        $user = (new EntrepriseRepository())->getObjectParClePrimaire($login);
        if (!is_null($user)) {
            if ($user->formatTableau()["nonce"] == $nonce) {

                (new EntrepriseRepository())->modifierObjet($user);
                return true;
            }
        }
        return false;
    }

    public static function aValideEmail(Entreprise $entreprise): bool
    {
        //TODO À compléter
        if ($entreprise->getEmail() != "") return true;
        return false;
    }


    public static function squeletteCorpsMail(string $titre, string $message): string
    {
        $police = "'Oswald'";
        $apostrophe = "'";
        return '
        <html lang="fr">
            <head>
                <link rel="stylesheet" href="https://webinfo.iutmontp.univ-montp2.fr/~loyet/2S5t5RAd2frMP6/ressources/css/styleMail.css">
                <style>
                @font-face {
                    font-family: "Oswald";
                    src: url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");                
                }
            </style>
            </head>
            <body style="height: 100%;
    width: 100%;">
               <div class="wrapHeadMail" style="display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    height: 30%;
    width: 100%;">
                   <div style="display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 50%;">
                      <img src="https://webinfo.iutmontp.univ-montp2.fr/~loyet/2S5t5RAd2frMP6/ressources/images/LogoIutMontpellier-removed.png" style="width: 70%;">
                        <h1>FormatIUT</h1>        
                   </div>
                   <div style="display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 50%;">
                      <h1 style="font-family: ' . $police . ', sans-serif;
    color: #ff5660;
    margin-top: 3%;
    letter-spacing: 0.04em;">' . $titre . ' - FormatIUT</h1>
                   </div>
               </div>           
                  
</div>
            
            
     
                <div class="corpsMessage" style="display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 70%;
    width: 100%;">
                    ' . $message . '
                    <h3>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</h3>
                </div>
            </body>
        </html>
        ';
    }
}