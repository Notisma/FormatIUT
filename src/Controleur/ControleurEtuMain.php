<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

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
        $offres = (new OffreRepository())->getListeIdOffres();
        self::afficherVueDansCorps("Liste des offres", "Etudiant/vueCatalogueOffre.php", self::getMenu(), ["offres" => $offres]);
    }
    public static function afficherProfilEtu() {
        $etudiant=((new EtudiantRepository())->getObjectParClePrimaire(self::$cleEtudiant));
        self::afficherVue("vueGenerale.php", ["etudiant"=>$etudiant,"menu"=>self::getMenu(), "chemin"=> "Etudiant/vueCompteEtudiant.php", "titrePage" => "Compte étudiant"]);
    }
    public static function afficherMesOffres(){
        $listOffre = (new OffreRepository())->listOffreEtu(self::$cleEtudiant);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Etudiant/vueMesOffresEtu.php", "menu" => self::getMenu(), "listOffre" =>$listOffre, "numEtu"=>self::$cleEtudiant]);
    }

    public static function postuler(){
        if (isset($_GET['idOffre'])) {
            $offre=((new OffreRepository())->getObjectParClePrimaire($_GET['idOffre']));
            $formation=((new FormationRepository())->estFormation($offre));
            if (is_null($formation)){
                if (!(new EtudiantRepository())->aUneFormation(self::$cleEtudiant)){
                    if ((new EtudiantRepository())->aPostuler(self::$cleEtudiant,$_GET['idOffre'])){
                        //redirectionFlash "vous avez déjà postuler
                    }else {
                        (new EtudiantRepository())->EtudiantPostuler(self::$cleEtudiant, $_GET['idOffre']);
                    }
                }else {
                    //redirectionFlash "vous avez déjà une formation
                }
            }else{
                if ($formation->getIdEtudiant()==self::getCleEtudiant()){
                    //redirectionFlash "vous y êtes en formation
                }else {
                    //redirectionFlash "cet offre est déjà assigné
                }
            }
        }else {
            //redirectionFlash "l'id n'est pas renseigné"
        }
        self::afficherAccueilEtu();
    }

    public static function UpdateImage()
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
        parent::insertImage($nom);
        $ancienId=(new ImageRepository())->imageParEtudiant(self::$cleEtudiant);
        (new EtudiantRepository())->updateImage(self::$cleEtudiant,$id);
        (new ImageRepository())->supprimer($ancienId["img_id"]);
        self::afficherProfilEtu();
    }

    public static function getMenu(): array
    {
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Etudiants","lien"=>"?action=afficherAccueilEtu&controleur=EtuMain"),
            //array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/stage.png","label"=>"Offres de Stage/Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/signet.png","label"=>"Mes Offres", "lien"=>"?action=afficherMesOffres&controleur=EtuMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"controleurFrontal.php")

        );
    }



}