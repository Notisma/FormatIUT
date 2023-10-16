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


        <!-- PARTIE DES OFFRES POSTULEES -->
        <div class="offresEtu">
            <div class="contenuOffresEtu">
                <h3>Offres dans lesquelles vous avez Postulé</h3>


                <?php



                use App\FormatIUT\Modele\Repository\RegarderRepository;
                $countAttente = 0;
                foreach ($listOffre as $offre) {
                    if((new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "En Attente" ){
                        $countAttente++;
                        echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                        echo "<div class='partieGauche'>";
                        echo '<p>';
                        echo '<h3>' . $offre->getNomOffre() . " - " . $offre->getTypeOffre() . '</h3> </p>';
                        echo '<p> Du ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                        echo "<p>Sujet de l'offre :" . $offre->getSujet() . '</p>';
                        echo '<div class="conteneurBouton">';
                        echo'<form method="get">
                             <input type="hidden" name="idOffre" value= '.$offre->getIdOffre().'>
                              <input type="hidden" name="controleur" value="EtuMain">
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
                    if((new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "A Choisir" || (new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "Validée") {
                        $countChoisirValider++;
                        echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                        echo "<div class='partieGauche'>";
                        echo '<p>';
                        echo '<h3>' . $offre->getNomOffre() . " - " . $offre->getTypeOffre() . '</h3> </p>';
                        echo '<p> Du ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                        echo "<p>Sujet de l'offre :" . $offre->getSujet() . '</p>';
                        echo '<div class="conteneurBouton">';
                        if((new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "Validée"){
                            echo '<button class="boutonOffre" id="disabled">Acceptée</button>';
                        }
                        else{
                            echo'<form method="get">
                             <input type="hidden" name="idOffre" value= '.$offre->getIdOffre().'>
                              <input type="hidden" name="controleur" value="EtuMain">
                              <input type="hidden" name="action" value="validerOffre">
                              <button class="boutonOffre" id="accepter">ACCEPTER</button>
                              </form>';
                            echo'<form method="get">
                             <input type="hidden" name="idOffre" value= '.$offre->getIdOffre().'>
                              <input type="hidden" name="controleur" value="EtuMain">
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

                if ($countChoisirValider==0) {
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
</body>