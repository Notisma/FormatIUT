<?php

use App\FormatIUT\Modele\DataObject\Prof;
use App\FormatIUT\Modele\Repository\ProfRepository;

/** @var Prof $prof */
$prof = (new ProfRepository())->getObjectParClePrimaire($_REQUEST["loginProf"]);

?>

<div class="wrapCentreEtu">
    <div class="gaucheEtu">
        <div class="infosEtu">
            <?php

            $prenomHTML = htmlspecialchars($prof->getPrenomProf());
            $nomHTML = htmlspecialchars($prof->getNomProf());
            echo "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($prof->getImg()) . "' alt='prof'>";
            echo "<h1 class='titre rouge'>" . $prenomHTML . " " . $nomHTML . "</h1>";
            if ($prof->isEstAdmin()) {
                echo "Cet enseignant est administrateur de Format'IUT";
            } else {
                echo "Cet enseignant n'est pas administrateur de Format'IUT";
            }
            ?>
        </div>

        <div class="detailsEtudiants">
            <?php
            $mailHTML = htmlspecialchars($prof->getMailUniversitaire());
            echo "<h3 class='titre'>Informations :</h3>";
            echo "<p>Login : " . $_REQUEST['loginProf'] . "</p>";
            echo "<p>Mail Universitaire : " . $mailHTML . "</p>";
            ?>
        </div>

    </div>

    <div class="droiteEtu">
        <h3 class="titre">Etudiants tutorés par cet enseignant :</h3>

        <div class="wrapAllEtu">
            <?php
            //on affiche les étudiants pour lequel ce prof est tuteur
            $listeEtus = (new App\FormatIUT\Modele\Repository\ProfRepository())->getEtudiantsTutores($_REQUEST['loginProf']);

            if (sizeof($listeEtus) < 1) {
                echo "<div class='erreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='erreur'>";
                echo "<h3 class='titre'>Cet enseignant ne tutore aucun étudiant. </h3>";
                echo "</div>";
            } else {
                foreach ($listeEtus as $etu) {
                    if ($etu != null) {
                        $prenomEtuHTML = htmlspecialchars($etu->getPrenomEtudiant());
                        $nomEtuHTML = htmlspecialchars($etu->getNomEtudiant());
                        $offre = (new \App\FormatIUT\Modele\Repository\FormationRepository())->trouverOffreDepuisForm($etu->getNumEtudiant());
                        $nomOffreHTML = htmlspecialchars($offre->getNomOffre());
                        echo "<a class='etu' href='?action=afficherDetailEtudiant&controleur=AdminMain&numEtudiant=" . $etu->getNumEtudiant() . "'>" .
                            "<div class='imgEtu'>" . "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($etu->getImg()) . "' alt='etudiant'>" .
                            "</div>" .
                            "<div class='infosEtu'>" .
                            "<h3 class='titre'>" . $prenomEtuHTML . " " . $nomEtuHTML . "</h3>" .
                            "<h4 class='titre'>" . $nomOffreHTML . " - " . $offre->getTypeOffre() . "</h4>";
                        echo
                            "</div>" .
                            "</a>";
                    }
                }
            }
            ?>
        </div>

    </div>
</div>
