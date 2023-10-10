<link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
<body>
<div class="main">
    <!-- Partie concernant l'offre-->
    <div id="offre">
        <h1><?php

            use App\FormatIUT\Controleur\ControleurEtuMain;
            use App\FormatIUT\Modele\Repository\EtudiantRepository;

            $nomHTML = htmlspecialchars($offre->getNomOffre());
            echo $nomHTML;
            ?></h1>
        <h4>
            <?php
            echo $offre->getTypeOffre();
            ?>
        </h4>
        <p>
            <?php
            $dateDebut = date_format($offre->getDateDebut(), 'd F Y');
            $dateFin = date_format($offre->getDateFin(), 'd F Y');
            $duree = ($offre->getDateDebut()->diff($offre->getDateFin()))->format('%m mois, %d jours');
            echo "Du " . $dateDebut . " au " . $dateFin . " : " . $duree;
            ?>
        </p>
        <p>
            <?php
            echo "Gratification : " . $offre->getGratification();
            echo "<br>Durée en heure : " . $offre->getDureeHeures();
            echo "<br>Nombre de jours par semaine : " . $offre->getJoursParSemaine();
            echo "<br>Nombre d'heure Hebdomadaire : " . $offre->getNbHeuresHebdo();
            ?>
        </p>
        <p>
            <?php echo $offre->getSujet(); ?>
        </p>
    </div>
    <!-- Partie concernant l'entreprise qui propose cet offre-->
    <div id="entreprise">
        <h3>
            <?php echo $entreprise->getNomEntreprise(); ?>
        </h3>
        <p>
            Tel : <?php echo $entreprise->getTel() ?>
            <br>
            Adresse : <?php echo $entreprise->getAdresse() ?>
        </p>
    </div>
    <?php
    $formation = ((new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre));

    $idOffreURl = rawurlencode($offre->getIdOffre());
    //Vérification qu'il s'agit d'un étudiant
    if ($_GET["controleur"] == "EtuMain") {
        //est-ce que l'offre est déjà assigné ?
        if (!is_null($formation)) {
            //si oui, est-ce cet étudiant qui y est assigné ?
            if ($formation->getIdEtudiant() == ControleurEtuMain::getIdEtu()) {
                echo "Vous avez été accepté pour cette formation";
            } else {
                echo "Cet Offre est déjà assigné";
            }
        } else {
            //si l'offre est disponible, l'étudiant a-t-il déjà une formation ?
            if (!(new EtudiantRepository())->aUneFormation(ControleurEtuMain::getIdEtu())) {
                //si non, l'étudiant y-a-til déjà postulé ?
                if ((new EtudiantRepository())->aPostuler(ControleurEtuMain::getIdEtu(), $offre->getIdOffre())) {
                    echo "Vous avez déjà postuler";
                }else{
                    echo "<a href='?controleur=EtuMain&action=postuler&idOffre=" . $idOffreURl . "''><button>Postuler</button></a>";
                }
            } else {
                echo "Vous avez déjà une formation";
            }
        }
    }
    // s'agit-il de l'entreprise connecté ?
    if ($_GET["controleur"] == "EntrMain" && $entreprise->getSiret() == \App\FormatIUT\Controleur\ControleurEntrMain::getSiretEntreprise()) {
        //l'offre est-elle déjà assigné ?
        if (is_null($formation)) {
            echo "<div id='listeEtu'>";
            $tabEtu = (new EtudiantRepository())->EtudiantsParOffre($offre->getIdOffre());
            if (empty($tabEtu)) {
                echo "Aucun étudiant n'a postulé";
            } else {
                foreach ($tabEtu as $item) {
                    echo $item->getLogin();
                    $idURL = rawurlencode($item->getNumEtudiant());
                    echo "<a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'><button>Assigner</button></a><br>";
                }
            }
            echo "</div>";
        } else {
            echo "<div id='etudiant'>";
            $etudiant = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire($formation->getIdEtudiant()));
            echo "L'étudiant " . $etudiant->getLogin() . " est accepté en Formation";
        }
    }
    ?>
</div>
</body>
