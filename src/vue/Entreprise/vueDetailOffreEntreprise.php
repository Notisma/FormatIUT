<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;

$offre = (new FormationRepository())->getObjectParClePrimaire($_GET['idFormation']);
$entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEntrepriseConnectee());
$listeEtu = ((new EtudiantRepository())->EtudiantsEnAttente($offre->getIdFormation()));
?>

<div class="detailOffreEtu">

    <div class="detailsOffre">

        <div class="entreprise">
            <img src="<?= Configuration::getUploadPathFromId($entreprise->getImg()); ?>" alt="entreprise">
            <h2 class="titre rouge"><?php echo htmlspecialchars($entreprise->getNomEntreprise()) ?></h2>
            <h3 class="titre"><?php echo htmlspecialchars($entreprise->getAdresseEntreprise()) ?>,
                <?php echo htmlspecialchars((new App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille())->getNomVille()) ?></h3>
        </div>

        <div class="offre">
            <h2 class="titre rouge">Description de l'offre :</h2>
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
            <img src="../ressources/images/entrepriseConnectee.png" alt="details">
            <h3 class="titre">Détails d'une Offre</h3>
        </div>

        <div class="astucesDetails">
            <img src="../ressources/images/astuces.png" alt="astuces">
            <div class="contenuAstuce">
                <h4 class="titre rouge">Astuces</h4>
                <h5 class="titre">
                    Visualisez les informations propres à une offre sur une seule page !
                </h5>
                <h5 class="titre">Pratique : consultez le nombre de candidats et postulez en un seul click !</h5>
            </div>
        </div>

        <?php
        if ($offre->getEstValide()) {
            echo "<div class='statutOffre valide'><img src='../ressources/images/success.png' alt='valide'><p>Offre validée</p></div>";
        } else {
            echo "<div class='statutOffre nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Offre en attente</p></div>";
        }
        ?>

        <div class="wrapActionsCandidat">

            <div class="candidature">
                <img src="../ressources/images/equipe.png" alt="equipe">
                <?php
                $nbCandidats = (new PostulerRepository())->getNbCandidatsPourOffre($offre->getIdFormation());
                if ((new FormationRepository())->estFormation($offre->getIdFormation())) {
                    echo "<h4 class='titre rouge'>Assignée</h4>";
                } else {
                    echo "<h4 class='titre rouge'>$nbCandidats Candidat(s)</h4>";
                }
                ?>
            </div>

            <div class="boutonCandidater">
                <a class='boutonAssigner'
                   href="?action=afficherFormulaireModificationOffre&controleur=EntrMain&idFormation=<?= $offre->getIdFormation() ?>">Modifier
                    l'Offre</a>
                <a class='boutonAssigner' href="?action=supprimerFormation&idFormation=<?= $offre->getIdFormation() ?>">Supprimer l'Offre</a>
            </div>

        </div>


    </div>

</div>

<div class="listeCandidats" id="liste">
    <h3 class="titre rouge">Liste des Candidats</h3>

    <div class="candidatsOverflow">
        <?php
        $listeEtu = ((new EtudiantRepository())->EtudiantsEnAttente($offre->getIdFormation()));
        if (sizeof($listeEtu) > 0) {
            foreach ($listeEtu as $etudiant) {
                echo '<a class="etudiantPostulant" href="?action=afficherVueDetailEtudiant&controleur=EntrMain&idFormation='. $offre->getidFormation() .'&idEtudiant='. $etudiant->getNumEtudiant() .'">
            <div class="illuPostulant">';
                echo '<img src="' . Configuration::getUploadPathFromId($etudiant->getImg()) . '" alt="">';
                echo '</div>
            <div class="nomEtuPostulant">
                <h4 class="titre rouge">';
                echo htmlspecialchars($etudiant->getPrenomEtudiant()) . " " . htmlspecialchars($etudiant->getNomEtudiant());
                $idFormationURl = rawurlencode($offre->getidFormation());
                $idURL = rawurlencode($etudiant->getNumEtudiant());
                echo '</h4>
                    <form method="get">
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="assignerEtudiantFormation">
                    <input type="hidden" name="idFormation" value="'.$idFormationURl.'">
                    <input type="hidden" name="idEtudiant" value="'.$idURL.'">
                <input type="submit"';
                echo ' class="boutonAssigner';
                if ((new PostulerRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offre->getidFormation()) == "A Choisir") {
                    echo ' disabled" value="Envoyée"';
                } else {
                    $formation = (new FormationRepository())->estFormation($offre->getidFormation());
                    if (!is_null($formation)) {
                        echo ' disabled"';
                        if ($formation->getIdEtudiant() == $etudiant->getNumEtudiant()) {
                            echo " value='Assigné'>";
                        } else {
                            echo " value='Assigner'>";
                        }
                    } else {
                        echo "\" value='Assigner'>";
                    }
                }
                echo '</form></div>
    
    </a>';
            }
        } else {
            echo "
                <div class='erreurCand'>
                <h4 class='titre'>Personne n'a postulé.</h4>
                <img src='../ressources/images/erreur.png' alt='erreur'>
                </div>
                ";
        }
        ?>
    </div>

</div>



