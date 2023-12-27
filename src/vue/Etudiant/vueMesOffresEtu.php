<?php
$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
?>

<div class="mainMesOffres">

    <div class="estCandidat">
        <h2 class="titre">Mes offres postulées</h2>
    </div>

    <div class="enAttente">
        <h2 class="titre">Mes offres validées</h2>
    </div>

    <div class="presMesOffres">

    </div>

</div>
