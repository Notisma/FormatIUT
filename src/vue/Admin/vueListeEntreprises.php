<div class="wrapCentreListEntr">
    <div class="gauche">
        <h2 class="titre">Liste des Entreprises :</h2>

        <div class="wrapEntreprises">
            <?php
            if (sizeof($listeEntreprises) > 0) {

                foreach ($listeEntreprises as $entreprise) {
                    echo "
                        <a href='?action=afficherDetailEntreprise&controleur=AdminMain&idEntreprise=".$entreprise->getSiret()."' class='entreprise'>
                        <h3 id='rouge' class='titre'>".$entreprise->getNomEntreprise()."</h3>                            
                        </a>
                        
                    ";
                }

            } else {
                echo "<p>Aucune entreprise n'a été enregistrée</p>";
            }
            ?>
        </div>


    </div>

    <div class="droite">

    </div>


</div>
