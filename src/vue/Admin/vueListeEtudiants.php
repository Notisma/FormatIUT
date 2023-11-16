<div id="center">
    <div class="gauche">
        <h3 class="titre">Étudiants Enregistrés :</h3>

        <div class="wrapEtudiants">
            <?php
            if (sizeof($listeEtudiants) > 0) {
                foreach ($listeEtudiants as $etudiant) {
                    echo"
                    <a class='etudiant' href=?action=afficherDetailEtudiant&numEtu=" . $etudiant['etudiant']->getNumEtudiant() . "&controleur=AdminMain>
                            <div class='etudiantGauche'>
                               <img src='data:image/jpeg;base64," . base64_encode($etudiant['etudiant']->getImg()) . "' alt='etudiant'>
                            </div>
                            <div class='etudiantDroite'>
                                <h3 class='titre'>" . $etudiant['etudiant']->getPrenomEtudiant() . " " . $etudiant['etudiant']->getNomEtudiant() . " - ". $etudiant['etudiant']->getGroupe() . " - " . $etudiant['etudiant']->getParcours() ."</h3>
                                ";
                            echo "<p>Formation : " . $etudiant["aUneFormation"] . " - " . $etudiant["etudiant"]->getParcours() . "</p>"
                         . "
                            </div>
                        </a>
                    
                    ";
                }
            }
            ?>
        </div>
    </div>

    <div class="droite">
    </div>


</div>
