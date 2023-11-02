<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueResetMdp.css">
</head>
<body>
<div class="mainReset">

    <div class="resetGauche">
        <img src="../ressources/images/mdpOublié.png" alt="illustration">
        <h2 class="titres" id="rouge">AIDE FORMAT'IUT - MOT DE PASSE OUBLIÉ</h2>
    </div>

    <div class="resetDroit">
        <div class="wrapReset">
            <h3 class="titres" id="noir">Réinitialisez votre mot de passe entreprise</h3>
            <p class="paragraphes">Vous avez reçu un mail renvoyant sur cette page pour réinitialiser votre mot de
                passe</p>

            <form method="post" action="../web/controleurFrontal.php">

                <label class="labelFormulaire" for="mdp">Nouveau mot de passe :
                    <input type="password" name="mdp" required>
                </label>

                <label class="labelFormulaire" for="mdp">Confirmer le nouveau mot de passe :
                    <input type="password" name="confirmerMdp" required>
                </label>

                <input type="submit" value="Enregistrer" formaction="?action=resetMdp&controleur=Main">

            </form>
        </div>
    </div>

</div>
</body>
</html>
