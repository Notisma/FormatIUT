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
    $idOffreURl=rawurlencode($offre->getIdOffre());
    if ($_GET["controleur"]=="EtuMain"){
        echo "<a href='?controleur=EtuMain&action=postuler&idOffre=".$idOffreURl."''><button>Postuler</button></a>";
    }

    //TODO si c'est pas une formation sinon afficher Etu
    if ($_GET["controleur"]=="EntrMain" && $entreprise->getSiret()==\App\FormatIUT\Controleur\ControleurEntrMain::getSiretEntreprise()){
        echo "<div id='listeEtu'>";
        $tabEtu=(new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsParOffre($offre->getIdOffre());
        foreach ($tabEtu as $item) {
            echo $item->getLogin();
            $idURL=rawurlencode($item->getNumEtudiant());
            echo "<a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=".$idOffreURl."&idEtudiant=".$idURL."'><button>Assigner</button></a><br>";
        }
        echo "</div>";
    }
        ?>
</div>
</body>
