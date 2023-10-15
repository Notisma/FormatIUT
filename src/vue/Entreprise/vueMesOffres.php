<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffres.css">
</head>
<body>
<div id="center">

    <div class="presentation">

        <div class="texteGauche">

            <h3>CONSULTEZ TOUTES VOS OFFRES</h3>
            <p>Consultez et gérez toutes vos offres en quelques clics.</p>

            <div class="formulairesDeTri">
                <form>
                    <?php
                    echo '<input type="submit" name="type" value="Tous" class="offre" ';
                    if ($type == "Tous") echo 'id="typeActuel" disabled';
                    echo '><input type="submit" name="type" value="Stage" class="stage" ';
                    if ($type == "Stage") echo 'id="typeActuel" disabled';
                    echo '><input type="submit" name="type" value="Alternance" class="alternance" ';
                    if ($type == "Alternance") echo 'id="typeActuel" disabled';
                    echo '>';
                    echo '<input type="hidden" name="Etat" value="' . $_GET["Etat"] . '">'
                    ?>
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="mesOffres">
                </form>
                <form>
                    <?php
                    echo '<input type="submit" name="Etat" value="Tous" class="offre" ';
                    if ($Etat == "Tous") echo 'id="typeActuel" disabled';
                    echo '><input type="submit" name="Etat" value="Dispo" class="stage" ';
                    if ($Etat == "Dispo") echo 'id="typeActuel" disabled';
                    echo '><input type="submit" name="Etat" value="Assigné" class="alternance" ';
                    if ($Etat == "Assigné") echo 'id="typeActuel" disabled';
                    echo '>';
                    echo '<input type="hidden" name="type" value="' . $_GET["type"] . '">'
                    ?>
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="mesOffres">

                </form>
            </div>
        </div>

        <div class="imageDroite">
            <img src="../ressources/images/recherchezOffres.png" alt="illustration consult">
        </div>

    </div>

    <div class="assistance">
        <h3>ASSISTANCE - VOS OFFRES</h3>
        <p>Cliquez sur une offre pour obtenir plus de détails, supprimer ou mettre à jour votre offre, ou encore
            assigner un étudiant à cette offre.</p>
    </div>

    <div class="offresEtu">
        <div class="contenuOffresEtu">
            <?php
            if (!empty($listeOffres)) {
                foreach ($listeOffres as $offre) {
                    $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getSiret());
                    echo "<a href='?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=" . $offre->getIdOffre() . "' class='wrapOffres'>";
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
                    if (!(new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdOffre())) {
                        $nb = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbPostulation($offre->getIdOffre());
                        echo $nb . " postulation";
                        if ($nb != 1) echo "s";
                    } else {
                        echo "Assignée";
                    }
                    echo "</p>";
                    echo "</div>";
                    echo "<div class='divInfo' id='statutOffre'>";
                    echo "<img src='../ressources/images/verifier.png' alt='statut'>";
                    echo "<p>Offre validée</p>";
                    echo "</div>";
                    echo "</div>";
                    echo "</a>";
                }
            } else {
                echo "
                <div class='erreur'>
                    <img src='../ressources/images/erreur.png' alt='erreur'>
                    <h4>Vous n'avez aucune offre</h4>
                </div>";
            } ?>
        </div>
    </div>
</div>
</body>
