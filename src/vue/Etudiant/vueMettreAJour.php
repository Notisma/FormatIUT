<!DOCTYPE html>
<html lang="en">

<?php use App\FormatIUT\Modele\DataObject\Etudiant; ?>
<head>
    <link rel="stylesheet" href="../ressources/css/styleFormulaireCreationOffre.css">
</head>
<body>
<div id="center" class="antiPadding">
    <div class="wrapDroite">
        <form method="POST">
            <fieldset>
                <legend>Mon formulaire :</legend>
                <input type='hidden' name='numEtu' value='<?= htmlspecialchars($etudiant->getNumEtudiant()) ?>'>

                <label for="login_id">Login</label> :
                <div class="inputCentre">
                    <input type="text" value=<?= htmlspecialchars($etudiant->getLogin()); ?> readonly="readonly"
                           name="login" id="login_id" required/>
                </div>

                <label for="mailPerso_id">Mail Personnel</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($etudiant->getMailPerso()); ?> name="mailPerso"
                           id="mailPerso_id" required maxlength="50"/>
                </div class="inputCentre">

                <label for="numTel_id">Numéro de téléphone</label> :
                <div class="inputCentre">
                    <input type="text" placeholder=<?= htmlspecialchars($etudiant->getTelephone()); ?> name="numTel"
                           id="numTel_id" required maxlength="11"/>
                </div class="inputCentre">

                <div class="boutonsForm">
                    <input type="submit" value="Envoyer" formaction="?action=mettreAJour&controleur=EtuMain"/>
                </div>
            </fieldset>
        </form>
    </div>
</div>
</body>

</html>