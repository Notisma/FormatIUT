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
                    echo '<input type="hidden" name="Etat" value="' . $_REQUEST["Etat"] . '">'
                    ?>
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="afficherMesOffres">
                </form>
                <form>
                    <?php
                    echo '<input type="submit" name="Etat" value="Tous" class="offre" ';
                    if ($Etat == "Tous") echo 'id="etatActuel" disabled';
                    echo '><input type="submit" name="Etat" value="Dispo" class="stage" ';
                    if ($Etat == "Dispo") echo 'id="etatActuel" disabled';
                    echo '><input type="submit" name="Etat" value="Assigné" class="alternance" ';
                    if ($Etat == "Assigné") echo 'id="etatActuel" disabled';
                    echo '>';
                    echo '<input type="hidden" name="type" value="' . $_REQUEST["type"] . '">'
                    ?>
                    <input type="hidden" name="controleur" value="EntrMain">
                    <input type="hidden" name="action" value="afficherMesOffres">

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
                    $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                    echo "<a href='?controleur=EntrMain&action=afficherVueDetailOffre&idFormation=" . $offre->getIdFormation() . "' class='wrapOffres'>";
                    echo "<div class='partieGauche'>";
                    $nomHTML = htmlspecialchars($offre->getNomOffre());
                    echo "<h3>" . $nomHTML . " - " . $offre->getTypeOffre() . "</h3>";
                    echo "<p> Du " . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . " pour " . htmlspecialchars($offre->getSujet()) . "</p>";
                    echo "<p>" . htmlspecialchars($offre->getDetailProjet()) . "</p>";
                    echo "</div>";
                    echo "<div class='partieDroite'>";
                    echo "<div class='divInfo' id='wrapLogo'>";
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '" alt="logo">';
                    echo "</div>";
                    echo "<div class='divInfo' id='nbPostu'>";
                    echo "<img src='../ressources/images/recherche-demploi.png' alt='postulations'>";
                    echo "<p>";
                    if (!(new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdFormation())) {
                        $nb = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbPostulations($offre->getIdFormation());
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
