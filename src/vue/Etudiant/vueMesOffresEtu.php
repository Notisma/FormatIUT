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
                //TODO: afficher les offres de stage
                /*
                use App\FormatIUT\Modele\Repository\RegarderRepository;

                foreach ($listOffre as $offre) {
                    echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                    echo "<div class='partieGauche'>";
                    echo '<p> <h3>' . $offre->getNomOffre() . "      -     " . $offre->getTypeOffre() . '</h3> </p>';
                    echo '<p>' . $offre->getSujet() . ' le ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                    echo '<div class="wrapOffres">' . '<div class="divInfo">' . (new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) . '</div>' . '</div>';
                    echo '</div> </a>';

                }
                */?>

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
                /*
                //TODO: afficher les offres d'alternance

                foreach ($listOffre as $offre) {
                    echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=' . $offre->getIdOffre() . '  class=wrapOffres>';
                    echo "<div class='partieGauche'>";
                    echo '<p> <h3>' . $offre->getNomOffre() . "      -     " . $offre->getTypeOffre() . '</h3> </p>';
                    echo '<p>' . $offre->getSujet() . ' le ' . date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y') . '</p>';
                    echo '<div class="wrapOffres">' . '<div class="divInfo">' . (new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) . '</div>' . '</div>';
                    echo '</div> </a>';

                } */
                ?>

                <!-- code à recopier et compléter pour les offres assignées : -->
                <a href="?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=7" class="wrapOffres">
                    <div class="partieGauche">
                        <p>
                        <h3>Développeur WEB FrontEnd - Stage</h3> </p>
                        <p>Offre d'alternance dans le domaine de l'informatique</p>
                        <p>Du 03/10/2024 au 21/12/2024</p>
                        <div class="conteneurBouton">
                            <!-- une fois que l'offre a été acceptée par l'étudiant, le bouton refuser disparait, et le bouton accepter devient un bouton avec un id=disabled et de texte "acceptée" -->
                            <button class="boutonOffre" id="accepter">ACCEPTER</button>
                            <button class="boutonOffre" id="refuser">REFUSER</button>
                        </div>
                    </div>
                    <div class="partieDroite">
                        <img src="../ressources/images/logo_CA.png" alt="imageEntreprise">
                    </div>
                </a>



                <!-- code à recopier pour les offres postulées : -->
                <a href="?controleur=EtuMain&action=afficherVueDetailOffre&idOffre=7" class="wrapOffres">
                    <div class="partieGauche">
                        <p>
                        <h3>Développeur WEB FrontEnd - Stage</h3> </p>
                        <p>Offre d'alternance dans le domaine de l'informatique</p>
                        <p>Du 03/10/2024 au 21/12/2024</p>
                        <div class="conteneurBouton">
                            <button class="boutonOffre" id="refuser">ANNULER</button>
                        </div>
                    </div>
                    <div class="partieDroite">
                        <img src="../ressources/images/logo_CA.png" alt="imageEntreprise">
                    </div>
                </a>




            </div>
        </div>

    </div>


</div>
</body>