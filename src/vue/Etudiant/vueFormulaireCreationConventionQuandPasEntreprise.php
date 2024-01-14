<?php

/** @var Etudiant $etudiant */

use App\FormatIUT\Modele\DataObject\Etudiant;

$anneeUniv = "";
if (date("m") >= 9) {
    $anneeUniv = date("Y") . "/" . (date("Y") + 1);
} else {
    $anneeUniv = (date("Y") - 1) . "/" . date("Y");
}

?>
<h3>Uniquement utiliser cette création manuelle si vous avez déjà un stage mais que l'entreprise n'est pas sur le site
    !</h3>
<form method="post" class="formulaireConv" action='?action=creerConventionSansEntreprise&controleur=EtuMain'>
    <div class="pageConvention">
        <div class="entete">
            <div>
                <img src="../ressources/images/logo-iut-removed.png" alt="Logo de l'IUT">
                <img src="../ressources/images/um_all.png" alt="Logo de l'IUT">
            </div>
            <h3 class="titre">Année Universitaire <?= $anneeUniv ?></h3>
        </div>

        <div class="titreConv">
            <h2 class="titre"><label for="type_id">Convention de type : </label></h2>
            <div class="inputCentre">
                <select name="typeOffre" id="type_id" required>
                    <option value="">-----</option>
                    <option value="Stage"> Stage</option>
                    <option value="Alternance">Alternance</option>
                </select>
            </div>
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

                <div class="entr">
                    <h5 class="titre">2 - L'ORGANISME D'ACCUEIL</h5>
                    <h6 class="titre">
                        <strong><label for="siret_entr_id">Siret :
                            </label> <input type="number" id="siret_entr_id" name="siret"> </strong>
                        <strong><label for="nom_entr_id">Nom : </label>
                            <input type="text" required id="nom_entr_id" name="nomEntreprise"></strong>
                    </h6>
                    <h6 class="titre">
                        <strong><label for="adresse_id">Adresse : </label>
                            <input type="text" required id="adresse_id" name="adresseEntr"></strong>
                        <strong><label for="ville_id">Ville : </label>
                            <input type="text" required id="ville_id" name="villeEntr"></strong>
                        <strong><label for="postal_id">Code Postal : </label>
                            <input type="number" required id="postal_id" name="codePostalEntr"></strong>
                    </h6>
                    <h6 class="titre">
                        <strong><label for="representant_id">Représenté par (nom du signataire de la convention)
                                :</label>
                            <input type="text" required id="representant_id" name="nomRepresentant"></strong>
                    </h6>
                    <h6 class="titre">
                        <strong><label for="representant_fonction_id">Qualité du représentant :</label>
                            <input type="text" required id="representant_fonction_id"
                                   name="representant_fonction"></strong>
                    </h6>
                    <h6 class="titre">
                        <strong><label for="tel_id">Tél :</label>
                            <input type="tel" required id="tel_id" name="telEntreprise"></strong>
                    </h6>
                    <h6 class="titre">
                        <strong><label for="email_id">Mél :</label>
                            <input type="email" required id="email_id" name="emailEntreprise"></strong>
                    </h6>
                </div>
            </div>

        </div>

        <div class="secondBlock">
            <h5 class="titre">3 - L'Étudiant</h5>
            <div>
                <h6 class="titre">
                    <strong>Nom :</strong> <?= htmlspecialchars($etudiant->getNomEtudiant()); ?></h6>
                <h6 class="titre">
                    <strong>Prénom :</strong> <?= htmlspecialchars($etudiant->getPrenomEtudiant()); ?>
                </h6>
                <h6 class="titre">
                    <strong>Sexe :</strong> <?= htmlspecialchars($etudiant->getSexeEtu()); ?></h6>
                <h6 class="titre">
                    <strong>Numéro d'étudiant
                        :</strong> <?= htmlspecialchars($etudiant->getNumEtudiant()); ?>
                </h6>
                <h6 class="titre"><strong>Tél :</strong> <?= htmlspecialchars($etudiant->getTelephone()); ?></h6>
                <h6 class="titre"><strong>Mél :</strong> <?= htmlspecialchars($etudiant->getMailPerso()); ?></h6>
                <h6 class="titre"><strong>INTITULÉ DE LA FORMATION OU CURSUS SUIVI DANS L'ÉTABLISSEMENT D'ENSEIGNEMENT
                        SUPÉRIEUR ET VOLUME HORAIRE (ANNUEL OU SEMESTRIEL) :</strong>
                    BUT <?= htmlspecialchars($etudiant->getAnneeEtu()) ?>
                    INFO <?= htmlspecialchars($etudiant->getParcours()); ?></h6>
            </div>
        </div>

        <div class="threeBlock">
            <h5 class="titre"><label for="sujet_id">SUJET : </label>
                <input type="text" required id="sujet_id" name="offreSujet">
            </h5>
            <div>
                <h6 class="titre">
                    <strong>Dates :</strong> du
                    <label for="debutdate_id"></label><input type="date" required id="debutdate_id"
                                                             name="offreDateDebut">
                    au
                    <label for="findate_id"></label><input type="date" required id="findate_id" name="offreDateFin">
                </h6>
                <h6 class="titre"><strong>Intitulé de la formation :</strong>
                    BUT INFORMATIQUE,
                    <label for="anneeBUT_id"> année : </label>
                    <input type="number" required id="anneeBUT_id" name="etudiantAnneeEtu" min="1" max="3">
                    ,
                    <label for="parcoursBUT_id"> parcours : </label>
                    <input type="text" required id="parcoursBUT_id" name="etudiantParcours">
                </h6>
                <h6 class="titre">
                    <strong><label for="nbHeures_id">Nombre d'heures total dans l'organisme : </label>
                        <input type="number" required id="nbHeures_id" name="offreDureeHeure" min="100" max="2500">
                    </strong>
                    heures de présence effective dans l'organisme d'accueil
                </h6>
                <h6 class="titre">
                    <strong><label for="gratification_id">Gratification : </label>
                        <input type="number" required id="gratification_id" name="offreGratification"></strong>
                    euros par MOIS
                </h6>
                <h6 class="titre">
                    <strong><label for="commentaire_id">Commentaire : </label></strong>
                    <input type="text" required name="commentaire" id="commentaire_id" maxlength="10000">
                </h6>
                <h6 class="titre">
                    <strong><label for="assurance_id">Assurance : </label></strong>
                    <input class="inputAssur" required type="text" name="assurance" id="assurance_id">
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
        </div>

        <div>
            <h5 class="titre">Encadrement de l'étudiant par l'organisme d'accueil</h5>
            <h6 class="titre">
                <strong><label for="nom_tuteur_id">Nom du tuteur de l'entreprise : </label></strong>
                <input type="text" id="nom_tuteur_id" name="nomTuteurPro">
                <strong><label for="prenom_tuteur_id">Prénom du tuteur de l'entreprise : </label></strong>
                <input type="text" id="prenom_tuteur_id" name="prenomTuteurPro">
            </h6>
            <h6 class="titre"><strong>Mél :</strong> remi.coletta@umontpellier.fr</h6>
            <h6 class="titre"><strong>Tél :</strong> +33 4 67 41 85 41</h6>
        </div>

    </div>

    <input type="hidden" value="<?= $etudiant->getNumEtudiant() ?>" name="numEtu">
    <input type="hidden" value="<?= date('d-m-Y'); ?>" name="dateCreation">

    <input type='submit' value='Créer convention'>

</form>
