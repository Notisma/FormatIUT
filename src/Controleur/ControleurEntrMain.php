<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;


class ControleurEntrMain extends ControleurMain
{
    private static float $cleEntreprise = 76543128904567;

    public static function getCleEntreprise(): float
    {
        return self::$cleEntreprise;
    }

    public static function afficherAccueilEntr()
    {
        $listeIDOffre = self::getTroisMax((new OffreRepository())->ListeIdOffreEntreprise(self::$cleEntreprise));
        $listeOffre = array();
        for ($i = 0; $i < sizeof($listeIDOffre); $i++) {
            $listeOffre[] = (new OffreRepository())->getObjectParClePrimaire($listeIDOffre[$i]);
        }
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Entreprise/vueAccueilEntreprise.php", "titrePage" => "Accueil Entreprise", "listeOffre" => $listeOffre]);
    }

    public static function formulaireCreationOffre()
    {
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Entreprise/formulaireCreationOffre.php", "titrePage", "titrePage" => "Créer une offre"]);
    }

    public static function creerOffre()
    {
        //TODO faire toutes les vérif liés à la BD, se référencier aux td de web
        if (isset($_POST['nomOffre'],$_POST["dateDebut"],$_POST["dateFin"],$_POST["sujet"],$_POST["detailProjet"],$_POST["gratification"],$_POST['dureeHeures'],$_POST["joursParSemaine"],$_POST["nbHeuresHebdo"],$_POST["typeOffre"])){
            if ($_POST["dateDebut"]>$_POST["dateFin"]){
                //vérif des nbHeures ? ce serait compliqué
                $listeId = (new OffreRepository())->getListeIdOffres();
                self::autoIncrement($listeId,"idOffre");
                $_POST["idEntreprise"] = self::$cleEntreprise;
                $offre = (new OffreRepository())->construireDepuisTableau($_POST);
                (new OffreRepository())->creerObjet($offre);
                self::MesOffres();
            }else {
                //redirectionFlash "Concordance des dates
                self::formulaireCreationOffre();
            }
        }else {
            //redirectionFlash "éléments manquants
            self::formulaireCreationOffre();
        }

    }

    public static function MesOffres()
    {
        if (!isset($_GET["type"])) {
            $_GET["type"] = "Tous";
        }
        $liste = (new OffreRepository())->getListeOffreParEntreprise("76543128904567", $_GET["type"]);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Entreprise/vueMesOffres.php", "menu" => self::getMenu(), "type" => $_GET["type"], "listeOffres" => $liste]);
    }

    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=MesOffres&type=Tous&controleur=EntrMain"),
            array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php")

        );
    }

    public static function afficherProfilEntr()
    {
            $entreprise=(new EntrepriseRepository())->getObjectParClePrimaire(self::$cleEntreprise);
            self::afficherVue("vueGenerale.php", ["entreprise"=>$entreprise,"menu" => self::getMenu(), "chemin" => "Entreprise/vueCompteEntreprise.php", "titrePage" => "Compte Entreprise"]);
    }

    public static function assignerEtudiantOffre()
    {
        //TODO vérif que l'étudiant n'a pas dèjà une offre
        $id = "F" . self::autoIncrement((new FormationRepository())->ListeIdTypeFormation(), "idFormation");
        $offre = (new OffreRepository())->getObjectParClePrimaire($_GET["idOffre"]);
        $assign = array("idFormation" => $id, "dateDebut" => $offre->getDateDebut(), "dateFin" => $offre->getDateFin(), "idEtudiant" => $_GET["idEtudiant"], "idEntreprise" => self::$cleEntreprise, "idOffre" => $_GET["idOffre"]);
        (new FormationRepository())->assigner($assign);
        self::afficherAccueilEntr();
    }

    private static function autoIncrement($listeId, $get): int
    {
        $id = 1;
        while (!isset($_POST[$get])) {
            if (in_array($id, $listeId)) {
                $id++;
            } else {
                $_POST[$get] = $id;
            }
        }
        return $id;
    }

    public static function UpdateImage()
    {
        $id=self::autoIncrement((new ImageRepository())->listeID(),"img_id");
        //TODO drop ancienne image & vérif de doublons d'image
        parent::insertImage(self::$cleEntreprise);
        (new EntrepriseRepository())->updateImage(self::$cleEntreprise,$id);
        self::afficherProfilEntr();
    }

}