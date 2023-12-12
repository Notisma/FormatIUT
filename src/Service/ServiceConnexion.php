<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Lib\VerificationEmail;
use App\FormatIUT\Modele\DataObject\Entreprise;
use App\FormatIUT\Modele\HTTP\Session;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\ProfRepository;

class ServiceConnexion
{
    /**
     * @return void action connectant l'utilisateur
     */
    public static function seConnecter(): void
    {
        if (isset($_REQUEST["login"], $_REQUEST["mdp"])) {
            $user = ((new EntrepriseRepository())->getEntrepriseParMail($_REQUEST["login"]));
            if (!is_null($user)) {
                self::connexionEntreprise($user);
            } else if (ConnexionLdap::connexion($_REQUEST["login"], $_REQUEST["mdp"], "connexion")) {
                self::connexionLDAP();
            } else if ($_REQUEST["login"] == "ProfTest") {
                self::connexionProfTest();
            } else if ($_REQUEST["login"] == "AdminTest") {
                self::connexionAdminTest();
            }
        }
        header("Location: controleurFrontal.php?controleur=Main&action=afficherPageConnexion&erreur=1");
    }


    /**
     * @return void déconnecte l'utilisateur
     */
    public static function seDeconnecter(): void
    {
        ConnexionUtilisateur::deconnecter();
        Session::getInstance()->detruire();
        ControleurMain::redirectionFlash("afficherIndex", "info", "Vous êtes déconnecté");
    }

    /**
     * @return void gère la connexion pour le ProfTest
     */

    private static function connexionProfTest() :void
    {
        if (MotDePasse::verifier($_REQUEST["mdp"], '$2y$10$oBxrVTdMePhNpS5y4SzhHefAh7HIUrbzAU0vSpfBhDFUysgu878B2')) {
            ConnexionUtilisateur::connecter($_REQUEST["login"], "Personnels");
            MessageFlash::ajouter("success", "Connexion Réussie");
            header("Location:controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
            exit();
        }
    }

    /**
     * @return void gère la connexion pour l'AdminTest
     */
    private static function connexionAdminTest() : void
    {
        if (MotDePasse::verifier($_REQUEST["mdp"], '$2y$10$oBxrVTdMePhNpS5y4SzhHefAh7HIUrbzAU0vSpfBhDFUysgu878B2')) {
            ConnexionUtilisateur::connecter($_REQUEST["login"], "Administrateurs");
            MessageFlash::ajouter("success", "Connexion Réussie");
            header("Location:controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
            exit();
        }
    }

    /**
     * @return void gère la connexion pour les entreprises
     */
    private static function connexionEntreprise(Entreprise $user) :void
    {
        if (MotDePasse::verifier($_REQUEST["mdp"], $user->getMdpHache())) {
            if (VerificationEmail::aValideEmail($user)) {
                ConnexionUtilisateur::connecter($user->getSiret(), "Entreprise");
                MessageFlash::ajouter("success", "Connexion Réussie");
                header("Location: controleurFrontal.php?action=afficherAccueilEntr&controleur=EntrMain");
                exit();
            }
        }
    }

    /**
     * @return void gère la connexion pour les étudiants
     */
    private static function connexionEtudiant():void
    {
        if (ConnexionUtilisateur::premiereConnexionEtu($_REQUEST["login"])) {
            MessageFlash::ajouter('info', "Veuillez compléter votre profil");
            header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain&premiereConnexion=true");
        }else {
            header("Location: controleurFrontal.php?action=afficherAccueilEtu&controleur=EtuMain");
        }
        exit();

    }

    private static function connexionPersonnel():void
    {
        $prof = (new ProfRepository())->getObjectParClePrimaire($_REQUEST["login"]);
        if (!is_null($prof)) {
            if ($prof->isEstAdmin()) {
                ConnexionUtilisateur::connecter($_REQUEST["login"], "Administrateurs");
                header("Location : controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
            }else {
                header("Location : controleurFrontal.php?action=afficherAccueilAdmin&controleur=AdminMain");
            }
            exit();
        }
    }

    private static function connexionLDAP():void
    {
        ConnexionUtilisateur::connecter($_REQUEST['login'], ConnexionLdap::getInfoPersonne()["type"]);
        MessageFlash::ajouter("success", "Connexion Réussie");
        if (ConnexionUtilisateur::getTypeConnecte()=="Etudiants"){
            self::connexionEtudiant();
        }else {
            self::connexionPersonnel();
        }
    }

    /**
     * @return void valide l'email grâce au lien envoyé par mail
     */
    public static function validerEmail(): void
    {
        VerificationEmail::traiterEmailValidation($_REQUEST["login"], $_REQUEST["nonce"]);
        ControleurMain::redirectionFlash("afficherPageConnexion", "success", "Email validé");
    }

}