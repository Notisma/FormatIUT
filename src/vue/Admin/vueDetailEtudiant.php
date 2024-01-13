<?php

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

$etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST["numEtudiant"]);

/** @var Etudiant $etudiant */
?>

<div class="wrapCentreEtu">
    <div class="gaucheEtu">
        <div class="infosEtu">
            <?php

            $prenomHTML = htmlspecialchars($etudiant->getPrenomEtudiant());
            $nomHTML = htmlspecialchars($etudiant->getNomEtudiant());
            $parcoursHTML = htmlspecialchars($etudiant->getParcours());
            $groupeHTML = htmlspecialchars($etudiant->getGroupe());
            echo "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($etudiant->getImg()) . "' alt='etudiant'>";
            echo "<h1 class='titre rouge'>" . $prenomHTML . " " . $nomHTML . "</h1>";
            if ($etudiant->getGroupe() != null && $etudiant->getParcours() != null) {
                echo "<h3 class='titre'>" . $groupeHTML . " - " . $parcoursHTML . "</h3>";
            } else {
                echo "<h3 class='titre'>Des données sont manquantes</h3>";
            }
            ?>
        </div>

        <div class="detailsEtudiants">
            <?php
            $mailHTML = htmlspecialchars($etudiant->getMailPerso());
            $telHTML = htmlspecialchars($etudiant->getTelephone());
            $loginHTML = htmlspecialchars($etudiant->getLogin());
            $mailEtuHTML = htmlspecialchars($etudiant->getMailUniersitaire());
            echo "<h3 class='titre'>Informations :</h3>";
            echo "<p>Numéro Étudiant : " . $etudiant->getNumEtudiant() . "</p>";
            echo "<p>Login : " . $loginHTML . "</p>";
            echo "<p>Mail Universitaire : " . $mailEtuHTML . "</p>";
            echo "<p>Mail Personnel : " . $mailHTML . "</p>";
            echo "<p>Téléphone : " . $telHTML . "</p>";
            echo "<p>Groupe : " . $groupeHTML . "</p>";
            ?>
        </div>

        <?php
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") { ?>
            <div class="wrapBoutons">
                <a href="?action=supprimerEtudiant&controleur=AdminMain&numEtu=<?php echo $etudiant->getNumEtudiant() ?>">SUPPRIMER</a>
                <a href="?action=afficherFormulaireModifEtudiant&controleur=AdminMain&numEtu=<?php echo $etudiant->getNumEtudiant() ?>">MODIFIER</a>
                <?php if ($aFormation != null && $aFormation->getloginTuteurUM() == null) {
                    echo '<a href="?action=seProposerEnTuteurUM&controleur=AdminMain&numEtu=' . $etudiant->getNumEtudiant() . '">Devenir tuteur</a>';
                } ?>
            </div>
        <?php } else if (ConnexionUtilisateur::getTypeConnecte() == "Personnels" && $aFormation != null && $aFormation->getloginTuteurUM() == null) {
            echo '<div class="wrapBoutons">
            <a href="?action=seProposerEnTuteurUM&controleur=AdminMain&numEtu=' . $etudiant->getNumEtudiant() . '">Devenir tuteur</a>
            </div>';
        } ?>

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
                        $nomOffreHTML = htmlspecialchars($offre->getNomOffre());
                        $nomEntrHTML = htmlspecialchars($entreprise->getNomEntreprise());
                        echo "<a class='offre' href='?action=afficherVueDetailOffre&controleur=AdminMain&idFormation=" . $offre->getidFormation() . "'>" .
                            "<div class='imgOffre'>" .
                            "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($entreprise->getImg()) . "' alt='offre'>" .
                            "</div>" .
                            "<div class='infosOffre'>" .
                            "<h3 class='titre'>" . $nomOffreHTML . "</h3>" .
                            "<h4 class='titre'>" . $nomEntrHTML . "</h4>" .
                            "<h5 class='titre'>Statut : " . (new App\FormatIUT\Modele\Repository\EtudiantRepository())->getAssociationPourOffre($offre->getidFormation(), $etudiant->getNumEtudiant()) . "</h5> " .
                            "</div>" .
                            "</a>";
                    }
                }
            }
            ?>
        </div>

        <?php
        if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
            $formationValidee = (new EtudiantRepository())->getOffreValidee($etudiant->getNumEtudiant());
            /** @var Formation|bool $formationValidee */
            $tuteur = $formationValidee ? $formationValidee->getloginTuteurUM() : false;

            echo "<div class='wrapTuteurUM'>
                    <p>";
            if (!$tuteur) echo "Cet élève n'a pas encore de tuteur UM.";
            else {
                echo "Tuteur UM : ";
                echo $tuteur;
                if (!$formationValidee->isTuteurUMvalide()) {
                    $eleveId = $_GET['numEtudiant'];
                    echo "
                            Acceptez-vous ce tuteur ?
                            <div class='wrapBoutons'>
                                <a href='?action=validerTuteurUM&eleveId=$eleveId'>Valider</a>
                                <a href='?action=refuserTuteurUM&eleveId=$eleveId'>Refuser</a>
                            </div>
                        ";
                }
            }
            echo "</p>
                </div>";
        }
        ?>

    </div>
</div>
