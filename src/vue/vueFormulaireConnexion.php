<?php

use App\FormatIUT\Lib\ConnexionUtilisateur;

if (ConnexionUtilisateur::estConnecte()) {
    ConnexionUtilisateur::deconnecter();
    header("Location: ?action=afficherPageConnexion&controleur=Main");
    \App\FormatIUT\Lib\MessageFlash::ajouter("info", "Vous avez été déconnecté avec succès.");
}
?>


<div id="center">

    <div id="desc">
        <div id="zoneLogo">
            <img src="../ressources/images/LogoIutMontpellier-removed.png" alt="logo" id="logo">
        </div>

        <h1>BIENVENUE SUR FORMAT'IUT</h1>
        <div id="texteCentre">
            <p id="premiereLigne"> LA PLATEFORME DE GESTION ET DE CONSULATION DES STAGES ET DES ALTERNANCES DE L'IUT
                MONTPELLIER-SETE</p>
            <!-- <p>Vous êtes une entreprise et voulez faire une proposition de stage ou d'alternance ?</p> -->
        </div>
    </div>


    <div id="formulaire">
        <div id="form">
            <h2>CONNEXION</h2>
            <div id="erreur">
                <?php
                if (isset($_REQUEST['erreur'])) {
                    $err = $_REQUEST['erreur'];
                    if ($err > 0)
                        echo "<div id='imageErreur'>";
                    echo "<img src='../ressources/images/attention.png' alt='erreur' id='attention'>";
                    echo "</div>";
                    echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
                }
                ?>
            </div>
            <form action="../web/controleurFrontal.php" method="post">
                <div id="wrapInput">
                    <div id="Userlogin">
                        <img src="../ressources/images/utilisateur.png" alt="user" id="user">
                        <input type="text" name="login" id="login" required placeholder="Identifiant ou adresse Mail">
                    </div>
                    <div id="Usermdp">
                        <img src="../ressources/images/cadenas.png" alt="cadenas" id="cadenas">
                        <input type="password" name="mdp" id="mdp" required>
                    </div>
                </div>
                <input id="bouton" type="submit" value="CONNEXION" formaction="?action=seConnecter&controleur=Main">
                <a class="oublié" onclick="afficherPopupMdp()" id="ouvrir">Mot de Passe oublié ?</a>
            </form>
        </div>
    </div>

</div>


<div class="popupOublié" id="popupMdp">
    <div class="mainForget">
        <div class="closeForget">
            <a onclick="fermerPopupMdp()">
                <img src="../ressources/images/fermer.png" alt="fermer">
            </a>
        </div>
        <div class="conteneurForget">
            <h2>MOT DE PASSE OUBLIÉ ?</h2>
            <form action="?action=mdpOublie&controleur=Main" method="post">
                <label for="mail">Saisissez votre adresse mail :</label>
                <input type="email" name="mail" id="mail" placeholder="exemple@exemple.ex" required>
                <input type="submit" value="ENVOYER">
                <p>Un mail vous sera envoyé à cette adresse pour réinitialiser votre mot de passe.</p>
            </form>
        </div>
    </div>
    <div class="imgForget">
        <img src="../ressources/images/oublié.png" alt="oublié" id="oublié">
    </div>
</div>
