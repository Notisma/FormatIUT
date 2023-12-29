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
                    echo "<a href='?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=" . $offreAttente->getIdFormation() . "' class='offre'>";
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
                    echo "<a href='?action=afficherVueDetailOffre&controleur=EtuMain&idFormation=" . $offreValider->getIdFormation() . "' class='offre'>";
                    echo '<img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="test">';
                    echo '
                            <div>
                                <h3 class="titre" id="rouge">' . htmlspecialchars($entreprise->getNomEntreprise()) . '</h3>
                                <h4 class="titre">' . htmlspecialchars($offreValider->getNomOffre()) . ' - ' . htmlspecialchars($offreValider->getTypeOffre()) . '</h4>
                                <h5 class="titre">' . htmlspecialchars($offreValider->getSujet()) . '</h5>
           
                                <div class="wrapBoutons">';

                    if ((new PostulerRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offreValider->getIdFormation()) == "A Choisir") {
                        echo '<form action="?action=annulerOffre&service=Postuler&idFormation=' . $offreValider->getIdFormation() . '" method="post"><input type="submit" class="boutonOffres undo" value="ANNULER"></form>';
                        echo '<form action="?action=validerOffre&service=Postuler&idFormation=' . $offreValider->getIdFormation() . '" method="post"><input type="submit" class="boutonOffres accept" value="ACCEPTER"></form></div></div></a>';
                    } else {
                        echo '<form action="?action=afficherMesOffres&controleur=EtuMain" method="post"><input type="submit" class="disabled boutonOffres acceptee" value="Acceptée"></form></div></div></a>';
                    }
                }

            }
            ?>
        </div>
    </div>


    <div class="presMesOffres">
        <p>tt</p>
    </div>

</div>
