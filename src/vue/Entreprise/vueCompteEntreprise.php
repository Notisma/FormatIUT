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
                    <input type="hidden" name="MAX_FILE_SIZE" value="250000"/>
                    <input type="file" name="fic" size=50/>
                    <input type="submit" value="Envoyer"/>
                </form>
            </div>
            <div class="imageEntre">
                <img src="../ressources/images/logo_CA.png" alt="logoEntreprise">
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueEntr">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte entreprise</h3>
            <p>Visualisez les données de votre compte et modifiez-les sur la même page</p>
            <p>Voici toutes les informations sur votre compte entreprise :</p>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/parametresEntr.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="informationsActuellesEntr">
        <h3>Vos Informations Actuelles</h3>
        <div class="infosActu">
            <ul id="infosEntr">
                <?php
                echo "
            <li>Siret : 10474930</li>
            <li>Nom : Entreprise A</li>
            <li>Statut juridique : SA</li>
            <li>Effectif : 10</li>
            <li>CodeNAF : 6205A</li>
            <li>Téléphone : 01 32 79 12 43</li>
            <li>Adresse : 32 rue des Halles</li>
            <li>Ville : Montpellier</li>
            " ?>
            </ul>

            <img src="../ressources/images/infosEntre.png" alt="illu">

        </div>
    </div>


    <div class="formUpdateEntr">
        <p>tt</p>
    </div>


</div>


</body>
</html>