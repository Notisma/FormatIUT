<div class="wrapCentreOffre">
    <?php
    //on récupère l'offre à partir de son id offre qui est en $ request
    $offre = (new App\FormatIUT\Modele\Repository\OffreRepository())->getObjectParClePrimaire($_REQUEST["idOffre"]);
    $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
    ?>

    <div class="wrapGauche">
        <a href="?action=afficherDetailEntreprise&controleur=adminMain&siret= <?php echo rawurlencode($entreprise->getSiret()) ?>"
           class="presentationPrincipale">
            <?php
            $src = '"data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '"';
            echo '<img src=' . $src . 'alt="image">';
            echo "<h2 class='titre' id='rouge'>" . $entreprise->getNomEntreprise() . "</h2>";
            echo "<h3 class='titre'>" . $offre->getSujet() . " - " . $offre->getTypeOffre() . "</h3>";
            ?>
        </a>


        <div class="wrapDetails">
            <h4 class="titre"> <?php echo $offre->getNomOffre() . " - " . $offre->getSujet() ?></h4>
            <p>- Description de l'offre : <?php echo $offre->getDetailProjet() ?></p>
            <p>- Offre
                de <?php echo "" . $offre->getTypeOffre() . " du : " . date_format($offre->getDateDebut(), "d/m/Y") . " au : " . date_format($offre->getDateFin(), "d/m/Y") ?></p>
            <p>- Rémunation : <?php echo $offre->getGratification() ?> €</p>
            <p>- Offre publiée le 17/11/2023</p>
        </div>


        <div class="wrapBoutons">
            <?php
            if (!$offre->isEstValide()) {
                echo "
                <a href='?action=rejeterOffre&controleur=AdminMain&idOffre= ".$offre->getIdOffre()."'>REJETER</a>
            <a id='vert' href='?action=accepterOffre&controleur=AdminMain&idOffre".$offre->getIdOffre()."'>ACCEPTER</a>
                ";
            }

            ?>
        </div>

    </div>


    <div class="wrapDroite">
        <p></p>
    </div>


</div>
