<div id="center">
    <div class="wrapDroite">
        <form method="post" action="../web/controleurFrontal.php">
            <h1>MODIFIEZ VOTRE OFFRE ICI</h1>

            <label class="labelFormulaire" for="typeOffre">Type d'Offre</label>
            <div class="inputCentre">
                <select name="typeOffre" id="typeOffre">
                    <option value="Stage/Alternance" <?php if ($offre->getTypeOffre() == "Stage/Alternance") echo 'selected' ?>> Stage et alternance</option>
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
                       value="<?= htmlspecialchars($offre->getNomOffre()) ?>" maxlength="24">
            </div>

            <label class="labelFormulaire" for="anneeMin_id">Année d'étude minimum des étudiants visés</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="anneeMin" id="anneeMin_id" required
                       value="<?= $offre->getAnneeMin() ?>" min="2" max="3">
            </div>

            <label class="labelFormulaire" for="anneeMax_id">Année d'étude maximum des étudiants visés</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="anneeMax" id="anneeMax_id" required
                       value="<?= $offre->getAnneeMax() ?>" min="2" max="3">
            </div>

            <label class="labelFormulaire" for="dateDebut_id">Date de début de l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="date" name="dateDebut" id="dateDebut_id"
                       value="<?= $offre->getDateDebut()->format("Y-m-d"); ?>">
            </div>

            <label class="labelFormulaire" for="dateFin_id">Date de fin de l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="date" name="dateFin" id="dateFin_id"
                       value="<?= $offre->getDateFin()->format("Y-m-d"); ?>">
            </div>

            <label class="labelFormulaire" for="sujet_id">Sujet bref de l'offre</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="text" name="sujet" id="sujet_id"
                       value="<?= htmlspecialchars($offre->getSujet()) ?>" required maxlength="50">
            </div>

            <label class="labelFormulaire" for="detailProjet_id">Détails du projet</label>
            <br>
            <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="detailProjet" id="detailProjet_id" required maxlength="255"
                    ><?= htmlspecialchars($offre->getDetailProjet()) ?>
                    </textarea>
            </div>

            <label class="labelFormulaire" for="objectifOffre_id">Objectifs pour l'étudiant</label>
                <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="objectifOffre" id="objectifOffre_id"
                              <?= $offre->getObjectifOffre() ?>required maxlength="255"></textarea>
                </div>

            <label class="labelFormulaire" for="gratification_id">Rémunération de l'offre par mois</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="gratification" id="gratification_id"
                       value="<?= $offre->getGratification() ?>" required min="1" max="9999">
            </div>

            <label class="labelFormulaire" for="uniteGratification_id">Devise utilisée pour la rémunération</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="uniteGratification" id="uniteGratification_id"
                           value="<?= $offre->getUniteGratification() ?>" required>
                </div>

                <label class="labelFormulaire" for="uniteDureeGratification_id">Rémunération par heure</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="uniteDureeGratification" id="uniteDureeGratification_id"
                           value="<?= $offre->getUniteDureeGratification() ?>" required maxlength="4">
                </div>

            <label class="labelFormulaire" for="dureeHeure_id">Durée en heure</label>
            <div class="inputCentre">
                <input class="inputFormulaire" type="number" name="dureeHeure" id="dureeHeure_id"
                       value="<?= $offre->getDureeHeure() ?>" required min="1" max="9999">
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
                <input type="hidden" name="idFormation" value="<?= $offre->getidFormation() ?>">
                <input type="submit" value="Réinitialiser"
                       formaction="?action=afficherFormulaireModificationOffre&controleur=EntrMain">
                <input type="submit" value="Envoyer" formaction="?action=modifierOffre&controleur=EntrMain">
            </div>
        </form>
    </div>
</div>
