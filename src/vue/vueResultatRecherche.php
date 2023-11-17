<?php

use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;

?>
<div class="center">

    <h2>La recherche est : <?= $codeRecherche ?></h2>

    <?php
    if (!empty($offres)) {
        echo "<h3>Offres trouvées :</h3>
            <ul>";
        foreach ($offres as $offre) {
            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
            echo "<li><a href='?controleur=" . \App\FormatIUT\Configuration\Configuration::getControleur() . "&action=afficherVueDetailOffre&idOffre=" . $offre->getIdOffre() . "' class='wrapOffres'>
                    <div class='partieGauche'>
                        <h3>" . htmlspecialchars($offre->getNomOffre()) . " - " . $offre->getTypeOffre() . "</h3>
                        <p> Du " . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . " pour " . $offre->getSujet() . "</p>
                        <p>" . htmlspecialchars($offre->getDetailProjet()) . "</p>
                    </div>
                    <div class='partieDroite'>
                        <div class='divInfo'>
                            <img src=\"data:image/jpeg;base64," . base64_encode($entreprise->getImg()) . "\" alt='logo'>
                        </div>
                        <div class='divInfo'>
                            <img src='../ressources/images/recherche-demploi.png' alt='postulations'>
                            <p>";
            if (!(new FormationRepository())->estFormation($offre->getIdOffre())) {
                $nb = (new EtudiantRepository())->nbPostulation($offre->getIdOffre());
                echo $nb . " postulation";
                if ($nb > 1) echo "s";
            } else {
                echo "Assignée";
            }
            echo "</p>
                        </div>
                    </div>
                </a></li>";
        }
        echo "</ul>";
    }

    if (!empty($entreprises)) {
        echo "<h3>Entreprises trouvées :</h3>
            <ul>";
        foreach ($entreprises as $entr) {
            echo '<li>
                    <div class="infosSurEntreprise">
                        <div class="left">
                            <img src = "data:image/jpeg;base64,' . base64_encode($entr->getImg()) . '" class="imageEntr" alt = "pp entreprise">
                        </div>
                        <div class="right">
                            <h3>' . $entr->getNomEntreprise() . '</h3>
                            <p><span>Téléphone : </span>' . $entr->getTel() . '</p>
                            <p><span>Adresse : </span>' . $entr->getAdresse() . '</p>
                        </div>
                    </div>
                </li>';
        }
        echo "</ul>";

    }
    ?>
</div>
