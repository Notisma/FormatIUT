<head>
    <link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
</head>
<body>
<div id="center">
<ul>
    <?php
foreach ($listeOffres as $offre) {
    echo "<li>";
    echo "L'offre ".$offre->getNomOffre()." du ".$offre->getDateDebut(). " au ".$offre->getDateFin(). " pour ".$offre->getSujet();
    echo "<br> ".$offre->getDetailProjet();
    echo "</li>";

} ?>
</ul>
</div>
</body>
