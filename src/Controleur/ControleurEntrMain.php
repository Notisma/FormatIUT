<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\Repository\ConnexionBaseDeDonnee;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
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
            //if (strtotime($_POST["dateDebut"]) > strtotime($_POST["dateFin"])){
                //vérif des nbHeures ? ce serait compliqué
                $listeId = (new OffreRepository())->getListeIdOffres();
                self::autoIncrement($listeId,"idOffre");
                $_POST["idEntreprise"] = self::$cleEntreprise;
                $offre = (new OffreRepository())->construireDepuisTableau($_POST);
                (new OffreRepository())->creerObjet($offre);
                self::mesOffres();
            /*}else {
                //redirectionFlash "Concordance des dates
                echo "dates";
                self::formulaireCreationOffre();
            }*/
        }else {
            //redirectionFlash "éléments manquants
            self::afficherErreur("Des données sont manquantes");
        }

    }

    public static function mesOffres()
    {
        if (!isset($_GET["type"])) {
            $_GET["type"] = "Tous";
        }
        if (!isset($_GET["Etat"])){
            $_GET["Etat"]= "Tous";
        }
        $liste = (new OffreRepository())->getListeOffreParEntreprise(self::$cleEntreprise, $_GET["type"],$_GET["Etat"]);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Entreprise/vueMesOffres.php", "menu" => self::getMenu(), "type" => $_GET["type"], "listeOffres" => $liste,"Etat"=>$_GET["Etat"]]);
    }

    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=mesOffres&type=Tous&controleur=EntrMain"),
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
        //TODO vérifs
        if (isset($_GET["idEtudiant"],$_GET["idOffre"])){
            if (((new FormationRepository())->estFormation($_GET["idOffre"]))){
                self::afficherErreur("L'offre est déjà prise");
            }else{
                if (((new EtudiantRepository())->aUneFormation($_GET["idOffre"]))){
                    self::afficherErreur("L'étudiant a déjà une formation");
                }else {
                    if (((new EtudiantRepository())->EtudiantAPostuler($_GET["idEtudiant"],$_GET["idOffre"]))){
                        (new OffreRepository())->mettreAChoisir($_GET['idEtudiant'],$_GET["idOffre"]);
                        self::afficherAccueilEntr();
                    }else {
                        self::afficherErreur("L'étudiant n'es pas en Attente");
                    }

                }
            }
        }else {
            self::afficherErreur("Données Manquantes pour assigner un étudiant");
        }

    }

    public static function updateImage()
    {
        $id=self::autoIncrement((new ImageRepository())->listeID(),"img_id");
        //TODO vérif de doublons d'image
        $entreprise=((new EntrepriseRepository())->getObjectParClePrimaire(self::$cleEntreprise));
        $nom="";
        $nomEntreprise=$entreprise->getNomEntreprise();
        for ($i=0;$i<strlen($entreprise->getNomEntreprise());$i++){
            if ($nomEntreprise[$i]==' '){
                $nom.="_";
            }else {
                $nom.=$nomEntreprise[$i];
            }
        }
        $nom.="_logo";
        parent::insertImage($nom);
        $ancienId=(new ImageRepository())->imageParEntreprise(self::$cleEntreprise);
        (new EntrepriseRepository())->updateImage(self::$cleEntreprise,$id);
        (new ImageRepository())->supprimer($ancienId["img_id"]);
        self::afficherProfilEntr();
    }

    public static function supprimerOffre(){
        //TODO vérifs
        (new OffreRepository())->supprimer($_GET["idOffre"]);
        self::afficherAccueilEntr();
    }
}
