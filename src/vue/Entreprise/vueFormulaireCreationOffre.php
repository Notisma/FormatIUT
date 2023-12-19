<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleFormulaireCreationOffre.css">
</head>
<body>
<div id="center">
    <div class="wrapGauche">
        <img src="../ressources/images/illuEnvoyer.png" alt="illustration d'envoi">

        <div class="wrapTexteGauche">
            <h3>MERCI DE POSTER UNE OFFRE SUR FORMAT'IUT !</h3>
        </div>

        <div class="descEntr" id="desc1">
            <div class="gauche">
                <img src="../ressources/images/cercle-1.png" alt="numéro 1">
            </div>
            <div class="droite">
                <h4>Envoyez votre annonce et consultez son statut</h4>
            </div>
        </div>

        <div class="descEntr" id="desc2">
            <div class="gauche">
                <img src="../ressources/images/numero-2.png" alt="numéro 2">
            </div>
            <div class="droite">
                <h4>Une fois validée, votre annonce est postée !</h4>
            </div>
        </div>
    </div>

    <div class="antiPadding">
        <div class="wrapDroite">
            <form method="post" action="../web/controleurFrontal.php">

                <h1>ENVOYEZ UNE OFFRE SUR FORMAT'IUT !</h1>

                <label class="labelFormulaire" for="type_id">Type d'Offre </label>

                <div class="inputCentre">
                    <select name="typeOffre">
                        <option value="Stage/Alternance" name="typeOffre" id="type_id"> Stage et alternance</option>
                        <option value="Stage" name="typeOffre" id="type_id">Seuelement stage</option>
                        <option value="Alternance" name="typeOffre" id="type_id">Seulement alternance</option>
                    </select>
                </div>
                <!--
                <input class="inputFormulaire" type="radio" name="typeFormation" id="type_id" value="Stage"
                       required>Stage
                <input class="inputFormulaire" type="radio" name="typeFormation" id="type_id" value="Alternance">Alternance
                -->
                <label class="labelFormulaire" for="nomOffre_id">Profession visée par l'offre</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="nomOffre" id="nomOffre_id" required
                           placeholder="Développeur Web" maxlength="24">
                </div>
                <label class="labelFormulaire" for="dateDebut_id">Date de début de l'offre (non obligatoire)</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="date" name="dateDebut" id="dateDebut_id" >
                </div>

                <label class="labelFormulaire" for="dateFin_id">Date de fin de l'offre (non obligatoire)</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="date" name="dateFin" id="dateFin_id" >
                </div>

                <label class="labelFormulaire" for="anneeMin_id">Année d'étude minimale pour postuler</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="anneeMin" id="anneeMin_id" required>
                </div>

                <label class="labelFormulaire" for="anneeMax_id">Année d'étude maximale pour postuler</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="anneeMax" id="anneeMax_id" required>
                </div>

                <label class="labelFormulaire" for="sujet_id">Sujet bref de l'offre</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="sujet" id="sujet_id"
                           placeholder="Développement d'application Web en full stack" required maxlength="50">
                </div>


                <label class="labelFormulaire" for="detailProjet_id">Détails du projet</label>
                <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="detailProjet" id="detailProjet_id"
                              placeholder="L'étudiant devra..." required maxlength="255"></textarea>
                </div>

                <label class="labelFormulaire" for="objectifOffre_id">Objectifs pour l'étudiant</label>
                <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="objectifOffre" id="objectifOffre_id"
                              placeholder="Les objectifs de l'étudiant seront..." required maxlength="255"></textarea>
                </div>

                <label class="labelFormulaire" for="gratification_id">Rémunération de l'offre par mois</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="gratification" id="gratification_id"
                           placeholder="420" required maxlength="4">
                </div>

                <label class="labelFormulaire" for="uniteGratification_id">Devise utilisée pour la rémunération</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="text" name="uniteGratification" id="uniteGratification_id"
                           value="Euros" required>
                </div>

                <label class="labelFormulaire" for="uniteDureeGratification_id">Rémunération par heure</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="uniteDureeGratification" id="uniteDureeGratification_id"
                           placeholder="6" required maxlength="4">
                </div>

                <label class="labelFormulaire" for="dureeHeure_id">Durée en heure</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="dureeHeure" id="dureeHeure_id"
                           placeholder="935" required maxlength="4">
                </div>

                <label class="labelFormulaire" for="jourParSemaine_id">Nombre de jours par Semaine</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="joursParSemaine" id="jourParSemaine_id"
                           placeholder="5" required maxlength="1">
                </div>

                <label class="labelFormulaire" for="nbHeureHebdo_id">Nombre d'heures Hebdomadaires</label>
                <div class="inputCentre">
                    <input class="inputFormulaire" type="number" name="nbHeuresHebdo" id="nbHeureHebdo_id"
                           placeholder="32" required maxlength="2">
                </div>
                <div class="boutonsForm">
                    <input type="submit" value="Envoyer" formaction="?action=creerFormation&controleur=EntrMain">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

