<!DOCTYPE html>
<html lang="en">

<?php use App\FormatIUT\Modele\DataObject\Entreprise; ?>
<head>
    <link rel="stylesheet" href="../ressources/css/styleFormulaireCreationOffre.css">
</head>
<body>
<div id="center" class="antiPadding">
    <div class="wrapDroite">
        <form method="POST">
            <fieldset>
                <legend>Les informations de votre entreprise :</legend>

                <label for="siret_id">Siret</label> :
                <div class="inputCentre">
                    <input type="text" value=<?= htmlspecialchars($entreprise->getSiret()); ?> readonly="readonly"
                           name="siret" id="siret_id" required/>
                </div>

                <label for="nom_id">Nom</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($entreprise->getNomEntreprise()); ?> name="nom"
                           id="nom_id" required maxlength="50"/>
                </div class="inputCentre">

                <label for="statutJ_id">Statut juridique</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($entreprise->getStatutJuridique()); ?> name="statutJ"
                           id="statutJ_id" required maxlength="50"/>
                </div class="inputCentre">

                <label for="effectif_id">Effectif</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($entreprise->getEffectif()); ?> name="effectif"
                           id="effectif_id" required maxlength="11"/>
                </div class="inputCentre">

                <label for="codeNAF_id">Code NAF</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($entreprise->getCodeNAF()); ?> name="codeNAF"
                           id="codeNAF_id" required maxlength="50"/>
                </div class="inputCentre">

                <label for="tel_id">Numéro de téléphone</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($entreprise->getTel()); ?> name="tel"
                           id="tel_id" required maxlength="11"/>
                </div class="inputCentre">

                <label for="adresse_id">Adresse</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($entreprise->getAdresse()); ?> name="adresse"
                           id="adresse_id" required maxlength="255"/>
                </div class="inputCentre">

                <div class="boutonsForm">
                    <input type="submit" value="Envoyer" formaction="?action=mettreAJour&controleur=EntrMain"/>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</body>

</html>