<?php

namespace App\FormatIUT\Service;

use App\FormatIUT\Controleur\ControleurAdminMain;
use App\FormatIUT\Controleur\ControleurEtuMain;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

class ServiceEtudiant
{
    /**
     * @return void permet à l'admin connecté d'ajouter un étudiant avec ses informations primordiales
     */

    public static function ajouterEtudiant(): void
    {
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            if ((new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtudiant']) != null) {
                ControleurAdminMain::redirectionFlash("afficherFormulaireCreationEtudiant", "warning", "Un étudiant avec ce numéro existe déjà");
            } else {
                $etudiant=Etudiant::creerEtudiant($_REQUEST);
                (new EtudiantRepository())->creerObjet($etudiant);
                ControleurAdminMain::redirectionFlash("afficherAccueilAdmin", "success", "L'étudiant a bien été ajouté");
            }
        }
    }


    /**
     * @return void permet à l'admin connecté de supprimer(archiver) un étudiant
     */
    public static function supprimerEtudiant(): void
    {
        if (isset($_REQUEST["numEtu"])) {
            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtu']);
            if (!is_null($etudiant)) {
                if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                    (new EtudiantRepository())->supprimer($_REQUEST['numEtu']);
                    ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "success", "L'étudiant a bien été supprimé");
                } else ControleurAdminMain::redirectionFlash("afficherDetailEtudiant", "danger", "Vous n'avez pas les droits requis");
            } else ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "warning", "L'étudiant n'existe pas");
        } else ControleurAdminMain::redirectionFlash("afficherListeEtudiant", "danger", "L'étudiant n'est pas renseigné");

    }

    /**
     * @return void met à jour les informations de l'étudiant connecté
     */
    public static function mettreAJour(): void
    {
    //TODO vérifier utilisé fonction mettreAJourInfos
        (new EtudiantRepository())->mettreAJourInfos($_REQUEST['mailPerso'], $_REQUEST['numTel'], $_REQUEST['numEtu']);
        ControleurEtuMain::afficherProfil();
    }
}