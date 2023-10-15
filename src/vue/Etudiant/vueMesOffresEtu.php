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

                foreach ($listOffre as $offre) {
                    if(((new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "En attente" ) || ((new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "Refusé")){
                        echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                        echo "<div class='partieGauche'>";
                        echo '<p>';
                        echo '<h3>' . $offre->getNomOffre() . " - " . $offre->getTypeOffre() . '</h3> </p>';
                        echo '<p> Du ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                        echo '<div class="conteneurBouton">';
                        echo '<button class="boutonOffre" id="refuser">ANNULER</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="partieDroite">';
                        echo '<img src="../ressources/images/logo_CA.png" alt="imageEntreprise">';
                        echo '</div>';
                        echo '</a>';
                    }
                }
                ?>

                <!-- code à recopier si il n'y a rien à afficher : -->
                <div class="erreur">
                    <img src="../ressources/images/erreur.png" alt="imageErreur">
                    <h4>Aucune offre à afficher.</h4>
                </div>

            </div>
        </div>

        <!-- PARTIE DES OFFRES ASSIGNEES -->
        <div class="offresEtu">
            <div class="contenuOffresEtu">
                <h3>Offres en attente de Choix</h3>
                <?php


                foreach ($listOffre as $offre) {
                    if((new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) == "Assigné") {
                        echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                        echo "<div class='partieGauche'>";
                        echo '<p>';
                        echo '<h3>' . $offre->getNomOffre() . " - " . $offre->getTypeOffre() . '</h3> </p>';
                        echo '<p> Du ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                        echo '<div class="conteneurBouton">';
                        echo '<button class="boutonOffre" id="accepter">ACCEPTER</button>';
                        echo '<button class="boutonOffre" id="refuser">ANNULER</button>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="partieDroite">';
                        echo '<img src="../ressources/images/logo_CA.png" alt="imageEntreprise">';
                        echo '</div>';
                        echo '</a>';
                    }
                }
                ?>

                <!-- code à recopier et compléter pour les offres assignées : -->
                <!-- une fois que l'offre a été acceptée par l'étudiant, le bouton refuser disparait, et le bouton accepter devient un bouton avec un id=disabled et de texte "acceptée" -->




            </div>
        </div>

    </div>


</div>
</body>