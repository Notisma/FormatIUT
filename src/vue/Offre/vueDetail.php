<link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
<body>
<div id="center">
    <!-- Partie concernant l'offre-->
    <div id="offre">
    <h1><?php
        $nomHTML=htmlspecialchars($offre->getNomOffre());
        echo $nomHTML;
        ?></h1>
    <h4>
        <?php
        echo $offre->getTypeOffre();
        ?>
    </h4>
    <p>
        <?php
        $dateDebut=date_format($offre->getDateDebut(),'d F Y');
        $dateFin=date_format($offre->getDateFin(),'d F Y');
        $duree=($offre->getDateDebut()->diff($offre->getDateFin()))->format('%m mois, %d jours');
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
        <h3>
            <?php echo $entreprise->getNomEntreprise();?>
        </h3>
        <p>
            Tel : <?php echo $entreprise->getTel() ?>
            <br>
            Adresse : <?php echo $entreprise->getAdresse() ?>
        </p>
    </div>
    <?php
    if ($_GET["controleur"]=="EtuMain"){
        echo "<a href=''><button>Postuler</button></a>";
    }
        ?>
</div>
</body>
