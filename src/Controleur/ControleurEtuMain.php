<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\Repository\OffreRepository;

class ControleurEtuMain extends ControleurMain
{
    public static function afficherAccueilEtu(){
        $listeIdAlternance=(new OffreRepository())->ListeIdTypeOffre("Alternance");
        $listeIdStage=(new OffreRepository())->ListeIdTypeOffre("Stage");
        for ($i=0;$i<3;$i++){
            $listeStage[]=(new OffreRepository())->getOffre($listeIdStage[$i]);
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

    public static function getMenu(): array
    {
        return array(
            array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Etudiants","lien"=>"?action=afficherAccueilEtu&controleur=EtuMain"),
            array("image"=>"../ressources/images/mallette.png","label"=>"Offres d'Alternance","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/stage.png","label"=>"Offres de Stage","lien"=>"?action=afficherCatalogue&controleur=EtuMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"controleurFrontal.php")
        );
    }

    private static function getTroisMax(array $liste) : array{
        for ( $i=0;$i<3;$i++){
            $id=max($liste);
            foreach ($liste as $item=>$value) {
                if ($value==$id) $key=$item;
            }
            unset($liste[$key]);
            $list[]=$id;
        }
        return $list;
    }

}