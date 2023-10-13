<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffresEtu.css">
</head>
<body>
<div id="center">
    <div class="offresEntr">
        <div class="contenuOffresEntr">

                <?php

                use App\FormatIUT\Modele\Repository\RegarderRepository;

                foreach ($listOffre as $offre) {
                    echo '<a href=?controleur=EtuMain&action=afficherVueDetailOffre&idOffre='. $offre->getIdOffre() .'  class=wrapOffres>';
                    echo "<div class='partieGauche'>";
                    echo '<p> <h3>' . $offre->getNomOffre() . "      -     ". $offre->getTypeOffre() . '</h3> </p>';
                    echo '<p>' . $offre->getSujet() . ' le ' .date_format($offre->getDateDebut(), 'd/m/Y') . " au " . date_format($offre->getDateFin(), 'd/m/Y'). '</p>';
                    echo   '<div class="wrapOffres">'. '<div class="divInfo">' . (new RegarderRepository())->getEtatEtudiantOffre($numEtu, $offre->getIdOffre()) . '</div>' . '</div>';
                    echo  '</div> </a>';

                }
                ?>
        </div>
    </div>
</div>
</body>