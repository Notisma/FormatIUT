<div id="center">
    <div class="presentation">
        <div class="texteGauche">
            <h3>CATALOGUE DES OFFRES</h3>
            <p>Consultez et postulez sur toutes les offres disponibles en quelques clics</p>

            <form>
                <input type="hidden" name="controleur" value="EtuMain">
                <input type="hidden" name="action" value="afficherCatalogue">

                <input type="submit" name="type" value="Tous" class="offre"
                    <?php use App\FormatIUT\Controleur\ControleurEtuMain;
                    use App\FormatIUT\Modele\Repository\EntrepriseRepository;
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
        <p>Visualisez en un coup d'oeil les informations d'une offre, et cliquez sur cette dernière pour en savoir
            plus</p>
    </div>

    <div class="offresEtu">
        <div class="contenuOffresEtu">
            <?php
            $compteurOffres = 0;
            if (!empty($offres)) {
                foreach ($offres as $offre) {
                    $anneeEtu = (new EtudiantRepository())->getAnneeEtudiant((new EtudiantRepository())->getObjectParClePrimaire(ControleurEtuMain::getCleEtudiant()));
                    if (( $anneeEtu >= $offre->getAnneeMin()) && $anneeEtu <= $offre->getAnneeMax() && $offre->estValide()) {
                        $compteurOffres++;
                        $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                        echo "<a href='?controleur=EtuMain&action=afficherVueDetailOffre&idFormation=" . $offre->getidFormation() . "' class='wrapOffres'>
                            <div class='partieGauche'>
                            <h3>" . htmlspecialchars($offre->getNomOffre()) . " - " . $offre->getTypeOffre() . "</h3>
                            <p> Du " .  $offre->getDateDebut()  . " au " .  $offre->getDateFin()  . " pour " . htmlspecialchars($offre->getSujet()) . "</p>
                            <p>" . htmlspecialchars($offre->getDetailProjet()) . "</p>
                            </div>
                            <div class='partieDroite'>
                            <div class='divInfo'>
                            <img src=\"" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($entreprise->getImg()) . "\" alt='logo'>
                            </div>
                            <div class='divInfo'>
                            <img src='../ressources/images/recherche-demploi.png' alt='postulations'>
                            <p>";
                        if (!(new FormationRepository())->estFormation($offre->getidFormation())) {
                            $nb = (new EtudiantRepository())->nbPostulations($offre->getidFormation());
                            echo $nb . " postulation";
                            if ($nb > 1) echo "s";
                        } else {
                            echo "Assignée";
                        }
                        echo "</p>
                        </div>
                        </div>
                        </a>";
                    }
                }
                if($compteurOffres == 0){
                    echo "<h2>Il n'y a aucune offre disponible actuellement. Veuillez revenir plus tard !</h2>";
                }
            } else {
                echo "<h2>Il n'y a aucune offre disponible actuellement. Veuillez revenir plus tard !</h2>";
            } ?>
        </div>
    </div>
</div>
