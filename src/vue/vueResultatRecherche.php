<?php

use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
if (!is_null($offres) && !is_null($entreprises)) {
$count = count($offres) + count($entreprises);
}
?>
<div class="center">

    <div class="intro">
        <h2 class="titre" id="rouge">Effectuer une recherche sur FORMAT'IUT :</h2>
        <?= $codeRecherche ?>
    </div>


    <div class="results">
        <?php
        if ($count == 0) {
            echo "<div class='erreur'>
                <img src='../ressources/images/erreur.png' alt='erreur'>
                <h2 class='titre'>Aucun résultat trouvé</h2>
            </div>";
        }


        echo "<h3 class='titre'>" . $count . " Résultats trouvés :</h3>";
        if (!empty($entreprises)) {
            foreach ($entreprises as $entr) {
                echo '
                    <div class="resultat" id="petitRouge">
                        <div class="partieGauche">
                            <img src = "data:image/jpeg;base64,' . base64_encode($entr->getImg()) . '" class="imageEntr" alt = "pp entreprise">
                        </div>
                        <div class="partieDroite">
                            <h3 class="titre">' . $entr->getNomEntreprise() . ' - Entreprise</h3>
                            <p><span>Téléphone : </span>' . $entr->getTel() . '</p>
                            <p><span>Adresse : </span>' . $entr->getAdresse() . '</p>
                        </div>
                    </div>';
            }
        }


        if (!empty($offres)) {
            foreach ($offres as $offre) {
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                echo "<a href='?controleur=" . \App\FormatIUT\Configuration\Configuration::getControleur() . "&action=afficherVueDetailOffre&idOffre=" . $offre->getIdOffre() . "' class='resultat'>
                    <div class='partieGauche'>
                            <img src=\"data:image/jpeg;base64," . base64_encode($entreprise->getImg()) . "\" alt='logo'>
                        </div>
                        <div class='partieDroite'>
                        <h3 class='titre' id='rouge'>" . htmlspecialchars($offre->getNomOffre()) . " - Offre de " . $offre->getTypeOffre() . "</h3>
                        <p>
                       ";
                if (!(new FormationRepository())->estFormation($offre->getIdOffre())) {
                    $nb = (new EtudiantRepository())->nbPostulation($offre->getIdOffre());
                    echo $nb . " postulation";
                    if ($nb > 1) echo "s";
                } else {
                    echo "Assignée";
                }
                echo "</p>
                        <p> Du " . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . " pour " . $offre->getSujet() . "</p>               
                        </div>
                </a>";
            }
        }
        ?>
    </div>
</div>
