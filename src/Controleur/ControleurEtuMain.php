<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\Repository\RegarderRepository;

class ControleurEtuMain extends ControleurMain
{
    private static int $cleEtudiant=22206782;

    public static function getCleEtudiant(): int
    {
        return self::$cleEtudiant;
    }

    public static function afficherAccueilEtu(){
        $listeIdAlternance=self::getTroisMax((new OffreRepository())->ListeIdTypeOffre("Alternance"));
        $listeIdStage=self::getTroisMax((new OffreRepository())->ListeIdTypeOffre("Stage"));
        $listeStage=array();
        for ($i=0;$i<sizeof($listeIdStage);$i++){
            $listeStage[]=(new OffreRepository())->getObjectParClePrimaire($listeIdStage[$i]);
        }
        $listeAlternance=array();
        for ($i=0;$i<sizeof($listeIdAlternance);$i++){
            $listeAlternance[]=(new OffreRepository())->getObjectParClePrimaire($listeIdAlternance[$i]);
        }
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Etudiant/vueAccueilEtudiant.php","titrePage"=>"Accueil Etudiants","listeStage"=>$listeStage,"listeAlternance"=>$listeAlternance]);
    }
    public static function afficherCatalogue() {
        $type = $_GET["type"] ?? "Tous";
        $offres = (new OffreRepository())->getListeOffresDispoParType($type);
        self::afficherVueDansCorps("Offres de Stage/Alternance", "Etudiant/vueCatalogueOffre.php", self::getMenu(), ["offres" => $offres, "type" => $type]);
    }
    public static function afficherProfilEtu() {
        $etudiant=((new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant));
        self::afficherVue("vueGenerale.php", ["etudiant"=>$etudiant,"menu"=>self::getMenu(), "chemin"=> "Etudiant/vueCompteEtudiant.php", "titrePage" => "Compte étudiant"]);
    }
    public static function afficherMesOffres(){
        $listOffre = (new OffreRepository())->listOffreEtu(self::$cleEtudiant);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Etudiant/vueMesOffresEtu.php", "menu" => self::getMenu(), "listOffre" =>$listOffre, "numEtu"=>self::$cleEtudiant]);
    }

    public static function validerOffre(){
        if (isset($_GET['idOffre'])) {
            $listeId=((new OffreRepository())->getListeIdOffres());
            $idOffre = $_GET['idOffre'];
            if (in_array($idOffre,$listeId)) {
                $formation=((new FormationRepository())->estFormation($idOffre));
                if (!(new EtudiantRepository())->aUneFormation(self::$cleEtudiant)) {
                    if (is_null($formation)) {
                        if ((new RegarderRepository())->getEtatEtudiantOffre(self::$cleEtudiant, $idOffre) == "A Choisir") {
                            (new RegarderRepository())->validerOffreEtudiant(self::$cleEtudiant, $idOffre);
                            $offre=((new OffreRepository())->getObjectParClePrimaire($idOffre));
                            $idFormation="F".self::autoIncrement(((new FormationRepository())->ListeIdTypeFormation()),"idFormation");
                            $formation=(new FormationRepository())->construireDepuisTableau(["idFormation"=>$idFormation,"dateDebut"=>date_format($offre->getDateDebut(),"Y-m-d"),"dateFin"=>date_format($offre->getDateFin(),'Y-m-d'),"idEtudiant"=>self::$cleEtudiant,"idEntreprise"=>$offre->getSiret(),"idOffre"=>$idOffre,"idTuteurPro"=>null,"idConvention"=>null,"idTuteurUM"=>null]);
                            (new FormationRepository())->creerObjet($formation);
                            self::afficherMesOffres();
                        } else {
                            self::afficherErreur("Vous n'êtes pas en état de choisir pour cette offre");
                        }
                    } else {
                        self::afficherErreur("Cette Offre est déjà assignée");
                    }
                }else {
                    self::afficherErreur("Vous avez déjà une Offre assignée");
                }
            }else {
                self::afficherErreur("Offre non existante");
            }
        }else {
            self::afficherErreur("Données Manquantes");
        }
    }

    public static function postuler(){
        //TODO vérifier les vérifs
        if (isset($_GET['idOffre'])) {
            $liste=((new OffreRepository())->getListeIdOffres());
            if (in_array($_GET["idOffre"],$liste)) {
                $formation = ((new FormationRepository())->estFormation($_GET['idOffre']));
                if (is_null($formation)) {
                    if (!(new EtudiantRepository())->aUneFormation(self::$cleEtudiant)) {
                        if ((new EtudiantRepository())->aPostuler(self::$cleEtudiant, $_GET['idOffre'])) {
                            self::afficherErreur("Vous avez déjà postulé");
                        } else {
                            (new EtudiantRepository())->EtudiantPostuler(self::$cleEtudiant, $_GET['idOffre']);
                            $_GET['action'] = "afficherVueDetailOffre";
                            self::afficherVueDetailOffre();
                        }
                    } else {
                        self::afficherErreur("Vous avez déjà une formation");
                    }
                } else {
                    if ($formation->getIdEtudiant() == self::getCleEtudiant()) {
                        self::afficherErreur("Vous avez déjà cette Formation");
                    } else {
                        self::afficherErreur("Cette offre est déjà assignée");
                    }
                }
            }else {
                self::afficherErreur("Offre inexistante");
            }
        }else {
            self::afficherErreur("Données Manquantes");
        }
    }

    public static function updateImage()
    {
        $id=self::autoIncrement((new ImageRepository())->listeID(),"img_id");
        //TODO vérif de doublons d'image
        $etudiant=((new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant));
        $nom="";
        $nomEtudiant=$etudiant->getLogin();
        for ($i=0;$i<strlen($etudiant->getLogin());$i++){
            if ($nomEtudiant[$i]==' '){
                $nom.="_";
            }else {
                $nom.=$nomEtudiant[$i];
            }
        }
        $nom.="_logo";
        $estPasse = parent::insertImage($nom);
        if (!$estPasse) self::afficherProfilEtu();
        $ancienId=(new ImageRepository())->imageParEtudiant(self::$cleEtudiant);
        (new EtudiantRepository())->updateImage(self::$cleEtudiant,$id);
        if ($ancienId["img_id"]!=1 && $ancienId["img_id"]!=0) (new ImageRepository())->supprimer($ancienId["img_id"]);
        self::afficherProfilEtu();
    }

    public static function getMenu(): array
    {
        $menu= array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Etudiants", "lien" => "?action=afficherAccueilEtu&controleur=EtuMain"),
            //array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/stage.png", "label" => "Offres de Stage/Alternance", "lien" => "?action=afficherCatalogue&controleur=EtuMain"),
            array("image" => "../ressources/images/signet.png", "label" => "Mes Offres", "lien" => "?action=afficherMesOffres&controleur=EtuMain"),

        );
        $formation=(new EtudiantRepository())->aUneFormation(self::$cleEtudiant);
        if ($formation){
            $menu[]=array("image"=>"../ressources/images/mallette.png","label"=>" Mon Offre","lien"=>"?action=afficherVueDetailOffre&controleur=EtuMain&idOffre=".$formation['idOffre']);
        }
        $menu[]=array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php");
        return $menu;
    }



}