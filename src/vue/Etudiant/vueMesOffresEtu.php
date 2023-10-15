<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffresEtu.css">
</head>
<body>
<div id="center">

    <div class="presentation">
        <div class="texteGauche">
            <h3>Consultez toutes les offres dans lesquelles vous avez postulé ou avez été assigné.</h3>
            <p>Toutes les offres qui vous concernent, au même endroit</p>
        </div>

        <div class="imageDroite">
            <img src="../ressources/images/etudiantsMesOffres.png" alt="imageEtudiant">
        </div>

    </div>


    <div class="assistance">
        <h3>ASTUCES</h3>
        <p>Cliquez sur une des offres dans lesquelles vous avez postulé ou avez été assigné pour en voir les détails</p>
    </div>

    <div class="wrapOffresEtu">
        <div class="offresEtu">
            <div class="contenuOffresEtu">
                <h3>Offres de Stage</h3>
                <?php

                use App\FormatIUT\Modele\Repository\RegarderRepository;
                foreach ($listOffre as $offre) {
                    echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                    echo "<div class='partieGauche'>";
                    echo '<p> <h3>' . $offre->getNomOffre() . "      -     " . $offre->getTypeOffre() . '</h3> </p>';
                    echo '<p>' . $offre->getSujet() . ' le ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                    echo '<div class="wrapOffres">' . '<div class="divInfo">' . (new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) . '</div>' . '</div>';
                    echo '</div> </a>';

                }
                ?>
            </div>
        </div>

        <div class="offresEtu">
            <div class="contenuOffresEtu">
                <h3>Offres d'Alternance</h3>
                <?php

                foreach ($listOffre as $offre) {
                    echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                    echo "<div class='partieGauche'>";
                    echo '<p> <h3>' . $offre->getNomOffre() . "      -     " . $offre->getTypeOffre() . '</h3> </p>';
                    echo '<p>' . $offre->getSujet() . ' le ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                    echo '<div class="wrapOffres">' . '<div class="divInfo">' . (new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) . '</div>' . '</div>';
                    echo '</div> </a>';

                }
                ?>
            </div>
        </div>

    </div>


</div>
</body>