<?php

/** @var Formation[] $listeFormations */

use App\FormatIUT\Modele\DataObject\Formation;

?>

<div class="wrapCentreListEntr">
    <div class="gauche">
        <h2 class="titre">Liste des Conventions :</h2>

        <div class="wrapEntreprises">
            <?php
            $erreur = 0;

            foreach ($listeFormations as $convention) {
                if ($convention->getIdEtudiant() != null && $convention->getDateCreationConvention() != null && !$convention->getConventionValidee() && $convention->getDateTransmissionConvention() == null) {
                    $erreur++;
                    echo "
                        <a href='?action=afficherDetailConvention&controleur=AdminMain&numEtudiant=" . $convention->getIdEtudiant() . "' class='entreprise'>
                        <div class='entrepriseGauche'>
                        <img src='" . \App\FormatIUT\Configuration\Configuration::getUploadPathFromId($convention->getIdEtudiant()) . "' alt='logo'>
                        </div>
                        
                        <div class='entrepriseDroite'>
                            <h3 class='titre rouge'>Convention à valider</h3>
                            <h3 class='titre'>Etudiant : " . htmlspecialchars($convention->getIdEtudiant()) . "</h3>
                            <h5 class='titre'>Convention " . $convention->getTypeOffre() . " à valider.</h5>";

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
        <img src="../ressources/images/conv.jpg" alt="admin">
        <h3 class="titre rouge">Toutes les conventions de la base de données</h3>
        <h4 class="titre">Consultez le statut de chaque convention en anomalie</h4>
        <p>Cliquez sur une convention pour voir ses détails</p>
    </div>


</div>
