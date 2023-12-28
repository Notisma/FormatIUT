<?php

use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
$listeOffres = (new FormationRepository())->listeOffresEtu($etudiant->getNumEtudiant());

$listeOffresEnAttente = [];

foreach ($listeOffres as $offre) {
    if ((new PostulerRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offre->getIdFormation()) == "En attente") {
        $listeOffresEnAttente[] = $offre;
    }
}

$listeOffresAChoisirEtValidees = [];

foreach ($listeOffres as $offre) {
    if ((new PostulerRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offre->getIdFormation()) == "A Choisir" || (new PostulerRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offre->getIdFormation()) == "Validée") {
        $listeOffresAChoisirEtValidees[] = $offre;
    }
}


?>

<div class="mainMesOffres">

    <div class="estCandidat">

        <div class="front">
            <h2 class="titre">Mes offres postulées</h2>
            <div class="circle">
                <span class="number"><?php echo count($listeOffresEnAttente)?></span>
            </div>
        </div>

        <div class="wrapCandidat">

        </div>

    </div>

    <div class="enAttente">

        <div class="front">
            <h2 class="titre">Mes offres validées</h2>
            <div class="circle">
                <span class="number"><?php echo count($listeOffresAChoisirEtValidees)?></span>
            </div>
        </div>


    </div>

    <div class="presMesOffres">

    </div>

</div>
