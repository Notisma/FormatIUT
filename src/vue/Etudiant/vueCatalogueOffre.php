<head>
    <link rel="stylesheet" href="../ressources/css/styleVueCatalogue.css">
</head>
<body>
<div id="center">
    <div class="presentation">
        <div class="texteGauche">
            <h3>CATALOGUE DES OFFRES</h3>
            <p>Consultez et postulez sur toutes les offres disponibles en quelques clics</p>

            <form>
                <input type="hidden" name="controleur" value="EtuMain">
                <input type="hidden" name="action" value="afficherCatalogue">

                <input type="submit" name="type" value="Tous" class="offre"
                    <?php use App\FormatIUT\Modele\Repository\EntrepriseRepository;
                    use App\FormatIUT\Modele\Repository\EtudiantRepository;
                    use App\FormatIUT\Modele\Repository\FormationRepository;

                    if ($type == "Tous") echo 'id="typeActuel" disabled'; ?>
                >
                <input type="submit" name="type" value="Stage" class="stage"
                    <?php if ($type == "Stage") echo 'id="typeActuel" disabled'; ?>
                >
                <input type="submit" name="type" value="Alternance" class="alternance"
                    <?php if ($type == "Alternance") echo 'id="typeActuel" disabled'; ?>
                >
            </form>
        </div>

        <div class="imageDroite">
            <img src="../ressources/images/vueCatalogueEtu.png" alt="illustration">
        </div>

    </div>

    <div class="assistance">
        <h3>ASTUCES</h3>
        <p>Visualisez en un coup d'oeil les informations d'une offre, et cliquez sur cette dernière pour en savoir plus</p>
    </div>

    <div class="offresEtu">
        <div class="contenuOffresEtu">
            <?php
            if (!empty($offres)) {
                foreach ($offres as $offre) {
                    $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                    echo "<a href='?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=" . $offre->getIdOffre() . "' class='wrapOffres'>";
                    echo "<div class='partieGauche'>";
                        echo "<h3>" . $offre->getNomOffre() . " - " . $offre->getTypeOffre() . "</h3>";
                        echo "<p> Du " . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . " pour " . $offre->getSujet() . "</p>";
                        echo "<p>" . $offre->getDetailProjet() . "</p>";
                    echo "</div>";
                    echo "<div class='partieDroite'>";
                        echo "<div class='divInfo' id='wrapLogo'>";
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '" alt="logo"/>';
                        echo "</div>";
                        echo "<div class='divInfo' id='nbPostu'>";
                            echo "<img src='../ressources/images/recherche-demploi.png' alt='postulations'>";
                            echo "<p>";
                            if (!(new FormationRepository())->estFormation($offre->getIdOffre())) {
                                $nb = (new EtudiantRepository())->nbPostulations($offre->getIdOffre());
                                echo $nb . " postulation";
                                if ($nb > 1) echo "s";
                            } else {
                                echo "Assignée";
                            }
                            echo "</p>";
                        echo "</div>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "<p>Il n'y a aucune offre disponible actuellement. Veuillez revenir plus tard !</p>";
            } ?>
        </div>
    </div>
</div>
</body>
