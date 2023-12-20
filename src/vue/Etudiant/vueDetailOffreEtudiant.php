<?php
use App\FormatIUT\Configuration\Configuration;
$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
$offre = (new \App\FormatIUT\Modele\Repository\FormationRepository())->getObjectParClePrimaire($_GET['idFormation']);
?>

<div class="detailOffreEtu">




</div>
