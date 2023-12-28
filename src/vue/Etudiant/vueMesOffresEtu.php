<?php

use App\FormatIUT\Modele\Repository\FormationRepository;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
$listeOffres = (new FormationRepository())->listeOffresEtu($etudiant->getNumEtudiant());
?>

<div class="mainMesOffres">

    <div class="estCandidat">

        <div class="front">
            <h2 class="titre">Mes offres postulées</h2>
            <div class="circle">
                <span class="number">1</span>
            </div>
        </div>

        <div class="wrapCandidat">

        </div>

    </div>

    <div class="enAttente">

        <div class="front">
            <h2 class="titre">Mes offres validées</h2>
            <div class="circle">
                <span class="number">1</span>
            </div>
        </div>



    </div>

    <div class="presMesOffres">

    </div>

</div>
