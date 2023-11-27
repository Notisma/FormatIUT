<?php

use App\FormatIUT\Configuration\Configuration;
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
                $nomEntrepriseHTML=htmlspecialchars($entr->getNomEntreprise());
                $telHTML=htmlspecialchars($entr->getTel());
                $adresseHTML=htmlspecialchars($entr->getAdresseEntreprise());
                echo '
                    <div class="resultat" id="petitRouge">
                        <div class="partieGauche">
                            <img src="' . Configuration::getUploadPathFromId($entr->getImg()) . '" class="imageEntr" alt = "pp entreprise">
                        </div>
                        <div class="partieDroite">
                            <h3 class="titre">' . $nomEntrepriseHTML . ' - Entreprise</h3>
                            <p><span>Téléphone : </span>' . $telHTML . '</p>
                            <p><span>Adresse : </span>' . $adresseHTML . '</p>
                        </div>
                    </div>';
            }
        }


        if (!empty($offres)) {
            foreach ($offres as $offre) {
                $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                echo "<a href='?controleur=" . Configuration::getControleur() . "&action=afficherVueDetailOffre&idFormation=" . $offre->getidFormation() . "' class='resultat'>
                    <div class='partieGauche'>
                            <img src=\"" . Configuration::getUploadPathFromId($entreprise->getImg()) . "\" alt='logo'>
                        </div>
                        <div class='partieDroite'>
                        <h3 class='titre' id='rouge'>" . htmlspecialchars($offre->getNomOffre()) . " - Offre de " . $offre->getTypeOffre() . "</h3>
                        <p>
                       ";
                if (!(new FormationRepository())->estFormation($offre->getidFormation())) {
                    $nb = (new EtudiantRepository())->nbPostulations($offre->getidFormation());
                    echo $nb . " postulation";
                    if ($nb > 1) echo "s";
                } else {
                    echo "Assignée";
                }
                $sujetHTML=htmlspecialchars($offre->getSujet());
                echo "</p>
                        <p> Du " .  $offre->getDateDebut()  . " au " .  $offre->getDateFin()  . " pour " . $sujetHTML . "</p>               
                        </div>
                </a>";
            }
        }
        ?>
    </div>
</div>
