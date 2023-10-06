<link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
<body>
<div id="center">
    <h3><?php
        $nomHTML=htmlspecialchars($offre->getNomOffre());
        echo $nomHTML;
        ?></h3>
    <p>
        <?php
        $dateDebut=date_format($offre->getDateDebut(),'d F Y');
        $dateFin=date_format($offre->getDateFin(),'d F Y');
        $duree=($offre->getDateDebut()->diff($offre->getDateFin()))->format('%m month, %d days');
        echo "Du ".$dateDebut." au ".$dateFin. " : ". $duree;
        ?>
    </p>
</div>
</body>
