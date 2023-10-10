<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurEtuMain extends ControleurMain
{
    private static  $idEtu=22202117;

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
    public static function afficherCatalogue(){
       $image= (new ImageRepository())->getImage(1);
        var_dump($image);
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Etudiant/vueCatalogueOffre.php","titrePage"=>"Liste des Offres"]);
    }
    public static function afficherProfilEtu(){
        self::afficherVue("vueGenerale.php", ["menu"=>self::getMenu(), "chemin"=> "Etudiant/vueCompteEtudiant.php", "titrePage" => "Compte étudiant"]);
    }

    public static function postuler(){
        //TODO toutes les vérif
        if (isset($_GET['idOffre'])) {
            $offre=((new OffreRepository())->getObjectParClePrimaire($_GET['idOffre']));
            $formation=((new FormationRepository())->estFormation($offre));
            if (is_null($formation)){
                if (!(new EtudiantRepository())->aUneFormation(self::$idEtu)){
                    if ((new EtudiantRepository())->aPostuler(self::getIdEtu(),$_GET['idOffre'])){
                        //redirectionFlash "vous avez déjà postuler
                    }else {
                        (new EtudiantRepository())->EtudiantPostuler(self::$idEtu, $_GET['idOffre']);
                    }
                }else {
                    //redirectionFlash "vous avez déjà une formation
                }
            }else{
                if ($formation->getIdEtudiant()==self::getIdEtu()){
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

    public static function getMenu(): array
    {
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Etudiants","lien"=>"?action=afficherAccueilEtu&controleur=EtuMain"),
            array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/stage.png","label"=>"Offres de Stage","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"controleurFrontal.php")
        );
    }

    public static function getIdEtu(): int
    {
        return self::$idEtu;
    }



}