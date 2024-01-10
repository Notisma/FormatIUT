<?php

use App\FormatIUT\Modele\Repository\ConventionRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

$anneeUniv = "";
if (date("m") >= 9) {
    $anneeUniv = date("Y") . "/" . (date("Y") + 1);
} else {
    $anneeUniv = (date("Y") - 1) . "/" . date("Y");
}
$etudiant = (new EtudiantRepository())->getEtudiantParLogin(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte());
?>

<div class="pageConvention">

    <div class="entete">
        <div>
            <img src="../ressources/images/logo-iut-removed.png" alt="Logo de l'IUT">
            <img src="../ressources/images/um_all.png" alt="Logo de l'IUT">
        </div>
        <h3 class="titre">Année Universitaire <?php echo $anneeUniv ?></h3>
    </div>

    <div class="titreConv">
        <h2 class="titre">Convention d<?php if ($offre->getTypeOffre() == "Alternance") {
                echo "'alternance";
            } else {
                echo "e stage";
            }
            ?></h2>
        <h5 class="titre">En référence à l'arrêté du 29 décembre 2014 relatif aux conventions de stage</h5>
    </div>

    <div class="firstBlock">
        <h6 class="titre">Nota : pour faciliter la lecture du document, les mots "stagiaire", "enseignant référent",
            "tuteur de stage", "représentant légal", et "étudiant" sont utilisés au masculin</h6>

        <div class="separateur">
            <div class="etab">
                <h5 class="titre">1 - L'ÉTABLISSEMENT D'ENSEIGNEMENT ou DE FORMATION</h5>
                <h6 class="titre"><strong>Nom :</strong> Université de Montpellier</h6>
                <h6 class="titre"><strong>Adresse :</strong> 34090 Montpellier</h6>
                <h6 class="titre"><strong>Tél :</strong></h6>
                <h6 class="titre"><strong>Représenté par (signataire de la convention) :</strong> Gilles TROMBETTONI
                </h6>
                <h6 class="titre"><strong>Qualité du représentant :</strong> Chef de Département IUT Informatique</h6>
                <h6 class="titre"><strong>Composante/UFR :</strong> IUT MS : INFORMATIQUE</h6>
                <h6 class="titre"><strong>Adresse (si différente de celle de l'établissement) :</strong> Bâtiment K 99
                    avenue d'Occitanie 34090 Montpellier cedex 5</h6>
                <h6 class="titre"><strong>Tél :</strong> 04 99 58 51 80</h6>
                <h6 class="titre"><strong>Mél :</strong> iutms-info@umontpellier.fr</h6>
            </div>

            <?php
            $tuteurPro = (new \App\FormatIUT\Modele\Repository\TuteurProRepository())->getObjectParClePrimaire($offre->getIdTuteurPro());
            ?>
            <div class="entr">
                <h5 class="titre">2 - L'ORGANISME D'ACCUEIL</h5>
                <h6 class="titre"><strong>Nom :</strong> <?= htmlspecialchars($entreprise->getNomEntreprise()); ?></h6>
                <h6 class="titre"><strong>Adresse
                        :</strong> <?= htmlspecialchars($entreprise->getAdresseEntreprise()); ?>
                    , <?= htmlspecialchars($villeEntr->getNomVille()); ?></h6>
                <h6 class="titre"><strong>Représenté par (nom du signataire de la convention)
                        :</strong> <?= htmlspecialchars($tuteurPro->getNomTuteurPro()); ?> <?= htmlspecialchars($tuteurPro->getPrenomTuteurPro()) ?>
                </h6>
                <h6 class="titre"><strong>Qualité du représentant
                        :</strong> <?= htmlspecialchars($tuteurPro->getFonctionTuteurPro()); ?></h6>
                <h6 class="titre"><strong>Tél :</strong> <?= htmlspecialchars($tuteurPro->getTelTuteurPro()); ?></h6>
                <h6 class="titre"><strong>Mél :</strong> <?= htmlspecialchars($tuteurPro->getMailTuteurPro()); ?></h6>
            </div>
        </div>

    </div>

    <div class="secondBlock">
        <h5 class="titre">3 - LE STAGIAIRE</h5>
        <div>
            <h6 class="titre"><strong>Nom :</strong> <?= htmlspecialchars($etudiant->getNomEtudiant()); ?></h6>
            <h6 class="titre"><strong>Prénom :</strong> <?= htmlspecialchars($etudiant->getPrenomEtudiant()); ?></h6>
            <h6 class="titre"><strong>Sexe :</strong> <?= htmlspecialchars($etudiant->getSexeEtu()); ?></h6>
            <h6 class="titre"><strong>Numéro d'étudiant :</strong> <?= htmlspecialchars($etudiant->getNumEtudiant()); ?>
            </h6>
            <h6 class="titre"><strong>Tél :</strong> <?= htmlspecialchars($etudiant->getTelephone()); ?></h6>
            <h6 class="titre"><strong>Mél :</strong> <?= htmlspecialchars($etudiant->getMailPerso()); ?></h6>
            <h6 class="titre"><strong>INTITULÉ DE LA FORMATION OU CURSUS SUIVI DANS L'ÉTABLISSEMENT D'ENSEIGNEMENT
                    SUPÉRIEUR ET VOLUME
                    HORAIRE (ANNUEL OU SEMESTRIEL) :</strong> BUT <?= htmlspecialchars($etudiant->getAnneeEtu()) ?>
                INFO <?= htmlspecialchars($etudiant->getParcours()); ?></h6>
        </div>
    </div>

    <div class="threeBlock">
        <h5 class="titre">SUJET DE STAGE : <?= htmlspecialchars($offre->getSujet()) ?> </h5>
        <div>
            <h6 class="titre"><strong>Dates :</strong> du <?= htmlspecialchars($offre->getDateDebut()); ?>
                au <?= htmlspecialchars($offre->getDateFin()) ?></h6>
            <h6 class="titre"><strong>Intitulé de la formation :</strong>
                BUT <?= htmlspecialchars($etudiant->getAnneeEtu()) ?>
                INFO <?= htmlspecialchars($etudiant->getParcours()); ?></h6>
            <h6 class="titre"><strong>Correspondant à</strong> <?= htmlspecialchars($offre->getDureeHeure()) ?> heures
                de présence effective dans l'organisme d'accueil</h6>
            <h6 class="titre"><strong>Gratification :</strong> <?= htmlspecialchars($offre->getGratification()); ?>
                euros par MOIS</h6>
            <h6 class="titre"><strong>Commentaire :</strong></h6>
        </div>

    </div>

    <div class="separateur">

        <div>
            <h5 class="titre">Encadrement du stagiaire par l'établissement d'enseignement</h5>
            <h6 class="titre"><strong>Nom et prénom de l'Enseignant référent :</strong> COLETTA Rémi</h6>
            <h6 class="titre"><strong>Mél :</strong> remi.coletta@umontpellier.fr</h6>
            <h6 class="titre"><strong>Tél :</strong> +33 4 67 41 85 41</h6>

        </div>

        <div>
            <h5 class="titre">Encadrement du stagiaire par l'organisme d'accueil</h5>
            <h6 class="titre"><strong>Nom et prénom du tuteur de
                    stage</strong> <?= htmlspecialchars($tuteurPro->getNomTuteurPro()) ?> <?= htmlspecialchars($tuteurPro->getPrenomTuteurPro()) ?>
            </h6>
            <h6 class="titre"><strong>Mél :</strong> remi.coletta@umontpellier.fr</h6>
            <h6 class="titre"><strong>Tél :</strong> +33 4 67 41 85 41</h6>
        </div>

    </div>

</div>
