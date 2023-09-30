<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
</head>
<body>
<div id="center">
<form>
    <fieldset>
        <legend>Création d'une offre</legend>
        <p>
            <label class="labelFormulaire" for="idOffre_id" >IdOffre</label>
            <input class="inputFormulaire" type="text" name="idOffre" id="idOffre_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="nomOffre_id">NomOffre</label>
            <input class="inputFormulaire" type="text" name="NomOffre" id="nomOffre_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="dateDebut_id">Date de début</label>
            <input class="inputFormulaire" type="date" name="DateDebut" id="dateDebut_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="dateFin_id">Date de fin</label>
            <input class="inputFormulaire" type="date" name="DateFin" id="dateFin_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="sujet_id">Sujet</label>
            <input class="inputFormulaire" type="text" name="suejet" id="sujet_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="detailProjet_id">Détail du projet</label>
            <input class="inputFormulaire" type="text" name="detailProjet" id="detailProjet_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="gratification_id">Gratification</label>
            <input class="inputFormulaire" type="text" name="gratification" id="gratification_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="dureeHeures_id">Durée en heure</label>
            <input class="inputFormulaire" type="number" name="dureeHeures" id="dureeHeures_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="jourParSemaine_id">Nombres de jours par Semaine</label>
            <input class="inputFormulaire" type="number" name="joursParSemaine" id="jourParSemaine_id" required>
        </p>
        <p>
            <label class="labelFormulaire" for="nbHeureHebdo_id">Nombre d'heure Hebdomadaire</label>
            <input class="inputFormulaire" type="number" name="nbHeuresHebdo" id="nbHeureHebdo_id" required>
        </p>
        <p>
            <input type="submit" value="Envoyer">
            <input type="hidden" name="controleur" value="EntrMain">
            <input type="hidden" name="action" value="creerOffre">
        </p>

    </fieldset>
</form>
</div>
</body>
</html>

