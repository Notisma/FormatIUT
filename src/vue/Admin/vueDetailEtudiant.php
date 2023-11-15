<?php

use App\FormatIUT\Modele\Repository\EtudiantRepository;

$etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_GET["numEtu"]);
?>

<div class="wrapCentreEtu">
    <div class="gaucheEtu">
        <div class="infosEtu">
            <?php
            echo "<img src='data:image/jpeg;base64," . base64_encode($etudiant->getImg()) . "' alt='etudiant'>";
            echo "<h1 id='rouge' class='titre'>" . $etudiant->getPrenomEtudiant() . " " . $etudiant->getNomEtudiant() . "</h1>";
            echo "<h3 class='titre'>" . $etudiant->getGroupe() . " - " . $etudiant->getParcours() . "</h3>";
            ?>
        </div>

        <div class="detailsEtudiants">
            <?php
            //on affiche toutes les informations de l'étudiant
            echo "<h3 class='titre'>Informations :</h3>";
            echo "<p>Numéro Étudiant : " . $etudiant->getNumEtudiant() . "</p>";
            echo "<p>Login : " . $etudiant->getLogin() . "</p>";
            echo "<p>Mail Universitaire : " . $etudiant->getMailUniersitaire() . "</p>";
            echo "<p>Mail Personnel : " . $etudiant->getMailPerso() . "</p>";
            echo "<p>Téléphone : " . $etudiant->getTelephone() . "</p>";
            echo "<p>Groupe : " . $etudiant->getGroupe() . "</p>";
            echo "<p>Numéro Étudiant : " . $etudiant->getNumEtudiant() . "</p>";
            ?>
        </div>

        <div class="wrapBoutons">
            <a href="?action=supprimerEtudiant&controleur=AdminMain&numEtu=<?php echo $etudiant->getNumEtudiant() ?>">SUPPRIMER</a>
        </div>

    </div>

    <div class="droiteEtu">
        <p></p>
    </div>
</div>
