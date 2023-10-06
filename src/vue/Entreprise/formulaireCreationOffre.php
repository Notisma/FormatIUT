<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleFormulaireCreationOffre.css">
</head>
<body>
<div id="center">
    <div class="wrapGauche">

    </div>

    <div class="antiPadding">
        <div class="wrapDroite">
            <form method="get" action="../web/controleurFrontal.php">
                <label class="labelFormulaire" for="type_id">Type d'Offre </label>

                <div class="inputCentre">
                        <select>
                            <option value="Stage" name="typeOffre" id="type_id">Stage</option>
                            <option value="Alternance" name="typeOffre" id="type_id">Alternance</option>
                        </select>
                </div>
                <!--
                <input class="inputFormulaire" type="radio" name="typeFormation" id="type_id" value="Stage"
                       required>Stage
                <input class="inputFormulaire" type="radio" name="typeFormation" id="type_id" value="Alternance">Alternance
                -->
                <label class="labelFormulaire" for="nomOffre_id">Profession visée par l'offre</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="nomOffre" id="nomOffre_id" required placeholder="Développeur Web">
                </div>
                <label class="labelFormulaire" for="dateDebut_id">Date de début de l'offre</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="date" name="dateDebut" id="dateDebut_id" required>
                </div>

                <label class="labelFormulaire" for="dateFin_id">Date de fin de l'offre</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="date" name="dateFin" id="dateFin_id" required>
                </div>


                <label class="labelFormulaire" for="sujet_id">Sujet bref de l'offre</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="sujet" id="sujet_id" placeholder="Développement d'application Web en full stack" required>
                </div>

                    <label class="labelFormulaire" for="detailProjet_id">Détails du projet</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="detailProjet" id="detailProjet_id" placeholder="L'étudiant devra..." required>
                </div>

                    <label class="labelFormulaire" for="gratification_id">Rémunération de l'offre par mois</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="gratification" id="gratification_id" placeholder="420" required>
                </div>

                    <label class="labelFormulaire" for="dureeHeures_id">Durée en heure</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="dureeHeures" id="dureeHeures_id" placeholder="935" required>
                </div>

                    <label class="labelFormulaire" for="jourParSemaine_id">Nombre de jours par Semaine</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="joursParSemaine" id="jourParSemaine_id" placeholder="5" required>
                </div>

                    <label class="labelFormulaire" for="nbHeureHebdo_id">Nombre d'heures Hebdomadaires</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="nbHeuresHebdo" id="nbHeureHebdo_id" placeholder="32" required>
                </div>
                <p>
                    <input type="button" value="Retour">
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="afficherAccueilEtu">
                    <input type="submit" value="Envoyer">
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="creerOffre">
                </p>
            </form>
        </div>
    </div>
</div>
</body>
</html>

