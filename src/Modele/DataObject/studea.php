<?php
namespace App\FormatIUT\Modele\DataObject;

use DateTime;
class studea extends AbstractDataObject{

    //private string $archivee;
    //private string $dehorsStudea;
    //private string statutOPCO;
    private string $id;
    private string $etablissement;
    private string $formation;
    private string $anneeDebut;
    private string $anneeFin;
    private string $genreAlternant;
    private string $nomAlternant;
    private string $prenomAlternant;
    private string $dateSaisieParEntreprise;
    private string $validationPedagogiqueDesMissions;
    private string $ficheEnErreur;
    private string $codeErreur;
    private string $contratEtConventionEnvoyeALEntreprise;
    private string $contratOuConventionSigne;
    private string $dateNaissance;
    private string $communeNaissance;
    private string $paysNaissance;
    private string $nationalite;
    private string $travailleurHandicape;
    private  string $titulairePermisDeConduire;
    private string $numeroSecuriteSociale;
    private string $pasDeNumeroDeSecuriteSociale;
    private string $sportifHautNiveau;
    private string $telephone1;
    private string $telephone2;
    private string $email1;
    private string $email2;
    private string $adresse;
    private string $complement;
    private string $codePostal;
    private string $ville;
    private string $genreRepresentantLegal;
    private string $nomRepresentantLegal;
    private string $prenomRepresentantLegal;
    private string $adresse2;
    private string $complement2;
    private string $codePostal2;
    private string $ville2;
    private string $codeINE;
    private string $situationAvantContrat;

    public function formatTableau(): array{
        return array();
    }
}


?>


