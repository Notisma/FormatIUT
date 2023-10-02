<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Modele\Repository\AlternanceRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;
use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\Repository\StageRepository;

class ControleurEntrMain extends ControleurMain
{

    public static function afficherAccueilEntr(){
    self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Entreprise/vueAccueilEntreprise.php","titrePage"=>"Accueil Entreprise"]);
    }

    public static function formulaireCreationOffre(){
        self::afficherVue("vueGenerale.php",["menu"=>self::getMenu(),"chemin"=>"Entreprise/formulaireCreationOffre.php","titrePage","titrePage"=>"Créer une offre"]);
    }

    public static function creerOffre(){
        //TODO faire toutes les vérif liés à la BD, se référencier aux td de web
        echo "Fonction en cours de création";
        //TODO séparer Stage et Alternance en extends de Offre ?
        //TODO dans construireDepuisFormulaire, autoincrémenter l'idOffre...
        $offre=Offre::construireDepuisFormulaire($_POST);
        if ($_POST["TypeOffre"]=="Stage"){
            (new StageRepository())->creerOffre($offre);
        }else if ($_POST["TypeOffre"=="Alternance"]){
            (new AlternanceRepository())->creerOffre($offre);
        }else {
            //TODO erreur
        }
        self::afficherAccueilEntr();
    }
    public static function getMenu(): array
    {
        return array(
          array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Entreprise","lien"=>"?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image"=>"../ressources/images/creer.png","label"=>"Créer une offre","lien"=>"?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"ControleurFrontal.php")

        );
    }
}