<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffres.css">
</head>
<body>
<div id="center">
    <div class="offresEntr">
        <div class="contenuOffresEntr">

                <?php
                foreach ($listOffre as $offre) {
                    echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre='. $offre->getIdOffre() .'  class=wrapOffres>';
                    echo "<div class='partieGauche'>";
                    echo '<p>' . $offre->getNomOffre() . '</p> </div> </a>';
                }
                ?>
        </div>
    </div>
</div>
</body>