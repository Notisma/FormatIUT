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
                <form enctype="multipart/form-data" action="?action=insertImage&controleur=EntrMain" method="post" >
                    <input type="hidden" name="MAX_FILE_SIZE" value="250000"/>
                    <input type="file" name="fic" size=50/>
                    <input type="submit" value="Envoyer"/>
                </form>
            </div>
            <div class="imageEntre">
                <?php
                //echo ((new \App\FormatIUT\Modele\Repository\ImageRepository())->getImage(1));
                //echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['IMAGE'] ).'"/>';
                //on affiche le logo de l'entreprise depuis ImageRepository
                $image=(new \App\FormatIUT\Modele\Repository\ImageRepository())->getImage($entreprise->getImgId());
                echo '<img src="data:image/jpeg;base64,'.base64_encode( $image['img_blob'] ).'"/>';
                ?>
                <!--
                <img src="../ressources/images/logo_CA.png" alt="logoEntreprise">
                -->
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
        <h3>Détails</h3>

    </div>


</div>


</body>
</html>