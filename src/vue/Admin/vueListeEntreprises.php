<div class="wrapCentreListEntr">
    <div class="gauche">
        <h2 class="titre">Liste des Entreprises :</h2>

        <div class="wrapEntreprises">
            <?php

            use App\FormatIUT\Configuration\Configuration;

            if (sizeof($listeEntreprises) > 0) {

                foreach ($listeEntreprises as $entreprise) {
                    $countValide = count((new App\FormatIUT\Modele\Repository\EntrepriseRepository)->getOffresValidesDeEntreprise($entreprise->getSiret()));
                    $countNonValide = count((new App\FormatIUT\Modele\Repository\EntrepriseRepository)->getOffresNonValidesDeEntreprise($entreprise->getSiret()));
                    echo "
                        <a href='?action=afficherDetailEntreprise&controleur=AdminMain&siret=" . $entreprise->getSiret() . "' class='entreprise'>
                        <div class='entrepriseGauche'>
                            <img src='" . Configuration::getUploadPathFromId($entreprise->getImg()) . "' alt='pp entreprise'>
                        </div>
                        
                        <div class='entrepriseDroite'>
                            <h3 class='titre rouge'>" . htmlspecialchars($entreprise->getNomEntreprise()) . "</h3>
                            <p>Possède " . $countNonValide . " offres non validées et " . $countValide . " offres validées.</p>";

                    if ($entreprise->isEstValide()) {
                        echo "<div class='statutEntr valide'><img src='../ressources/images/success.png' alt='valide'><p>Compte validé</p></div>";
                    } else {
                        echo "<div class='statutEntr nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Compte non validé</p></div>";
                    }

                    echo "
                        
                        </div>                        
                        </a>
                        
                    ";
                }

            } else {
                echo "<div class='wrapErreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='erreur'>";
                echo "<h3 class='titre'>Aucune entreprise n'est enregistrée</h3>";
                echo "</div>";
            }
            ?>
        </div>


    </div>

    <div class="droite">
        <img src="../ressources/images/entrepriseAdmins.png" alt="admin">
        <h3 class="titre rouge">Toutes les entreprises de la base de données</h3>
        <h4 class="titre">Consultez le statut de chaque entreprise en un coup d'oeil</h4>
        <p>Cliquez sur une entreprise pour voir ses détails</p>
    </div>


</div>
