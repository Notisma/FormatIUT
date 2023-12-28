<div class="wrapCentreOffres">
    <div class="gauche">
        <img src="../ressources/images/listeOffreAdmin.png" alt="admin">
        <h3 class="titre rouge">Toutes les offres de la base de données</h3>
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
                        ";
                    $nomOffre = $offre->getNomOffre();
                    $typeOffre = $offre->getTypeOffre();
                    $nomEntreprise = $entreprise->getNomEntreprise();
                    if ($nomOffre == null || $typeOffre == null || $nomEntreprise == null)
                        echo "<h3 class='titre rouge'>Offre anonyme !</h3>";
                    else
                        echo "<h3 class='titre rouge'>" . htmlspecialchars($nomOffre) . " - " . htmlspecialchars($typeOffre) . " - Par " . htmlspecialchars($nomEntreprise) . "</h3>";

                    $dateoffre = $offre->getDateCreationOffre();
                    if ($dateoffre == null)
                        echo "<p>Date de création inconnue</p>";
                    else
                        echo "<p>Créée le : " . htmlspecialchars($dateoffre) . "</p>";

                    if ($offre->getEstValide()) {
                        echo "<div class='statutOffre valide'><img src='../ressources/images/success.png' alt='valide'><p>Offre validée</p></div>";
                    } else {
                        echo "<div class='statutOffre nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Offre en attente</p></div>";
                    }

                    echo "
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
