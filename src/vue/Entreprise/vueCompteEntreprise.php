<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueCompteEntreprise.css">
</head>
<body>
<div class="boiteMain">

    <div class="entrepriseInfos">
        <div class="h3centre">
            <h3>Votre Identité Visuelle</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre logo ici :</p>
                <form enctype="multipart/form-data" action="#" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="250000" />
                    <input type="file" name="fic" size=50 />
                    <input type="submit" value="Envoyer" />
                </form>
            </div>
            <div class="imageEntre">
                <img src="../ressources/images/logo_CA.png" alt="logoEntreprise">
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueEntr">
        <div class="texteBienvenue">
            <h3>Bonjour, voici votre compte entreprise</h3>
            <p>Voici les informations sur votre compte entreprise :</p>
        </div>
        <div class="imageBienvenue">
        </div>
    </div>


    <div class="informationsActuellesEntr">
        <ul id="infosEntr">
            <li>Siret : 11111111111111</li>
            <li>nom entreprise : Entreprise A</li>
            <li>Statut juridique : SA</li>
            <li>Effectif : 10</li>
            <li>CodeNAF : 6205A</li>
            <li>Tel : 01 32 79 12 43</li>
            <li>Adresse : 32 rue des Halles</li>
            <li>Ville : Montpellier</li>
        </ul>
    </div>


    <div class="formUpdateEntr">
        <p>tt</p>
    </div>


</div>


</body>
</html>