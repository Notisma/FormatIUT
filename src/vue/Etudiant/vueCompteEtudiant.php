<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueCompteEtudiant.css">
</head>
<body>
<div class="boiteMain">

    <div class="etudiantInfos">
        <div class="h3centre">
            <h3>Votre Photo de Profil</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre photo ici :</p>
                <form enctype="multipart/form-data" action="?action=updateImage&controleur=EtuMain" method="post" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="250000"/>
                    <input type="file" name="fic" size=50/>
                    <input type="submit" value="Envoyer"/>
                </form>
            </div>
            <div class="imageEtu">
                <?php
                //$image=(new \App\FormatIUT\Modele\Repository\ImageRepository())->getImage($entreprise->getImgId());
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $etudiant->getImg() ).'"/>';
                ?>
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueDetailEntr">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte étudiant</h3>
            <p>Visualisez les données de votre compte et modifiez-les sur la même page</p>
            <br>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/compteEtu.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="infosOffreEntr">
        <h3>Vos Informations Actuelles</h3>
        <div class="petitConteneurInfosOffre">
            <ul id="infosEtu">
                <?php
                echo "
            <li>Prénom : ".$etudiant->getPrenomEtudiant()."</li>
            <li>Nom : ".$etudiant->getNomEtudiant()."</li>
            <li>Login : ".$etudiant->getLogin()."</li>
            <li>Numéro Etudiant : ".$etudiant->getNumEtudiant()."</li>
            <li>Mail universitaire : ".$etudiant->getMailUniersitaire()."</li>
            <li>Téléphone : ".$etudiant->getTelephone()."</li>
            <li>Groupe : ".$etudiant->getGroupe()."</li>
            <li>Parcours : ".$etudiant->getParcours()."</li>
            " ?>
            </ul>

            <img src="../ressources/images/donneesEtu.png" alt="illu">

        </div>
    </div>


    <div class="listeEtudiantsPostulants">
        <!-- TODO/ STats -->
        <h3>Vos Statistiques</h3>

        <div class="etudiantPostulant">
            <div class="illuPostulant">
                <img src="../ressources/images/postulation.png" alt="illustration postuler">
            </div>

            <div class="nomEtuPostulant">
                <h4>0 Postulations en attente d'assignation</h4>
            </div>

        </div>


        <div class="etudiantPostulant">
            <div class="illuPostulant">
                <img src="../ressources/images/choix.png" alt="illustration postuler">
            </div>

            <div class="nomEtuPostulant">
                <h4>0 assignations en attente de choix</h4>
            </div>

        </div>

        <div class="etudiantPostulant">
            <div class="illuPostulant">
                <img src="../ressources/images/archiver.png" alt="illustration postuler">
            </div>

            <div class="nomEtuPostulant">
                <h4>0 documents ou contrats archivés</h4>
            </div>

        </div>

    </div>


</div>


</body>
</html>