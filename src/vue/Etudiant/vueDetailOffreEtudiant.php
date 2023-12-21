<?php

use App\FormatIUT\Configuration\Configuration;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
$offre = (new \App\FormatIUT\Modele\Repository\FormationRepository())->getObjectParClePrimaire($_GET['idFormation']);
$entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
?>

<div class="detailOffreEtu">

    <div class="detailsOffre">

        <div class="entreprise">
            <img src="<?= Configuration::getUploadPathFromId($entreprise->getImg()); ?>" alt="entreprise">
            <h2 class="titre" id="rouge"><?php echo htmlspecialchars($entreprise->getNomEntreprise()) ?></h2>
            <h3 class="titre"><?php echo htmlspecialchars($entreprise->getAdresseEntreprise()) ?>,
                <?php echo htmlspecialchars((new App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille())->getNomVille()) ?></h3>
        </div>

    </div>

    <div class="actionsOffre">

    </div>

</div>
