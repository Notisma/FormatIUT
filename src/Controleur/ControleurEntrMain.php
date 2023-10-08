<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Modele\DataObject\Offre;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\OffreRepository;


class ControleurEntrMain extends ControleurMain
{

    public static function afficherAccueilEntr()
    {
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Entreprise/vueAccueilEntreprise.php", "titrePage" => "Accueil Entreprise"]);
    }

    public static function formulaireCreationOffre()
    {
        self::afficherVue("vueGenerale.php", ["menu" => self::getMenu(), "chemin" => "Entreprise/formulaireCreationOffre.php", "titrePage", "titrePage" => "Créer une offre"]);
    }

    public static function creerOffre()
    {
        //TODO faire toutes les vérif liés à la BD, se référencier aux td de web
        $id=1;
        $listeId=(new OffreRepository())->getListeIdOffres();
        while (!isset($_GET["idOffre"])){
            if (in_array($id,$listeId)){
                $id++;
            }else {
                $_GET["idOffre"]=$id;
            }
        }
        $_GET["idEntreprise"]="76543128904567";
        $offre = (new OffreRepository())->construireDepuisTableau($_GET);
        (new OffreRepository())->creerOffre($offre);
        self::MesOffres();
    }

    public static function MesOffres()
    {
        /*switch ($_GET["type"]) {
            case "Stage" :
                $liste = (new StageRepository())->getListeOffreParEntreprise("76543128904567",);
                break;
            case "Alternance":
                $liste = (new AlternanceRepository())->getListeOffreParEntreprise("76543128904567"); //TODO changer le siret
                break;
            case "Offre":
                $liste = (new OffreRepository())->getListeOffreParEntreprise("76543128904567");
                break;
        }*/
        $liste=(new OffreRepository())->getListeOffreParEntreprise("76543128904567",$_GET["type"]);
        self::afficherVue("vueGenerale.php", ["titrePage" => "Mes Offres", "chemin" => "Entreprise/vueMesOffres.php", "menu" => self::getMenu(), "type" => $_GET["type"], "listeOffres" => $liste]);
    }

    public static function getMenu(): array
    {
        return array(
            array("image" => "../ressources/images/accueil.png", "label" => "Accueil Entreprise", "lien" => "?action=afficherAccueilEntr&controleur=EntrMain"),
            array("image" => "../ressources/images/creer.png", "label" => "Créer une offre", "lien" => "?action=formulaireCreationOffre&controleur=EntrMain"),
            array("image" => "../ressources/images/catalogue.png", "label" => "Mes Offres", "lien" => "?action=MesOffres&type=Offre&controleur=EntrMain"),
            array("image" => "../ressources/images/se-deconnecter.png", "label" => "Se déconnecter", "lien" => "controleurFrontal.php")

        );
    }
    public static function afficherProfilEntr(){
        self::afficherVue("vueGenerale.php", ["menu"=>self::getMenu(), "chemin"=> "Entreprise/vueCompteEntreprise.php", "titrePage" => "Compte Entreprise"]);
    }
}