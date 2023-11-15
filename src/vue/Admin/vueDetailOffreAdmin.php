<div class="wrapCentreOffre">
    <?php
    //on récupère l'offre à partir de son id offre qui est en $ request
    $offre = (new App\FormatIUT\Modele\Repository\OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]);
    $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
    ?>

    <div class="wrapGauche">
        <a href="?action=afficherDetailEntreprise&controleur=adminMain&siret= <?php echo rawurlencode($entreprise->getSiret()) ?>" class="presentationPrincipale">
            <?php
            $src = '"data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '"';
            echo '<img src=' . $src . 'alt="image">';
            echo "<h2 class='titre' id='rouge'>" . $entreprise->getNomEntreprise() . "</h2>";
            echo "<h3 class='titre'>" . $offre->getSujet() . " - " . $offre->getTypeOffre() . "</h3>";
            ?>
        </a>


        <div class="wrapBoutons">
            <a href="?action=rejeterOffre&controleur=AdminMain&idOffre=<?php echo $offre->getIdOffre() ?>">REJETER</a>
            <a id="vert" href="?action=accepterOffre&controleur=AdminMain&idOffre=<?php echo $offre->getIdOffre() ?>">ACCEPTER</a>
        </div>

    </div>


    <div class="wrapDroite">
    <p></p>
    </div>




</div>
