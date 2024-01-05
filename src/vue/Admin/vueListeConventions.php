<div class="wrapCentreListEntr">
    <div class="gauche">
        <h2 class="titre">Liste des Entreprises :</h2>

        <div class="wrapEntreprises">
            <?php
            $erreur = 0;

            foreach ($listeFormations as $convention) {
                if ($convention->getIdEtudiant() != null && $convention->getDateCreationConvention() != null && !$convention->getConventionValidee()) {
                    $erreur++;
                    echo "
                        <a href='?action=afficherDetailConvention&controleur=AdminMain&numEtudiant=" . $convention->getIdEtudiant() . "' class='entreprise'>
                        
                        
                        <div class='entrepriseDroite'>
                            <h3 class='titre' id='rouge'>Etudiant : " . htmlspecialchars($convention->getIdEtudiant()) . "</h3>
                            <p>Convention ". $convention->getTypeOffre() ." à valider.</p>";


                    echo "
                        
                        </div>                        
                        </a>
                        
                    ";
                }
            }

            if ($erreur == 0) {
                echo "<div class='wrapErreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='erreur'>";
                echo "<h3 class='titre'>Aucune convention à valider</h3>";
                echo "</div>";
            }
            ?>
        </div>


    </div>

    <div class="droite">
        <img src="../ressources/images/entrepriseAdmins.png" alt="admin">
        <h3 class="titre" id="rouge">Toutes les entreprises de la base de données</h3>
        <h4 class="titre">Consultez le statut de chaque entreprise en un coup d'oeil</h4>
        <p>Cliquez sur une entreprise pour voir ses détails</p>
    </div>


</div>
