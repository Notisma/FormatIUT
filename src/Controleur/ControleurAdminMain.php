<?php

namespace App\FormatIUT\Controleur;

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\InsertionCSV;
use App\FormatIUT\Lib\MessageFlash;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\Repository\ConnexionLdap;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\pstageRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use App\FormatIUT\Service\ServiceEntreprise;
use App\FormatIUT\Service\ServiceEtudiant;
use App\FormatIUT\Service\ServiceFichier;
use App\FormatIUT\Service\ServiceFormation;
use App\FormatIUT\Service\ServicePersonnel;

class ControleurAdminMain extends ControleurMain
{
    private static string $pageActuelleAdmin = "Accueil Admin";


    /**
     * @return string
     */
    public static function getPageActuelleAdmin(): string
    {
        return self::$pageActuelleAdmin;
    }

    //FONCTIONS D'AFFICHAGES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @return void affiche l'accueil pour un Administrateur connecté
     */
    public static function afficherAccueilAdmin(): void
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsSansOffres();
        $listeEntreprises = (new EntrepriseRepository())->entreprisesNonValide();
        $listeOffres = (new FormationRepository())->offresNonValides();
        $accueil = ConnexionUtilisateur::getTypeConnecte();
        self::$pageActuelleAdmin = "Accueil Administrateurs";
        self::afficherVue("Accueil $accueil", "Admin/vueAccueilAdmin.php", ["listeEntreprises" => $listeEntreprises, "listeOffres" => $listeOffres, "listeEtudiants" => $listeEtudiants]);
    }


    /**
     * @return void affiche le profil de l'administrateur connecté
     */
    public static function afficherProfil(): void
    {
        self::$pageActuelleAdmin = "Mon Compte";
        self::afficherVue("Mon Compte", "Admin/vueCompteAdmin.php");
    }

    /**
     * @return void affiche les informations d'un étudiant
     */
    public static function afficherDetailEtudiant(): void
    {
        $aFormation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtu']);
        self::$pageActuelleAdmin = "Détails d'un Étudiant";
        self::afficherVue("Détails d'un Étudiant", "Admin/vueDetailEtudiant.php", ["aFormation"=> $aFormation]);
    }

    /**
     * @return void affiche la liste des étudiants
     */
    public static function afficherListeEtudiant(): void
    {
        $listeEtudiants = (new EtudiantRepository())->etudiantsEtats();
        self::$pageActuelleAdmin = "Liste Étudiants";
        self::afficherVue("Liste Étudiants", "Admin/vueListeEtudiants.php", ["listeEtudiants" => $listeEtudiants]);
    }

    /**
     * @return void affiche les informations d'une entreprise
     */
    public static function afficherDetailEntreprise(): void
    {
        self::$pageActuelleAdmin = "Détails d'une Entreprise";
        self::afficherVue("Détails d'une Entreprise", "Admin/vueDetailEntreprise.php");
    }

    /**
     * @return void affiche la liste des entreprises
     */
    public static function afficherListeEntreprises(): void
    {
        $listeEntreprises = (new EntrepriseRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste Entreprises";
        self::afficherVue("Liste Entreprises", "Admin/vueListeEntreprises.php", ["listeEntreprises" => $listeEntreprises]);
    }

    /**
     * @return void affiche la page d'importation et d'exportation des csv
     */
    public static function afficherVueCSV(): void
    {
        self::$pageActuelleAdmin = "Mes CSV";
        self::afficherVue("Mes CSV", "Admin/vueCSV.php");
    }

    /**
     * @return void affiche la liste des offresc
     */

    public static function afficherListeOffres(): void
    {
        $listeOffres = (new FormationRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste des Offres";
        self::afficherVue("Liste des Offres", "Admin/vueListeOffres.php", ["listeOffres" => $listeOffres]);
    }

    /**
     * @return void affiche la page d'ajout d'un étudiant
     */

    public static function afficherFormulaireCreationEtudiant(): void
    {
        self::$pageActuelleAdmin = "Ajouter un étudiant";
        self::afficherVue("Ajouter un étudiant", "Admin/vueFormulaireCreationEtudiant.php");
    }

    /**
     * @param string|null $idFormation l'id de la formation dont on affiche le detail
     * @return void affiche le détail d'une offre
     */

    public static function afficherVueDetailOffre(string $idFormation = null): void
    {
        if (!isset($_REQUEST['idFormation']) && is_null($idFormation))
            parent::afficherErreur("Il faut préciser la formation");

        self::$pageActuelleAdmin = "Détails de l'offre";
        /** @var ControleurMain $menu */
        $menu = Configuration::getCheminControleur();
        $liste = (new FormationRepository())->getListeidFormations();
        if ($idFormation || isset($_REQUEST["idFormation"])) {
            if (!$idFormation) $idFormation = $_REQUEST['idFormation'];
            if (in_array($idFormation, $liste)) {
                $offre = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                $client = "Admin";
                $chemin = ucfirst($client) . "/vueDetailOffre" . ucfirst($client) . ".php";
                self::afficherVue("Détails de l'offre", $chemin, $menu::getMenu(), ["offre" => $offre, "entreprise" => $entreprise]);
            } else {
                self::redirectionFlash("afficherPageConnexion", "danger", "Cette offre n'existe pas");
            }
        } else {
            self::redirectionFlash("afficherPageConnexion", "danger", "L'offre n'est pas renseignée");
        }
    }
    public static function afficherFormulaireModifEtudiant(): void{
        self::$pageActuelleAdmin = "Modifier un étudiant";
        self::afficherVue("Modifier un étudiant", "Admin/vueFormulaireModificationEtudiant.php");
    }

    /**
     * @return void
     * Affiche la liste des conventions à valider au secrétariat/admin
     */
    public static function afficherConventionAValider(): void {
        $listeFormations = (new FormationRepository())->getListeObjet();
        self::$pageActuelleAdmin = "Liste des conventions";
        self::afficherVue("Liste des conventions", "Admin/vueListeConventions.php", ["listeFormations"=> $listeFormations]);
    }

    /**
     * @return void
     * Affiche en détail la convention de l'étudiant au secrétariat/admin
     */
    public static function afficherDetailConvention(): void {
        $formation = (new FormationRepository())->trouverOffreDepuisForm($_REQUEST['numEtudiant']);
        $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtudiant']);
        $entreprise = (new EntrepriseRepository())->trouverEntrepriseDepuisForm($_REQUEST['numEtudiant']);
        $villeEntr = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
        self::afficherVue("Convention à valider", "Admin/vueAfficherDetailConvention.php",
            ["etudiant" => $etudiant, "entreprise" => $entreprise, "villeEntr" => $villeEntr,
                "offre" => $formation]);
    }


    //APPEL AUX SERVICES -------------------------------------------------------------------------------------------------------------------------------------------------------

    public static function modifierEtudiant(): void{
        ServiceEtudiant::modifierEtudiant();
    }

    public static function ajouterEtudiant(): void{
        ServiceEtudiant::ajouterEtudiant();
    }

    public static function rejeterFormation(): void{
        ServiceFormation::rejeterFormation();
    }

    public static function accepterFormation(): void{
        ServiceFormation::accepterFormation();
    }

    public static function supprimerFormation(): void{
        ServiceFormation::supprimerFormation();
    }

    public static function ajouterCSV(): void{
        ServiceFichier::ajouterCSV();
    }

    public static function refuserEntreprise(): void{
        ServiceEntreprise::refuserEntreprise();
    }
    public static function supprimerEntreprise(): void{
        ServiceEntreprise::supprimerEntreprise();
    }
    public static function validerEntreprise(): void{
        ServiceEntreprise::validerEntreprise();
    }

    public static function supprimerEtudiant(): void{
        ServiceEtudiant::supprimerEtudiant();
    }

    public static function promouvoirProf(): void{
        ServicePersonnel::promouvoirProf();
    }

    public static function retrograderProf(): void{
        ServicePersonnel::retrograderProf();
    }

    public static function seProposerEnTuteurUM(): void{
        ServicePersonnel::seProposerEnTuteurUM();
    }
    
    public static function validerTuteurUM(): void
    {
        ServicePersonnel::validerTuteurUM();
    }
    
    public static function refuserTuteurUM(): void
    {
        ServicePersonnel::refuserTuteurUM();
    }

    //FONCTIONS AUTRES ---------------------------------------------------------------------------------------------------------------------------------------------

    /**
     * @param string $action le nom de la fonction sur laquelle rediriger
     * @param string $type le type de message Flash
     * @param string $message le message à envoyer
     * @return void redirige en envoyant un messageFlash
     */
    public static function redirectionFlash(string $action, string $type, string $message): void
    {
        MessageFlash::ajouter($type, $message);
        self::$action();
    }
}
