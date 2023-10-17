<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVuePresentationEntreprise.css">
</head>

<body>


<div class="wrapComplet">

    <div class="wrapFormulaireCreationPE">
        <div class="formulaireGauchePE">
            <form action="controleurFrontal.php?controleur=EntrMain&action=creerCompteEntreprise" method="post">
                <h1>Créez votre compte Entreprise</h1>
                <input type="text" name="siteWeb" placeholder="SIRET de l'entreprise" required>
                <input type="text" name="nomEntreprise" placeholder="Nom de l'entreprise" required>
                <input type="text" name="adresse" placeholder="Adresse de l'entreprise" required>
                <input type="text" name="codePostal" placeholder="Code Postal" required>
                <input type="text" name="ville" placeholder="Ville" required>
                <input type="text" name="tel" placeholder="Téléphone" required>
                <input type="text" name="statutJuridique" placeholder="Statut Juridique" required>
                <input type="text" name="effectif" placeholder="Effectif" required>
                <input type="text" name="codeNaf" placeholder="Code NAF" required>
                <input type="text" name="mdp" placeholder="Mot de passe" required>
                <input type="text" name="mdpConf" placeholder="Confirmer le mot de passe" required>
                <input type="submit" class="valider" value="Créer le compte">
            </form>
        </div>

        <div class="partieDroitePE">

        </div>
    </div>


</div>
</body>


</html>
