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
        mail($entreprise->getEmail(),"Validation Mot de Passe",$corpsEmail,"From: FormatIUT");
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
    public static function EnvoyerMailMdpOublie(Entreprise $entreprise){
        $siretURL = rawurlencode($entreprise->getEmail());
        $nonceURL = rawurlencode($entreprise->getNonce());
        $absoluteURL = Configuration::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=motDePasseARemplir&controleur=Main&login=$siretURL&nonce=$nonceURL";
        $corpsEmail = "<p>Ceci est un test !</p><a href=\"$lienValidationEmail\">MODIFIER LE MOT DE PASSE</a> <p>J'aime la saé !</p>";

        // Temporairement avant d'envoyer un vrai mail
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        mail($entreprise->getEmail(),"Réinitialisation de mot de passe",self::squeletteCorpsMail("MOT DE PASSE OUBLIE", $corpsEmail),"From: formatiut@gmail.com", implode("\r\n", $headers));

        MessageFlash::ajouter("info", $corpsEmail);
    }
    public static function traiterEmailMdpOublie($login, $nonce): bool
    {
        // À compléter
        $user =(new EntrepriseRepository())->getObjectParClePrimaire($login);
        if (!is_null($user)){
            if ($user->formatTableau()["nonce"]==$nonce){

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


    public static function squeletteCorpsMail(String $titre, String $message) : String {
        return '
        <html lang="fr">
            <head>
                <link rel="stylesheet" href="../ressources/css/styleMail.css">
            </head>
            <body>
               <div class="wrapHeadMail">
                   <div>
                      <img src="../ressources/images/logo_IUT.png" alt="logo IUT" class="logoIUT">
                        <h1>FormatIUT</h1>        
                   </div>
                   <div>
                      <h1>' . $titre . ' - FormatIUT</h1>
                   </div>
               </div>           
                  
</div>
            
            
     
                <div class="corpsMessage">
                    ' . $message . '
                    <h3>Cet email a été envoyé automatiquement. Merci de ne pas y répondre.</h3>
                </div>
            </body>
        </html>
        ';
    }
}