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
        <p>Valider une offre dans laquelle vous êtes assigné annule toutes les autres.</p>
    </div>

    <div class="wrapOffresEtu">


        <!-- PARTIE DES OFFRES POSTULEES -->
        <div class="offresEtu">
            <div class="contenuOffresEtu">
                <h3>Offres dans lesquelles vous avez Postulé</h3>


                <?php


                use App\FormatIUT\Modele\Repository\PostulerRepository;

                $countAttente = 0;
                foreach ($listOffre as $offre) {
                    if ((new PostulerRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdFormation()) == "En attente") {
                        $countAttente++;
                        echo '<a href="?controleur=EtuMain&action=afficherVueDetailOffre&idFormation=' . $offre->getIdFormation() . '" class=wrapOffres>';
                        echo "<div class='partieGauche'>";
                        $nomHTML = htmlspecialchars($offre->getNomOffre());
                        echo '<h3>' . $nomHTML . " - " . $offre->getTypeOffre() . '</h3>';
                        echo '<p> Du ' . $offre->getDateDebut() . " au " . $offre->getDateFin() . '</p>';
                        $sujetHTML = htmlspecialchars($offre->getSujet());
                        echo "<p>Sujet de l'offre: " . $sujetHTML . '</p>';
                        echo '<div class="conteneurBouton">';
                        echo '<form method="get">
                             <input type="hidden" name="idFormation" value= ' . $offre->getIdFormation() . '>
                              <input type="hidden" name="service" value="Postuler">
                              <input type="hidden" name="action" value="annulerOffre">
                              <button class="boutonOffre" id="refuser">ANNULER</button>
                              </form>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="partieDroite">';
                        echo '<img src="../ressources/images/logo_CA.png" alt="imageEntreprise">';
                        echo '</div>';
                        echo '</a>';

                    }
                }
                if ($countAttente === 0) {
                    echo "
                    <div class='erreur'>
                       <img src='../ressources/images/erreur.png' alt='imageErreur'>
                       <h4>Vous n'avez aucune offre à afficher</h4>
                    </div>
                    ";
                }
                ?>
            </div>
        </div>

        <!-- code à recopier si il n'y a rien à afficher : -->


        <!-- PARTIE DES OFFRES ASSIGNEES -->
        <div class="offresEtu">
            <div class="contenuOffresEtu">
                <h3>Offres dans lesquelles vous êtes assigné</h3>
                <?php
                $countChoisirValider = 0;
                foreach ($listOffre as $offre) {
                    if ((new PostulerRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdFormation()) == "A Choisir" || (new PostulerRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdFormation()) == "Validée") {
                        $countChoisirValider++;
                        echo '<a href="?controleur=EtuMain&action=afficherVueDetailOffre&idFormation=' . $offre->getIdFormation() . '" class=wrapOffres>';
                        echo "<div class='partieGauche'>";
                        $nomHTML = htmlspecialchars($offre->getNomOffre());
                        echo '<h3>' . $nomHTML . " - " . $offre->getTypeOffre() . '</h3>';
                        echo '<p> Du ' . $offre->getDateDebut() . " au " . $offre->getDateFin() . '</p>';
                        $sujetHTML = htmlspecialchars($offre->getSujet());
                        echo "<p>Sujet de l'offre :" . $sujetHTML . '</p>';
                        echo '<div class="conteneurBouton">';
                        if ((new PostulerRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdFormation()) == "Validée") {
                            echo '<button class="boutonOffre" id="disabled">Acceptée</button>';
                        } else {
                            echo '<form method="get">
                             <input type="hidden" name="idFormation" value= ' . $offre->getIdFormation() . '>
                              <input type="hidden" name="service" value="Postuler">
                              <input type="hidden" name="action" value="validerOffre">
                              <button class="boutonOffre" id="accepter">ACCEPTER</button>
                              </form>';
                            echo '<form method="get">
                             <input type="hidden" name="idFormation" value= ' . $offre->getIdFormation() . '>
                              <input type="hidden" name="service" value="Postuler">
                              <input type="hidden" name="action" value="annulerOffre">
                              <button class="boutonOffre" id="refuser">ANNULER</button>
                              </form>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="partieDroite">';
                        echo '<img src="../ressources/images/logo_CA.png" alt="imageEntreprise">';
                        echo '</div>';
                        echo '</a>';
                    }
                }

                if ($countChoisirValider == 0) {
                    echo "
                    <div class='erreur'>
                       <img src='../ressources/images/erreur.png' alt='imageErreur'>
                       <h4>Vous n'avez aucune offre à afficher</h4>
                    </div>
                    ";
                }

                ?>

                <!-- code à recopier et compléter pour les offres assignées : -->
                <!-- une fois que l'offre a été acceptée par l'étudiant, le bouton refuser disparait, et le bouton accepter devient un bouton avec un id=disabled et de texte "acceptée" -->


            </div>
        </div>

    </div>


</div>