<head>
    <link rel="stylesheet" href="../ressources/css/styleVueCompteEtudiant.css">
</head>
<body>
<div class="boiteMain">
    <!-- TODO fixé cette vue -->
    <div class="etudiantInfos">
        <div class="h3centre">
            <h3>Votre Photo de Profil</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre photo ici :</p>
                <form enctype="multipart/form-data" action="?action=updateImage&controleur=EtuMain" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <input type="file" name="fic" size=500/>
                    <input type="submit" value="Envoyer"/>
                </form>
            </div>
            <div class="imageEtu">
                <?php
                echo '<img src="data:image/jpeg;base64,' . base64_encode($etudiant->getImg()) . '"/>';
                ?>
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueEtu">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte étudiant</h3>
            <p>Visualisez les données de votre compte en un coup d'oeil</p>
            <br>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/compteEtu.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="informationsActuellesEtu">
        <h3>Vos Informations Actuelles</h3>
        <div class="infosActu">
            <ul id="infosEtu">
                <?php
                echo "
            <li>Prénom : " . $etudiant->getPrenomEtudiant() . "</li>
            <li>Nom : " . $etudiant->getNomEtudiant() . "</li>
            <li>Login : " . $etudiant->getLogin() . "</li>
            <li>Numéro Etudiant : " . $etudiant->getNumEtudiant() . "</li>
            <li>Mail universitaire : " . $etudiant->getMailUniersitaire() . "</li>
            <li>Téléphone : " . $etudiant->getTelephone() . "</li>
            <li>Groupe : " . $etudiant->getGroupe() . "</li>
            <li>Parcours : " . $etudiant->getParcours() . "</li>
            " ?>
            </ul>

            <img src="../ressources/images/donneesEtu.png" alt="illu">

        </div>
    </div>


    <div class="detailsDeEntreprise">
        <!-- TODO/ STats 2/3-->
        <h3>Vos Statistiques</h3>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/postulation.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4><?php
                    $nb = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbEnEtat($etudiant->getNumEtudiant(), "En Attente"));
                    echo $nb . " Postulation";
                    if ($nb != 1) echo "s";
                    ?>

                    en attente d'assignation</h4>
            </div>

        </div>


        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/choix.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4><?php
                    $nb = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbEnEtat($etudiant->getNumEtudiant(), "A Choisir"));
                    echo $nb . " assignation";
                    if ($nb != 1) echo "s";
                    ?> en attente de choix</h4>
            </div>

        </div>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/archiver.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4>0 documents ou contrats archivés</h4>
            </div>

        </div>

    </div>


</div>

</body>