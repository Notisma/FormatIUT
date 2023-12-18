<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurEntrMain;
use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

class ServiceMdp
{
    /**
     * @return void envoie un mail pour réinitialiser le mot de passe d'un compte Entreprise
     */
    public static function mdpOublie(): void
    {
        if (isset($_REQUEST["mail"])) {
            $liste = ((new EntrepriseRepository())->getListeObjet());
            $listeMail = null;
            foreach ($liste as $entreprise) {
                $listeMail[] = $entreprise->getEmail();
            }
            //vérification de doublon de mail
            if (in_array($_REQUEST["mail"], $listeMail)) {
                $entreprise = (new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["mail"]);
                $entreprise->setNonce(MotDePasse::genererChaineAleatoire());
                (new EntrepriseRepository())->modifierObjet($entreprise);
                VerificationEmail::envoyerMailMdpOublie($entreprise);
                ControleurMain::afficherIndex();
            } else {
                ControleurMain::redirectionFlash("afficherPageConnexion", "warning", "Cette adresse mail n'existe pas");
            }
        }
    }

    /**
     * @return void permet à l'utilisateur de réinitialiser son mot de passe
     */
    public static function resetMdp(): void
    {
        if (isset($_REQUEST["mdp"], $_REQUEST["confirmerMdp"])) {
            $entreprise = (new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["login"]);
            if ($_REQUEST["nonce"] == $entreprise->getNonce()) {
                if ($_REQUEST["mdp"] == $_REQUEST["confirmerMdp"]) {
                    if (strlen($_REQUEST["mdp"]) >= 8) {
                        $entreprise->setMdpHache(MotDePasse::hacher($_REQUEST["mdp"]));
                        $entreprise->setNonce(MotDePasse::genererChaineAleatoire(22));
                        (new EntrepriseRepository())->modifierObjet($entreprise);
                        ControleurMain::redirectionFlash("afficherPageConnexion", "success", "Mot de passe modifié");
                    } else {
                        ControleurMain::redirectionFlash("motDePasseARemplir", "warning", "Le mot de passe doit faire plus de 7 caractères");
                    }
                } else {
                    ControleurMain::redirectionFlash("motDePasseARemplir", "warning", "Les mots de passe doivent corréler");
                }
            } else {
                ControleurMain::redirectionFlash("motDePasseARemplir", "danger", "Lien invalide. Veuillez réessayer");
            }
        }
    }

    /**
     * @return void affiche la vue pour réinitialiser le mot de passe
     */
    public static function motDePasseARemplir(): void
    {
        if (!isset($_REQUEST["login"], $_REQUEST["nonce"]))
            ControleurMain::afficherErreur("Lien corrompu (à transformer en flash, pb de \$_GET)");
        else
            //TODO créer fonction afficherMdpOublie
            ControleurMain::afficherVue("Mot de Passe oublié", "Entreprise/vueResetMdp.php", self::getMenu());
    }

    /**
     * @return void met à jour le mot de passe pour une entreprise
     */
    public static function mettreAJourMdp() : void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Entreprise") {
            if (isset($_POST['ancienMdp'], $_POST['nouveauMdp'], $_POST['confirmerMdp'])) {
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getNumEntrepriseConnectee());

                if (MotDePasse::verifier($_POST['ancienMdp'], $entreprise->getMdpHache())) {

                    if ($_POST['nouveauMdp'] === $_POST['confirmerMdp']) {
                        $hashedPassword = MotDePasse::hacher($_POST['nouveauMdp']);
                        $entreprise->setMdpHache($hashedPassword);
                        (new EntrepriseRepository())->modifierObjet($entreprise);
                        ControleurEntrMain::redirectionFlash("afficherProfil", "success", "Mot de passe mis à jour");
                    } else {
                        ControleurEntrMain::redirectionFlash("afficherProfil", "warning", "Les mots de passe ne correspondent pas");
                    }
                } else {
                    ControleurEntrMain::redirectionFlash("afficherProfil", "warning", "Ancien mot de passe incorrect");
                }
            } else {
                ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Des données sont manquantes");
            }
        } else {
            ControleurEntrMain::redirectionFlash("afficherProfil", "danger", "Vous n'avez pas les droits requis");
        }
    }

}