<div class="wrapCentreOffres">
    <div class="gauche">

    </div>

    <div class="droite">
        <h2 class="titre">Liste des offres :</h2>

        <div class="wrapOffres">
            <?php
            use App\FormatIUT\Configuration\Configuration;
            if (sizeof($listeOffres) > 0) {

                foreach ($listeOffres as $offre) {
                    $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository)->getObjectParClePrimaire($offre->getIdEntreprise());
                    echo "
                        <a href='?action=afficherVueDetailOffre&controleur=AdminMain&idFormation=" . $offre->getIdFormation() . "' class='offre'>
                        <div class='offreGauche'>
                            <img src='" . Configuration::getUploadPathFromId($entreprise->getImg()) . "' alt='pp entreprise'>
                        </div>
                        
                        <div class='offreDroite'>
                            <h3 class='titre' id='rouge'>" . htmlspecialchars($offre->getNomOffre()) . " - " . htmlspecialchars($offre->getTypeOffre()) . "</h3>
                            <h5 class='titre'>Postée par " . htmlspecialchars($entreprise->getNomEntreprise()) . "</h5>
                            <p>Le " . htmlspecialchars($offre->getDateCreationOffre()) . "</p>
                        </div>                        
                        </a>
                        
                    ";
                }

            } else {
                echo "<div class='wrapErreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='erreur'>";
                echo "<h3 class='titre'>Aucune offre n'est enregistrée</h3>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
