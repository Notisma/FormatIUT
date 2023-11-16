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
            if ($etudiant->getGroupe() != null && $etudiant->getParcours() != null) {
                echo "<h3 class='titre'>" . $etudiant->getGroupe() . " - " . $etudiant->getParcours() . "</h3>";
            } else {
                echo "<h3 class='titre'>Des données sont manquantes</h3>";
            }
            ?>
        </div>

        <div class="detailsEtudiants">
            <?php
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
        <h3 class="titre">Cet étudiant apparaît dans :</h3>

        <div class="wrapAllEtu">
            <?php
            //on affiche toutes les offres auxquelles l'étudiant a postulé, ou toutes les offres auxquelles il est assigné
            $listeOffres = (new App\FormatIUT\Modele\Repository\OffreRepository())->offresPourEtudiant($etudiant->getNumEtudiant());

            if (sizeof($listeOffres) < 1) {
                echo "<div class='erreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='entreprise'>";
                echo "<h3 class='titre'>Aucune offre n'a été trouvée pour cet étudiant</h3>";
                echo "</div>";
            } else {
                foreach ($listeOffres as $offre) {
                    if ($offre != null) {
                        $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                        echo "<a class='offre' href='?action=afficherVueDetailOffre&controleur=AdminMain&idOffre=" . $offre->getIdOffre() . "'>" .
                            "<div class='imgOffre'>" .
                            "<img src='data:image/jpeg;base64," . base64_encode($entreprise->getImg()) . "' alt='offre'>" .
                            "</div>" .
                            "<div class='infosOffre'>" .
                            "<h3 class='titre'>" . $offre->getNomOffre() . "</h3>" .
                            "<h4 class='titre'>" . $entreprise->getNomEntreprise() . "</h4>" .
                            "<h5 class='titre'>Statut : " . (new App\FormatIUT\Modele\Repository\EtudiantRepository())->getAssociationPourOffre($offre->getIdOffre(), $etudiant->getNumEtudiant() ) . "</h5> " .
                            "</div>" .
                            "</a>";
                    }
                }
            }
            ?>
        </div>


    </div>
</div>
