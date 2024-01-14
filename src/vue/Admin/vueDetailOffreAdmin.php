<div class="wrapCentreOffre">
    <?php
    $offre = (new App\FormatIUT\Modele\Repository\FormationRepository())->getObjectParClePrimaire($_REQUEST["idFormation"]);
    $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
    use App\FormatIUT\Configuration\Configuration;
    ?>

    <div class="wrapGauche">
        <a href="?action=afficherDetailEntreprise&controleur=adminMain&siret=<?php echo rawurlencode($entreprise->getSiret()) ?>"
           class="presentationPrincipale">
            <?php


            $nomEntrHTML=htmlspecialchars($entreprise->getNomEntreprise());
            $sujetHTML=htmlspecialchars($offre->getSujet());
            $nomOffreHTML=htmlspecialchars($offre->getNomOffre());
            $detailHTML=htmlspecialchars($offre->getDetailProjet());

            echo '<img src="' .Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">';
            echo "<h2 class='titre rouge'>" . $nomEntrHTML . "</h2>";
            echo "<h3 class='titre'>" . $sujetHTML . " - " . $offre->getTypeOffre() . "</h3>";
            ?>
        </a>


        <div class="wrapDetails">
            <h4 class="titre"> <?php echo $nomOffreHTML . " - " . $sujetHTML ?></h4>
            <p>- Description de l'offre : <?php echo $detailHTML ?></p>
            <p>- Offre
                de <?php echo "" . $offre->getTypeOffre() . " du : " . $offre->getDateDebut() . " au : " . $offre->getDateFin() ?></p>
            <p>- Rémunation : <?php echo $offre->getGratification() ?> €</p>
            <p>- Offre publiée le 17/11/2023</p>
        </div>


        <div class="wrapBoutons">
            <?php
            if (\App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()=="Administrateurs") {
                if (!$offre->getEstValide()) {
                    echo "
                <a href='?action=rejeterFormation&controleur=AdminMain&idFormation=".$offre->getIdFormation()."'>REJETER</a>";

                    if ($entreprise->isEstValide()) {
                        echo "<a id='vert' href='?action=accepterFormation&controleur=AdminMain&idFormation=".$offre->getIdFormation()."'>ACCEPTER</a>";
                    } else {
                        echo "<a id='vert' href='?action=afficherDetailEntreprise&controleur=AdminMain&idEntreprise=".$entreprise->getSiret()."'>ACCEPTER</a>";
                        \App\FormatIUT\Lib\MessageFlash::ajouter("warning", "Validez l'entreprise avant de valider l'offre");
                    }


                } else {
                    echo "
                <a id='modif' href='?action=afficherFormModificationOffre&controleur=AdminMain&idFormation=" . $offre->getIdFormation() . "'>MODIFIER</a>
                <a href='?action=supprimerFormation&controleur=AdminMain&idFormation=" . $offre->getIdFormation() . "'>SUPPRIMER</a>
                ";
                }
            }

            ?>
        </div>

    </div>


    <div class="wrapDroite">
        <h3 class="titre">INFORMATIONS</h3>

        <h4 class="titre">Statut de l'offre :</h4>

        <?php
        if ($offre->getEstValide()) {
            echo "<div class='statutOffre valide' >";
            echo "<img src='../ressources/images/success.png' alt='entreprise'>";
            echo "<h3 class='titre'>Validée - cette offre est postée</h3>";
        } else {
            echo "<div class='statutOffre attente'>";
            echo "<img src='../ressources/images/sablier.png' alt='entreprise'>";
            echo "<h3 class='titre'>En Attente de Validation</h3>";
        }
        echo "</div>";

        ?>


        <div class="detailsEtudiants">
            <?php
            if ($offre->getEstValide()) {
                echo "<h5 class='titre'>Étudiants Candidats :</h5>";
                $listeEtudiants = (new App\FormatIUT\Modele\Repository\EtudiantRepository())->etudiantsCandidats($offre->getIdFormation());

                if (sizeof($listeEtudiants) == 0  ) {
                    echo "<div class='erreur'>";
                    echo "<img src='../ressources/images/erreur.png' alt='entreprise'>";
                    echo "<h4 class='titre'>Aucun étudiant candidat n'a été trouvé pour cette offre</h4>";
                    echo "</div>";
                } else {
                    foreach ($listeEtudiants as $etudiant) {
                        $parcoursHTML=htmlspecialchars($etudiant->getParcours());
                        $groupeHTML=htmlspecialchars($etudiant->getGroupe());
                        $prenomEtuHTML=htmlspecialchars($etudiant->getPrenomEtudiant());
                        $nomEtuHTML=htmlspecialchars($etudiant->getNomEtudiant());
                        echo "<a class='etudiantCandidat' href='?action=afficherDetailEtudiant&controleur=AdminMain&numEtudiant=" . $etudiant->getNumEtudiant() . "'>" .
                            "<div class='imgEtudiant'>" .
                            "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($etudiant->getImg()) . "' alt='etudiant'>" .
                            "</div>" .
                            "<div class='infosEtudiant'>" .
                            "<h3 class='titre rouge'>" . $prenomEtuHTML . " " . $nomEtuHTML . "</h3>" .
                            "<p>" . $groupeHTML . " - " . $parcoursHTML . " - " . (new App\FormatIUT\Modele\Repository\EtudiantRepository())->getAssociationPourOffre($offre->getIdFormation(), $etudiant->getNumEtudiant()) ."</p>" .
                            "</div>" .
                            "</a>";
                    }
                }
            } else {
                echo "<div class='erreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='entreprise'>";
                echo "<h4 class='titre'>Offre non postée</h4>";
                echo "</div>";
            }
            ?>
        </div>


    </div>
</div>
