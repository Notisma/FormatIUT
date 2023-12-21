<?php

use App\FormatIUT\Configuration\Configuration;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
$offre = (new \App\FormatIUT\Modele\Repository\FormationRepository())->getObjectParClePrimaire($_GET['idFormation']);
$entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
?>

<div class="detailOffreEtu">

    <div class="detailsOffre">

        <div class="entreprise">
            <img src="<?= Configuration::getUploadPathFromId($entreprise->getImg()); ?>" alt="entreprise">
            <h2 class="titre" id="rouge"><?php echo htmlspecialchars($entreprise->getNomEntreprise()) ?></h2>
            <h3 class="titre"><?php echo htmlspecialchars($entreprise->getAdresseEntreprise()) ?>,
                <?php echo htmlspecialchars((new App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille())->getNomVille()) ?></h3>
        </div>

        <div class="offre">
            <h2 class="titre" id="rouge">Description de l'offre :</h2>
            <h3 class="titre"><?php echo htmlspecialchars($offre->getNomOffre()) ?>
                : <?php echo htmlspecialchars($offre->getSujet()) ?>
                - <?php echo htmlspecialchars($offre->getTypeOffre()) ?></h3>
            <h4 class="titre"><?php echo "Du " . htmlspecialchars($offre->getDateDebut()) . " au " . htmlspecialchars($offre->getDateFin()) ?></h4>
            <h4 class="titre">Rémunération : <?php echo $offre->getGratification() ?>€ par mois</h4>
            <h4 class="titre">Durée en heures : <?php echo $offre->getDureeHeure() ?> heures au total</h4>
            <h4 class="titre">Nombre de jours par semaines : <?php echo $offre->getJoursParSemaine() ?> jours</h4>
            <h4 class="titre">Nombre d'Heures hebdomadaires : <?php echo $offre->getNbHeuresHebdo() ?> heures</h4>
            <h5 class="titre">Détails de l'offre : <?php $detailHTML = htmlspecialchars($offre->getDetailProjet());
                echo $detailHTML ?>
            </h5>
        </div>

    </div>

    <div class="actionsOffre">
        <div class="first">
            <img src="../ressources/images/entrepriseOffre.png" alt="details">
            <h3 class="titre">Détails d'une Offre</h3>
        </div>

        <div class="astucesDetails">
            <img src="../ressources/images/astuces.png" alt="astuces">
            <div class="contenuAstuce">
                <h4 class="titre" id="rouge">Astuces</h4>
                <h5 class="titre">
                    Visualisez les informations propres à une offre sur une seule page !
                </h5>
                <h5 class="titre">Pratique : consultez le nombre de candidats et postulez en un seul click !</h5>
            </div>
        </div>

        <div class="wrapActionsCandidat">

            <div class="candidature">
                <img src="../ressources/images/equipe.png" alt="equipe">
                <?php

                $formation = (new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdFormation());
                if ($formation) {
                    if ($formation->getIdEtudiant() == \App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant()) {
                        echo "
                <h4 class='titre'>Vous avez l'offre</h4></div>";
                    } else {
                        echo "
                <h4 class='titre'>L'offre est déjà occupée </h4></div>";
                    }
                } else {
                    $listeEtu = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsEnAttente($offre->getIdFormation()));
                    if (empty($listeEtu)) {
                        echo "
                <h4 class='titre'>Personne n'a postulé. Faites Vite !</h4>
               
                ";
                    } else {
                        echo "
               
                <img src='../ressources/images/equipe.png' alt='postulants'>
                <h4 class='titre'>";
                        $nbEtudiants = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbPostulations($offre->getIdFormation()));
                        echo $nbEtudiants . " étudiant";
                        if ($nbEtudiants == 1) echo " a";
                        else echo "s ont";
                        echo " déjà postulé.</h4>
                    ";
                    }
                }


                ?>
            </div>

            <div class="boutonCandidater">
                <?php
                //<a id="my-button" class="boutonAssigner" onclick="afficherPopupDepotCV_LM()

                $listeAVerifier = ((new \App\FormatIUT\Modele\Repository\FormationRepository())->offresPourEtudiant($etudiant->getNumEtudiant()));
                //si $listeAVerifier est vide ou ne contient pas l'id de l'offre, on affiche le bouton
                if (empty($listeAVerifier) || !in_array($offre->getIdFormation(), $listeAVerifier)) {
                    echo "<a id='my-button' class='boutonAssigner' onclick='afficherPopupDepotCV_LM()'>Postuler à cette Offre</a>";
                } else {
                    echo "<a id='my-button' class='boutonAssigner' onclick='afficherPopupModifCV_LM()'>Modifier les Fichiers</a>";
                }

                ?>

            </div>

        </div>

    </div>

</div>
