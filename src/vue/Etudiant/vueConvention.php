<?php

/** @var Formation $offre */
/** @var Entreprise $entreprise */
/** @var Ville $villeEntr */
/** @var Etudiant $etudiant */

/** @var ConventionEtat $etat */

use App\FormatIUT\Lib\Users\Entreprise;
use App\FormatIUT\Modele\DataObject\Etudiant;
use App\FormatIUT\Modele\DataObject\Formation;
use App\FormatIUT\Modele\DataObject\TuteurPro;
use App\FormatIUT\Modele\DataObject\Ville;
use App\FormatIUT\Modele\Repository\ConventionEtat;
use App\FormatIUT\Modele\Repository\TuteurProRepository;

$anneeUniv = "";
if (date("m") >= 9) {
    $anneeUniv = date("Y") . "/" . (date("Y") + 1);
} else {
    $anneeUniv = (date("Y") - 1) . "/" . date("Y");
}
$estStage = false;

?>
<form method="post" class="formulaireConv"
<?php
$etuId = $etudiant->getNumEtudiant();
echo match ($etat) {
    ConventionEtat::Creation => "action='?action=creerConvention&controleur=EtuMain'>",
    ConventionEtat::Modification => "action='?action=modifierConvention&controleur=EtuMain&numEtudiant=$etuId'>",
    default => ">",
};
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
                $estStage = true;
            }
            ?></h2>
        <h5 class="titre">En référence à l'arrêté du 29 décembre 2014 relatif aux conventions de stage et
            d'alternance</h5>
    </div>

    <div class="firstBlock">
        <h6 class="titre">Nota : pour faciliter la lecture du document, les mots "stagiaire", "alternant",
            "enseignant référent",
            "tuteur de stage", "représentant légal", et "étudiant" sont utilisés au masculin</h6>

        <div class="separateur">
            <div class="etab">
                <h5 class="titre">1 - L'ÉTABLISSEMENT D'ENSEIGNEMENT ou DE FORMATION</h5>
                <h6 class="titre"><strong>Nom :</strong> Université de Montpellier</h6>
                <h6 class="titre"><strong>Adresse :</strong> 34090 Montpellier</h6>
                <h6 class="titre"><strong>Tél :</strong></h6>
                <h6 class="titre"><strong>Représenté par (signataire de la convention) :</strong> Gilles TROMBETTONI
                </h6>
                <h6 class="titre"><strong>Qualité du représentant :</strong> Chef de Département IUT Informatique
                </h6>
                <h6 class="titre"><strong>Composante/UFR :</strong> IUT MS : INFORMATIQUE</h6>
                <h6 class="titre"><strong>Adresse (si différente de celle de l'établissement) :</strong> Bâtiment K
                    99
                    avenue d'Occitanie 34090 Montpellier cedex 5</h6>
                <h6 class="titre"><strong>Tél :</strong> 04 99 58 51 80</h6>
                <h6 class="titre"><strong>Mél :</strong> iutms-info@umontpellier.fr</h6>
            </div>

            <?php
            /** @var TuteurPro $tuteurPro */
            $tuteurPro = (new TuteurProRepository())->getObjectParClePrimaire($offre->getIdTuteurPro());
            if (is_null($tuteurPro)) $tuteurPro = new TuteurPro("-1", "", "", "", "", "", -1);
            ?>
            <div class="entr">
                <h5 class="titre">2 - L'ORGANISME D'ACCUEIL</h5>
                <h6 class="titre"><strong>Nom :</strong> <?= htmlspecialchars($entreprise->getNomEntreprise()); ?>
                </h6>
                <h6 class="titre"><strong>Adresse
                        :</strong> <?= htmlspecialchars($entreprise->getAdresseEntreprise()); ?>
                    , <?= htmlspecialchars($villeEntr->getNomVille()); ?></h6>
                <h6 class="titre"><strong>Représenté par (nom du signataire de la convention)
                        :</strong> <?= htmlspecialchars($tuteurPro->getNomTuteurPro()); ?> <?= htmlspecialchars($tuteurPro->getPrenomTuteurPro()) ?>
                </h6>
                <h6 class="titre"><strong>Qualité du représentant
                        :</strong> <?= htmlspecialchars($tuteurPro->getFonctionTuteurPro()); ?></h6>
                <h6 class="titre"><strong>Tél :</strong> <?= htmlspecialchars($tuteurPro->getTelTuteurPro()); ?>
                </h6>
                <h6 class="titre"><strong>Mél :</strong> <?= htmlspecialchars($tuteurPro->getMailTuteurPro()); ?>
                </h6>
            </div>
        </div>

    </div>

    <div class="secondBlock">
        <h5 class="titre">3 - L'Étudiant</h5>
        <div>
            <h6 class="titre"><strong>Nom :</strong> <?= htmlspecialchars($etudiant->getNomEtudiant()); ?></h6>
            <h6 class="titre"><strong>Prénom :</strong> <?= htmlspecialchars($etudiant->getPrenomEtudiant()); ?>
            </h6>
            <h6 class="titre"><strong>Sexe :</strong> <?= htmlspecialchars($etudiant->getSexeEtu()); ?></h6>
            <h6 class="titre"><strong>Numéro d'étudiant
                    :</strong> <?= htmlspecialchars($etudiant->getNumEtudiant()); ?>
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
        <h5 class="titre">SUJET D<?php if ($estStage) {
                echo "E STAGE";
            } else {
                echo "' ALTERNANCE";
            } ?> : <?= htmlspecialchars($offre->getSujet()) ?> </h5>
        <div>
            <h6 class="titre"><strong>Dates :</strong> du <?= htmlspecialchars($offre->getDateDebut()); ?>
                au <?= htmlspecialchars($offre->getDateFin()) ?></h6>
            <h6 class="titre"><strong>Intitulé de la formation :</strong>
                BUT <?= htmlspecialchars($etudiant->getAnneeEtu()) ?>
                INFO <?= htmlspecialchars($etudiant->getParcours()); ?></h6>
            <h6 class="titre"><strong>Correspondant à</strong> <?= htmlspecialchars($offre->getDureeHeure()) ?>
                heures
                de présence effective dans l'organisme d'accueil</h6>
            <h6 class="titre"><strong>Gratification :</strong> <?= htmlspecialchars($offre->getGratification()); ?>
                euros par MOIS</h6>
            <h6 class="titre"><strong>Commentaire :</strong></h6>
            <h6 class="titre"><strong>Assurance : </strong>
                <label for="assu_id"></label>
                <input class="inputAssur" placeholder="Caisse d'épargne" type="text"
                       name="assurance"
                    <?php if (!empty($offre->getAssurance())) {
                        echo 'value="' . htmlspecialchars($offre->getAssurance()) . '"';
                    }
                    if ($etat == ConventionEtat::VisuEtudiant || $etat == ConventionEtat::VisuAdmin) echo " readonly ";
                    ?>
                       id="assu_id" required>
            </h6>
        </div>

    </div>

    <div class="separateur">

        <div>
            <h5 class="titre">Encadrement de l'étudiant par l'établissement d'enseignement</h5>
            <h6 class="titre"><strong>Nom et prénom de l'Enseignant référent :</strong> COLETTA Rémi</h6>
            <h6 class="titre"><strong>Mél :</strong> remi.coletta@umontpellier.fr</h6>
            <h6 class="titre"><strong>Tél :</strong> +33 4 67 41 85 41</h6>
        </div>

        <div>
            <h5 class="titre">Encadrement de l'étudiant par l'organisme d'accueil</h5>
            <h6 class="titre"><strong>Nom et prénom du tuteur de
                    l'entreprise </strong> <?= htmlspecialchars($tuteurPro->getNomTuteurPro()) ?> <?= htmlspecialchars($tuteurPro->getPrenomTuteurPro()) ?>
            </h6>
            <h6 class="titre"><strong>Mél :</strong> remi.coletta@umontpellier.fr</h6>
            <h6 class="titre"><strong>Tél :</strong> +33 4 67 41 85 41</h6>
        </div>

    </div>

</div>

<input type="hidden" value="<?= date('d-m-Y'); ?>" name="dateCreation">
<input type="hidden" value="<?= $entreprise->getSiret() ?>" name="siret">
<input type="hidden" value="<?= $villeEntr->getCodePostal() ?>" name="codePostalEntr">
<input type="hidden" value="<?= $offre->getIdFormation() ?>" name="idOff">
<input type="hidden" value="<?= $entreprise->getNomEntreprise() ?>" name="nomEntreprise">
<input type="hidden" value="<?= $entreprise->getAdresseEntreprise() ?>" name="adresseEntr">
<input type="hidden" name="villeEntr" value="<?= htmlspecialchars($villeEntr->getNomVille()); ?>">
<input type="hidden" name="codePostalEntr" value="<?= $villeEntr->getCodePostal(); ?>">
<?php
$dateDebut = $offre->getDateDebut();
$dateFin = $offre->getDateFin();

echo '<input type="hidden" name="dateDebut" value="' . $dateDebut . '">
    <input type="hidden" name="dateFin" value="' . $dateFin . '">';

switch ($etat) {
    case ConventionEtat::Creation:
        echo "<input type='submit' value='Créer convention'>";
        break;
    case ConventionEtat::Modification:
        echo "<input type='submit' value='Enregister modifications'>";
        break;
    case ConventionEtat::VisuEtudiant:
        if ($offre->getConventionValidee())
            echo "<h3>Convention validée !</h3>";
        else
            echo "
                <div class='wrapBoutons'>
                    <a href='?action=afficherFormulaireModifierConvention'>Modifier</a>
                    <a href='?action=faireValiderConvention'>Faire valider</a>
                </div>
            ";
        break;
    case ConventionEtat::VisuAdmin:
        if ($offre->getConventionValidee())
            echo "<h3>Convention validée !</h3>";
        else
            echo "
                <div class='wrapBoutons'>
                    <a href='?action=validerConvention&controleur=AdminMain&numEtudiant=$etuId'>Valider</a>
                    <a href='?action=rejeterConvention&controleur=AdminMain&numEtudiant=$etuId'>Rejeter</a>
                </div>
            ";
        break;
}

?>

</form>
