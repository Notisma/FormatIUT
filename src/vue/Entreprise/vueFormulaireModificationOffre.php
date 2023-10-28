<div id="center">
    <div class="wrapDroite">
        <form method="post" action="../web/controleurFrontal.php">
            <h1>MODIFIEZ VOTRE OFFRE ICI</h1>

            <label class="labelFormulaire" for="typeOffre">Type d'Offre</label>
            <div class="inputCentre">
                <select name="typeOffre" id="typeOffre">
                    <option value="Stage" <?php if ($offre->getTypeOffre() == "Stage") echo 'selected' ?>>
                        Stage
                    </option>
                    <option value="Alternance" <?php if ($offre->getTypeOffre() == "Alternance") echo 'selected' ?>>
                        Alternance
                    </option>
                </select>
            </div>

            <label class="labelFormulaire" for="nomOffre_id">Profession visée par l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="text" name="nomOffre" id="nomOffre_id" required
                       value="<?= $offre->getNomOffre() ?>" maxlength="24">
            </div>

            <label class="labelFormulaire" for="dateDebut_id">Date de début de l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="date" name="dateDebut" id="dateDebut_id"
                       value="<?= $offre->getDateDebut()->format("Y-m-d"); ?>" required>
            </div>

            <label class="labelFormulaire" for="dateFin_id">Date de fin de l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="date" name="dateFin" id="dateFin_id"
                       value="<?= $offre->getDateFin()->format("Y-m-d"); ?>" required>
            </div>

            <label class="labelFormulaire" for="sujet_id">Sujet bref de l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="text" name="sujet" id="sujet_id"
                       value="<?= $offre->getSujet() ?>" required maxlength="50">
            </div>

            <label class="labelFormulaire" for="detailProjet_id">Détails du projet</label>
            <br>
            <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="detailProjet" id="detailProjet_id" required maxlength="255"
                    ><?= $offre->getDetailProjet() ?>
                    </textarea>
            </div>

            <label class="labelFormulaire" for="gratification_id">Rémunération de l'offre par mois</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="gratification" id="gratification_id"
                       value="<?= $offre->getGratification() ?>" required min="1" max="9999">
            </div>

            <label class="labelFormulaire" for="dureeHeures_id">Durée en heure</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="dureeHeures" id="dureeHeures_id"
                       value="<?= $offre->getDureeHeures() ?>" required min="1" max="9999">
            </div>

            <label class="labelFormulaire" for="jourParSemaine_id">Nombre de jours par semaine</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="joursParSemaine" id="jourParSemaine_id"
                       value="<?= $offre->getJoursParSemaine() ?>" required min="1" max="6">
            </div>

            <label class="labelFormulaire" for="nbHeureHebdo_id">Nombre d'heures hebdomadaires</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="nbHeuresHebdo" id="nbHeureHebdo_id"
                       value="<?= $offre->getNbHeuresHebdo() ?>" required min="1" max="99">
            </div>

            <div class="boutonsForm">
                <input type="hidden" name="idOffre" value="<?= $offre->getIdOffre() ?>">
                <input type="submit" value="Réinitialiser" formaction="?action=afficherFormulaireModificationOffre&controleur=EntrMain">
                <input type="submit" value="Envoyer" formaction="?action=modifierOffre&controleur=EntrMain">
            </div>
        </form>
    </div>
</div>
