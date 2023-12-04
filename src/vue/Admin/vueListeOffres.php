<div class="wrapCentreOffres">
    <div class="gauche">
        <img src="../ressources/images/listeOffreAdmin.png" alt="admin">
        <h3 class="titre" id="rouge">Toutes les offres de la base de données</h3>
        <h4 class="titre">Consultez le statut de chaque offre en un coup d'oeil</h4>
        <p>Cliquez sur une offre pour voir ses détails</p>
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
                            <h3 class='titre' id='rouge'>" . htmlspecialchars($offre->getNomOffre()) . " - " . htmlspecialchars($offre->getTypeOffre()) . " - Par ". htmlspecialchars($entreprise->getNomEntreprise()) . "</h3>
                            <p>Créée le : " . htmlspecialchars($offre->getDateCreationOffre()) . "</p>";

                            if ($offre->getEstValide()) {
                                echo "<div id='valide' class='statutOffre'><img src='../ressources/images/success.png' alt='valide'><p>Offre validée</p></div>";
                            } else {
                                echo "<div id='nonValide' class='statutOffre'><img src='../ressources/images/warning.png' alt='valide'><p>Offre en attente</p></div>";
                            }

                        echo"
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
