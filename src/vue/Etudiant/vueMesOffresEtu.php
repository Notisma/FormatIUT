<?php

use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;
use App\FormatIUT\Configuration\Configuration;

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
                <span class="number"><?php echo count($listeOffresEnAttente) ?></span>
            </div>
        </div>

        <div class="wrapCandidat">
            <?php
            if (count($listeOffresEnAttente) == 0) {
                echo "<div class='wrapError'><img src='../ressources/images/erreur.png' alt=''> <h4 class='titre'>Aucune offre à afficher.</h4> </div>";
            } else {
                foreach ($listeOffresEnAttente as $offreAttente) {
                    echo "<a href='?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=".$offreAttente->getIdFormation()."' class='offre'>";
                    echo "</a>";
                }
            }
            ?>
        </div>

    </div>

    <div class="enAttente">

        <div class="front">
            <h2 class="titre">Mes offres validées</h2>
            <div class="circle">
                <span class="number"><?php echo count($listeOffresAChoisirEtValidees) ?></span>
            </div>
        </div>

        <div class="wrapCandidat">
            <?php
            if (count($listeOffresAChoisirEtValidees) == 0) {
                echo "<div class='wrapError'><img src='../ressources/images/erreur.png' alt=''> <h4 class='titre'>Aucune offre à afficher.</h4> </div>";
            } else {
                foreach ($listeOffresAChoisirEtValidees as $offreValider) {
                    $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offreValider->getIdEntreprise());
                    echo "<a href='?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=".$offreValider->getIdFormation()."' class='offre'>";
                    echo '<img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="">';
                    echo "</a>";
                }
            }
            ?>
        </div>


    </div>

    <div class="presMesOffres">

    </div>

</div>
