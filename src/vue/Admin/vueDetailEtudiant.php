<?php

use App\FormatIUT\Modele\Repository\EtudiantRepository;

$etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_GET["numEtu"]);
?>

<div class="wrapCentreEtu">
    <div class="gaucheEtu">
        <div class="infosEtu">
            <?php

            $prenomHTML=htmlspecialchars($etudiant->getPrenomEtudiant());
            $nomHTML=htmlspecialchars($etudiant->getNomEtudiant());
            $parcoursHTML=htmlspecialchars($etudiant->getParcours());
            $groupeHTML=htmlspecialchars($etudiant->getGroupe());
            echo "<img src='data:image/jpeg;base64," . base64_encode($etudiant->getImg()) . "' alt='etudiant'>";
            echo "<h1 id='rouge' class='titre'>" . $prenomHTML . " " . $nomHTML . "</h1>";
            if ($etudiant->getGroupe() != null && $etudiant->getParcours() != null) {
                echo "<h3 class='titre'>" . $groupeHTML . " - " . $parcoursHTML . "</h3>";
            } else {
                echo "<h3 class='titre'>Des données sont manquantes</h3>";
            }
            ?>
        </div>

        <div class="detailsEtudiants">
            <?php
            $mailHTML=htmlspecialchars($etudiant->getMailPerso());
            $telHTML=htmlspecialchars($etudiant->getTelephone());
            $loginHTML=htmlspecialchars($etudiant->getLogin());
            $mailEtuHTML=htmlspecialchars($etudiant->getMailUniersitaire());
            echo "<h3 class='titre'>Informations :</h3>";
            echo "<p>Numéro Étudiant : " . $etudiant->getNumEtudiant() . "</p>";
            echo "<p>Login : " . $loginHTML . "</p>";
            echo "<p>Mail Universitaire : " . $mailEtuHTML . "</p>";
            echo "<p>Mail Personnel : " . $mailHTML . "</p>";
            echo "<p>Téléphone : " . $telHTML . "</p>";
            echo "<p>Groupe : " . $groupeHTML . "</p>";
            ?>
        </div>

        <div class="wrapBoutons">
            <a href="?action=supprimerEtudiant&controleur=AdminMain&numEtu=<?php echo $etudiant->getNumEtudiant() ?>">SUPPRIMER</a>
        </div>

    </div>

    <div class="droiteEtu">
        <h3 class="titre">Cet étudiant apparaît dans :</h3>

        <div class="wrapAllEtu">
            <?php
            //on affiche toutes les offres auxquelles l'étudiant a postulé, ou toutes les offres auxquelles il est assigné
            $listeOffres = (new App\FormatIUT\Modele\Repository\FormationRepository())->offresPourEtudiant($etudiant->getNumEtudiant());

            if (sizeof($listeOffres) < 1) {
                echo "<div class='erreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='entreprise'>";
                echo "<h3 class='titre'>Aucune offre n'a été trouvée pour cet étudiant</h3>";
                echo "</div>";
            } else {
                foreach ($listeOffres as $offre) {
                    if ($offre != null) {
                        $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                        $nomOffreHTML=htmlspecialchars($offre->getNomOffre());
                        $nomEntrHTML=htmlspecialchars($entreprise->getNomEntreprise());
                        echo "<a class='offre' href='?action=afficherVueDetailOffre&controleur=AdminMain&idFormation=" . $offre->getidFormation() . "'>" .
                            "<div class='imgOffre'>" .
                            "<img src='data:image/jpeg;base64," . base64_encode($entreprise->getImg()) . "' alt='offre'>" .
                            "</div>" .
                            "<div class='infosOffre'>" .
                            "<h3 class='titre'>" . $nomOffreHTML . "</h3>" .
                            "<h4 class='titre'>" . $nomEntrHTML . "</h4>" .
                            "<h5 class='titre'>Statut : " . (new App\FormatIUT\Modele\Repository\EtudiantRepository())->getAssociationPourOffre($offre->getidFormation(), $etudiant->getNumEtudiant() ) . "</h5> " .
                            "</div>" .
                            "</a>";
                    }
                }
            }
            ?>
        </div>


    </div>
</div>
