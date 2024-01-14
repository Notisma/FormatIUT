<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
use App\FormatIUT\Modele\Repository\PostulerRepository;

$etudiant = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['idEtudiant']);
$formation = (new FormationRepository())->getObjectParClePrimaire($_REQUEST['idFormation']);
?>

<div class="mainDetails">

    <div class="mainEtudiant">
        <div class="partieGauche">
            <div>
                <img src="<?= Configuration::getUploadPathFromId($etudiant->getImg()) ?>" alt="">
                <h2 class="titre rouge">Détails de
                    l'étudiant <?= htmlspecialchars($etudiant->getPrenomEtudiant()) ?> <?= htmlspecialchars($etudiant->getNomEtudiant()) ?> </h2>
            </div>

            <div>
                <h3 class="titre rouge">Informations</h3>
                <ul>
                    <li><h4 class="titre">Mail Universitaire
                            : <?= htmlspecialchars($etudiant->getMailUniersitaire()) ?></h4></li>
                    <li><h4 class="titre">Groupe : <?= htmlspecialchars($etudiant->getGroupe()) ?></h4></li>
                    <li><h4 class="titre">Étudiant en année <?= htmlspecialchars($etudiant->getAnneeEtu()) ?> de BUT
                            informatique</h4></li>
                    <li><h4 class="titre">Parcours : <?= htmlspecialchars($etudiant->getParcours()) ?></h4></li>
                </ul>
            </div>

            <div>
                <h3 class="titre rouge">En rapport avec votre offre : <?= $formation->getNomOffre() ?></h3>
                <ul>
                    <li><h4 class="titre">Statut de l'Étudiant
                            : <?= (new EtudiantRepository())->getAssociationPourOffre($formation->getIdFormation(), $etudiant->getNumEtudiant()) ?></h4>
                    </li>
                </ul>
                <div class="wrapBoutonsDoc">
                    <?php
                    $cv = (new PostulerRepository())->recupererCV($etudiant->getNumEtudiant(), $formation->getIdFormation());
                    if (!empty($cv)) {
                        echo '<a class="bouton standard" href=?action=telechargerCV&service=Fichier&etudiant=' . $etudiant->getNumEtudiant() . '&idFormation=' . $_REQUEST['idFormation'] . '>Télécharger son CV</a>';
                    }
                    $lm = (new PostulerRepository())->recupererLettre($etudiant->getNumEtudiant(), $formation->getIdFormation());
                    if (!empty($lm)) {
                        echo '<a class="bouton standard" href=?action=telechargerLM&service=Fichier&etudiant=' . $etudiant->getNumEtudiant() . '&idFormation=' . $_REQUEST['idFormation'] . '>Télécharger sa LM</a>';
                    }
                    echo '<a class="bouton special" href="?action=afficherVueDetailOffre&controleur=EntrMain&idFormation=' . $_REQUEST['idFormation'] . '">Retour à l\'offre</a>';
                    ?>
                </div>

            </div>

        </div>

        <div class="autresOffres">
            <h3 class="titre rouge">Autres offres en rapport avec cet étudiant :</h3>
            <?php
            $listeOffres = (new App\FormatIUT\Modele\Repository\FormationRepository())->offresPourEtudiant($etudiant->getNumEtudiant());
            $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEntrepriseConnectee());
            if (!empty($listeOffres)) {
                foreach ($listeOffres as $offre) {
                    if ($offre->getIdEntreprise() == \App\FormatIUT\Lib\ConnexionUtilisateur::getNumEntrepriseConnectee() && $offre->getIdFormation() != $_REQUEST['idFormation']) {
                        echo '
                        <div class="offre">
                        <img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="offre">
                        
                        <div>
                           <h4 class="titre">' . htmlspecialchars($offre->getNomOffre()) . '</h4>
                            <h5 class="titre">Statut : ' . (new EtudiantRepository())->getAssociationPourOffre($offre->getidFormation(), $etudiant->getNumEtudiant()) . '</h5>
                            <a href="?action=afficherVueDetailEtudiant&controleur=EntrMain&idFormation=' . $offre->getidFormation() . '&idEtudiant=' . $etudiant->getNumEtudiant() . '">Voir plus</a>
                        </div>
                        
                        </div>
                        ';
                    }
                }
            }
            ?>
        </div>

    </div>

    <div class="presEtu">
        <div>
            <img src="../ressources/images/etudiantsMesOffres.png" alt="etudiants">
            <h3 class="titre rouge">Détails d'un Candidat</h3>
            <h4 class="titre">Visualisez toutes les données d'un candidat, téléchargez ses fichiers et retrouver vos
                offres dans lesquelles il a candidaté.</h4>
        </div>
    </div>

</div>
