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
            echo "LOGIN TUTEUR" . $offre->getIdTuteurPro();
            //$tuteurPro = (new \App\FormatIUT\Modele\Repository\TuteurProRepository())->getObjectParClePrimaire($offre->getIdTuteurPro());
            ?>
            <div class="entr">
                <h5 class="titre">2 - L'ORGANISME D'ACCUEIL</h5>
                <h6 class="titre"><strong>Nom :</strong> <?= htmlspecialchars($entreprise->getNomEntreprise()); ?></h6>
                <h6 class="titre"><strong>Adresse :</strong> <?= htmlspecialchars($entreprise->getAdresseEntreprise()); ?>, <?= htmlspecialchars($villeEntr->getNomVille()); ?></h6>
                <h6 class="titre"><strong>Représenté par (nom du signataire de la convention) :</strong> <?= htmlspecialchars($tuteurPro->getNomTuteurPro()); ?> <?= htmlspecialchars($tuteurPro->getPrenomTuteurPro()) ?></h6>
            </div>
        </div>

    </div>

</div>


<div id="center">

    <div class="presentation">

        <form method="post">
            <fieldset>
                <legend> Ma convention :</legend>
                <?php
                if ($offre->getTypeOffre() == "Alternance") {
                    echo '<p><label for="offre_id">Votre alternance : </label>';
                } else {
                    echo '<p><label for="offre_id">Votre stage : </label>';
                } ?>
                <input type="text" value="<?= htmlspecialchars($offre->getNomOffre()) ?>" name="nomOffre" id="offre_id"
                       readonly required>
                </p>
                <p> Informations de l'étudiant :</p>
                <p><label for="num_id"> N° étudiant </label>
                    <input type="text" value="<?= $etudiant->getNumEtudiant(); ?>" name="numEtudiant" id="num_id"
                           readonly required>
                </p>
                <p><label for="nom_id"> Nom </label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getNomEtudiant()); ?>" name="nomEtudiant"
                           id="nom_id"
                           readonly required>
                </p>
                <p><label for="prenom_id"> Nom </label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getPrenomEtudiant()); ?>"
                           name="prenomEtudiant"
                           id="prenom_id" readonly required>
                </p>
                <p><label for="tel_id"> N° tel </label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getTelephone()) ?>" name="telephone"
                           id="tel_id" readonly
                           required></p>
                <p><label for="mail_id">Mail</label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getMailPerso()); ?>" name="mailEtu"
                           id="mail_id" readonly
                           required></p>
                <p><label for="assu_id">Assurance</label>
                    <input type="text" value="<?= htmlspecialchars($offre->getAssurance()); ?>" name="assurance"
                           id="assu_id" readonly
                           required></p>
                <p>Informations de l'entreprise :</p>
                <p><label for="sir_id">Siret</label>
                    <input type="number" value="<?= $entreprise->getSiret(); ?>" name="siret" id="assu_id" readonly
                           required></p>
                <p><label for="nomEntr_id"> Nom entreprise </label>
                    <input type="text" value="<?= htmlspecialchars($entreprise->getNomEntreprise()); ?>"
                           name="nomEntreprise" id="nomEntr_id" readonly
                           required>
                </p>
                <p><label for="adrEntr_id">Adresse Entreprise</label>
                    <input type="text" value="<?= htmlspecialchars($entreprise->getAdresseEntreprise()); ?>"
                           name="adresseEntr" id="adrEntr_id" readonly
                           required></p>
                <p><label for="villeEntr_id"> Ville </label>
                    <input type="text" value="<?= htmlspecialchars($villeEntr->getNomVille()); ?>" name="villeEntr"
                           id="villeEntr_id" readonly
                           required>
                <p><label for="cpEntr_id">Code postal </label>
                    <input type="text" value="<?= $villeEntr->getCodePostal(); ?>" name="codePostalEntr" id="cpEntr_id"
                           readonly
                           required></p>
                <?php if ($offre->getTypeOffre() == "Alternance") {
                    echo '<p><label for="debut_id"> Alternance : Date début </label>
                    <input type="date" value="' . $offre->getDateDebut() . '" name="dateDebut" id="debut_id" readonly
                           required>
                    <label for="fin_id"> Date fin </label>
                    <input type="date" value="' . $offre->getDateFin() . '" name="dateFin" id="fin_id" readonly
                           required></p>
                <p>
                    <label class="labelFormulaire" for="objStage_id">Programme de formation : </label>
                    <input class="inputFormulaire" value="' . htmlspecialchars($offre->getObjectifOffre()) . '" name="objectifOffre" id="objStage_id"
                              readonly required>
                </p>';
                } else {
                    echo '<p><label for="debut_id"> Stage : Date début </label>
                    <input type="date" value="' . $offre->getDateDebut() . '" name="dateDebut" id="debut_id" required>
                    <label for="fin_id"> Date fin </label>
                    <input type="date" value="' . $offre->getDateFin() . '" name="dateFin" id="fin_id" required></p>
                <p>
                    <label class="labelFormulaire" for="objStage_id">Objectifs du stage : </label>
                    <input class="inputFormulaire" value="' . htmlspecialchars($offre->getObjectifOffre()) . '" name="objectifOffre" id="objStage_id"
                              readonly required>
                </p>';
                } ?>


            </fieldset>
        </form>
    </div>
</div>