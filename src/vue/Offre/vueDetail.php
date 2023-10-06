<link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
<body>
<div id="center">
    <!-- Partie concernant l'offre-->
    <div id="offre">
    <h3><?php
        $nomHTML=htmlspecialchars($offre->getNomOffre());
        echo $nomHTML;
        ?></h3>
    <h4>
        <?php
        echo $offre->getTypeOffre();
        ?>
    </h4>
    <p>
        <?php
        $dateDebut=date_format($offre->getDateDebut(),'d F Y');
        $dateFin=date_format($offre->getDateFin(),'d F Y');
        $duree=($offre->getDateDebut()->diff($offre->getDateFin()))->format('%m month, %d days');
        echo "Du ".$dateDebut." au ".$dateFin. " : ". $duree;
        ?>
    </p>
    <p>
        <?php
        echo "Gratification : ". $offre->getGratification();
        echo "<br>Durée en heure : ".$offre->getDureeHeures();
        echo "<br>Nombre de jours par semaine : ".$offre->getJoursParSemaine();
        echo "<br>Nombre d'heure Hebdomadaire : ".$offre->getNbHeuresHebdo();
        ?>
    </p>
    <p>
        <?php echo $offre->getSujet(); ?>
    </p>
    </div>
    <!-- Partie concernant l'entreprise qui propose cet offre-->
    <div id="entreprise">
        <h4>
            <?php echo $entreprise->getNomEntreprise();?>
        </h4>
    </div>
</div>
</body>
