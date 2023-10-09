<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurEtuMain extends ControleurMain
{
    private static  $idEtu=321444;

    public static function afficherAccueilEtu(){
        $listeIdAlternance=self::getTroisMax((new OffreRepository())->ListeIdTypeOffre("Alternance"));
        $listeIdStage=self::getTroisMax((new OffreRepository())->ListeIdTypeOffre("Stage"));
        $listeStage=array();
        for ($i=0;$i<sizeof($listeIdStage);$i++){
            $listeStage[]=(new OffreRepository())->getOffre($listeIdStage[$i]);
        }
        $listeAlternance=array();
        for ($i=0;$i<sizeof($listeIdAlternance);$i++){
            $listeAlternance[]=(new OffreRepository())->getOffre($listeIdAlternance[$i]);
        }
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Etudiant/vueAccueilEtudiant.php","titrePage"=>"Accueil Etudiants","listeStage"=>$listeStage,"listeAlternance"=>$listeAlternance]);
    }
    public static function afficherCatalogue(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Etudiant/vueCatalogueOffre.php","titrePage"=>"Liste des Offres"]);
    }
    public static function afficherProfilEtu(){
        self::afficherVue("vueGenerale.php", ["menu"=>self::getMenu(), "chemin"=> "Etudiant/vueCompteEtudiant.php", "titrePage" => "Compte étudiant"]);
    }

    public static function postuler(){
        (new EtudiantRepository())->EtudiantPostuler(self::$idEtu,$_GET['idOffre']);
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