<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueCompteEntreprise.css">
</head>
<body>
<div class="boiteMain">

    <div class="etudiantInfos">
        <div class="h3centre">
            <h3>Votre Identité Visuelle</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre logo ici :</p>
                <form enctype="multipart/form-data" action="?action=insertImage&controleur=EntrMain" method="post" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="250000"/>
                    <input type="file" name="fic" size=50/>
                    <input type="submit" value="Envoyer"/>
                </form>
            </div>
            <div class="imageEtu">
                <?php
                $image=(new \App\FormatIUT\Modele\Repository\ImageRepository())->getImage($entreprise->getImgId());
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $image['img_blob'] ).'"/>';
                ?>
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueEtu">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte entreprise</h3>
            <p>Visualisez les données de votre compte et modifiez-les sur la même page</p>
            <p>Voici toutes les informations sur votre compte entreprise :</p>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/parametresEntr.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="informationsActuellesEtu">
        <h3>Vos Informations Actuelles</h3>
        <div class="infosActu">
            <ul id="infosEntr">
                <?php
                $ville=(new \App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
                echo "<li>Siret : ".$entreprise->getSiret()."</li>
            <li>Nom : ".$entreprise->getNomEntreprise()."</li>
            <li>Statut juridique : ".$entreprise->getStatutJuridique()."</li>
            <li>Effectif : ".$entreprise->getEffectif()."</li>
            <li>CodeNAF : ".$entreprise->getCodeNaf()."</li>
            <li>Téléphone : ".$entreprise->getTel()."</li>
            <li>Adresse : ".$entreprise->getAdresse()."</li>
            <li>Ville : ".$ville->getNomVille()."</li>
            " ?>
            </ul>

            <img src="../ressources/images/infosEntre.png" alt="illu">

        </div>
    </div>


    <div class="detailsDeEntreprise">
        <h3>Vos Statistiques</h3>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/offres.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4>0 Offres en ligne</h4>
            </div>

        </div>


        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/etudiant.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4>0 étudiants postulateurs</h4>
            </div>

        </div>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/archiver.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4>0 offres ou contrats archivés</h4>
            </div>

        </div>

    </div>


</div>


</body>
</html>