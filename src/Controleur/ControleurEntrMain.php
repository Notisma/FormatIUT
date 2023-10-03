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
        $_GET["idOffre"]=9;
        $offre=Offre::construireDepuisFormulaire($_GET);
        /*if ($_GET["TypeOffre"]=="Stage"){
            (new StageRepository())->creerOffre($offre);
        }else if ($_GET["TypeOffre"=="Alternance"]){
            (new AlternanceRepository())->creerOffre($offre);
        }else {
            //TODO erreur
        }*/
        (new OffreRepository())->creerOffre($offre);
        self::afficherAccueilEntr();
    }

    public static function afficherMesOffres(){
        self::afficherVue("vueGenerale.php",["titrePage"=>"Mes Offres","chemin"=>"Entreprise/vueMesOffres.php","menu"=>self::getMenu(),"listeOffres"=>(new OffreRepository())->getListeOffreParEntreprise("Dell")]);
    }
    public static function getMenu(): array
    {
        return array(
          array("image"=>"../ressources/images/accueil.png","label"=>"Accueil Entreprise","lien"=>"?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image"=>"../ressources/images/creer.png","label"=>"Créer une offre","lien"=>"?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image"=>"../ressources/images/catalogue.png","label"=>"Mes Offres","lien"=>"?action=afficherMesOffres&controleur=EntrMain"),
            array("image"=>"../ressources/images/se-deconnecter.png","label"=>"Se déconnecter","lien"=>"ControleurFrontal.php")

        );
    }
}