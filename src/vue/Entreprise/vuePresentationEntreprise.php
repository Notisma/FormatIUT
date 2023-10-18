<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVuePresentationEntreprise.css">
</head>

<body>


<div class="wrapComplet">

    <div class="partie1">
        <div>
            <h1>REJOIGNEZ FORMAT'IUT EN TANT QU'ENTREPRISE !</h1>
            <h3>Et profitez d'une application Web innovante pour permettre à des étudiants qualifiés de faire un bond
                vers l'avenir !</h3>
        </div>
        <img src="../ressources/images/bienvenueChezNous.png" alt="image entreprise">
    </div>


    <div class="partie2">
        <div class="sousCategorie" id="SC1">
            <div>
                <img src="../ressources/images/intuitif.png" alt="icone1">
            </div>
            <h4>Une Application Web Intuitive</h4>
            <p>Réalisez toutes vos démarches en toute simplicité</p>
        </div>

        <div class="sousCategorie" id="SC2">
            <div>
                <img src="../ressources/images/couteau-suisse.png" alt="icone1">
            </div>
            <h4>Un Service Polyvalent</h4>
            <p>Gérez vos démarches, et vos offres de stage et d'alternance au même endroit</p>
        </div>

        <div class="sousCategorie" id="SC3">
            <div>
                <img src="../ressources/images/accessible.png" alt="icone1">
            </div>
            <h4>Accessible sur tous vos appareils</h4>
            <p>Une Application Web conçue pour tous vos appareils</p>
        </div>

        <div class="sousCategorie" id="SC4">
            <div>
                <img src="../ressources/images/notification.png" alt="icone1">
            </div>
            <h4>Restez toujours au courant</h4>
            <p>Choisissez de recevoir des mails pour vous tenir informés</p>
        </div>
    </div>


    <div class="partie3">

    </div>


    <div class="wrapFormulaireCreationPE">
        <div class="formulaireGauchePE">
            <form action="controleurFrontal.php?controleur=Main&action=creerCompteEntreprise" method="post">
                <h1>CREEZ VOTRE COMPTE ENTREPRISE</h1>
                <input type="text" name="siret" placeholder="SIRET de l'entreprise" required>
                <input type="text" name="nomEntreprise" placeholder="Nom de l'entreprise" required>
                <input type="text" name="Adresse_Entreprise" placeholder="Adresse de l'entreprise" required>
                <input type="text" name="email" placeholder="Email de l'entreprise" required>
                <input type="text" name="codePostal" placeholder="Code Postal" required>
                <input type="text" name="idVille" placeholder="Ville" required>
                <input type="number" name="tel" placeholder="Téléphone" required>
                <input type="text" name="statutJuridique" placeholder="Statut Juridique" required>
                <input type="number" name="effectif" placeholder="Effectif" required>
                <input type="text" name="codeNAF" placeholder="Code NAF" required>
                <input type="password" name="mdp" placeholder="Mot de passe" required>
                <input type="password" name="mdpConf" placeholder="Confirmer le mot de passe" required>
                <input type="submit" class="valider" value="Créer le compte">
            </form>
        </div>

        <div class="partieDroitePE">
            <img src="../ressources/images/formulairePE.png" alt="image formulaire">
            <h2>MERCI DE REJOINDRE FORMAT'IUT !</h2>
        </div>
    </div>


</div>
</body>


</html>
