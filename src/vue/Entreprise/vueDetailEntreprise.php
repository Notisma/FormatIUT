<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueDetailEntreprise.css">
</head>
<body>
<div class="boiteMain">
    <div class="conteneurBienvenueDetailEntr">
        <div class="texteBienvenue">
            <!-- affhichage des informations principales de l'offre -->
            <h2><?php echo $offre->getNomOffre()?></h2>
            <h4><?php echo "Du ".date_format($offre->getDateDebut(),'d F Y'). " au ".date_format($offre->getDateFin(),'d F Y')?></h4>
            <p><?php  echo ($offre->getDateDebut()->diff($offre->getDateFin()))->format('Duree : %m mois, %d jours'); ?></p>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/entrepriseOffre.png" alt="image de bienvenue">
        </div>
    </div>

<!-- TODO finir de lier à la BD -->
    <div class="infosOffreEntr">
        <h3>Les Informations de votre Offre</h3>
        <div class="petitConteneurInfosOffre">
            <div class="overflowListe">
                <div class="overflowListe2">
                    <ul id="liseInfosOffreEntr">
                        <li>Rémunération : <?php echo $offre->getGratification() ?>€ par mois</li>
                        <li>Durée en heures : <?php echo $offre->getDureeHeures() ?> heures au total</li>
                        <li>Nombre de jours par semaines : <?php echo $offre->getJoursParSemaine()?> jours</li>
                        <li>Nombre d'Heures hebdomadaires : <?php echo $offre->getNbHeuresHebdo() ?> heures</li>
                        <li>Détails de l'offre : <?php echo $offre->getDetailProjet() ?></li>
                    </ul>
                </div>
            </div>
            <img src="../ressources/images/infosEntre.png" alt="illu">
        </div>
    </div>


    <div class="actionsRapidesEntr">
        <h3>Actions Rapides</h3>
        <?php
        if ($entreprise->getSiret()==\App\FormatIUT\Controleur\ControleurEntrMain::getCleEntreprise()) {
            echo "<a href='?controleur=EntrMain&action=supprimerOffre&idOffre=" . rawurlencode($offre->getIdOffre()) . "'>
            <button class='boutonAssigner'>SUPPRIMER L'OFFRE</button>
        </a>
        <a href='?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=3'>
            <button class='boutonAssigner' id='disabled' disabled>MODIFIER L'OFFRE</button>
        </a>";
        }
        ?>
    </div>


    <div class="listeEtudiantsPostulants">
        <h3>Etudiants Postulants</h3>

        <div class="wrapPostulants">
            <?php
            $listeEtu=((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsEnAttente($offre->getIdOffre()));
            if (empty($listeEtu)){
                echo "Personne n'a postulé";
            }else {
                foreach ($listeEtu as $etudiant) {
                    echo '<div class="etudiantPostulant">
                <div class="illuPostulant">';
                    echo '<img src="data:image/jpeg;base64,'.base64_encode( $etudiant->getImg() ).'"/>';
                echo '</div>

                <div class="nomEtuPostulant">
                    <h4>';
                echo $etudiant->getPrenomEtudiant()." ".$etudiant->getNomEtudiant();
                $idOffreURl=rawurlencode($offre->getIdOffre());
                $idURL=rawurlencode($etudiant->getNumEtudiant());
                    echo '</h4>
                    <a href="?controleur=EntrMain&action=assignerEtudiantOffre&idOffre="' . $idOffreURl . '"&idEtudiant="' . $idURL . '"">';
                    echo '<button class="boutonAssigner" ';
                    if ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->aUneFormation($etudiant->getNumEtudiant())){
                        echo ' id="disabled" disabled';
                    }
                    $formation=(new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre);
                    if(!is_null($formation)) {
                        echo ' id="disabled" disabled';
                        if ($formation->getIdEtudiant()==$etudiant->getNumEtudiant()){
                            echo ">Assigné";
                        }else {
                            echo ">Assigner";
                        }
                    }else {
                        echo ">Assigner";
                    }
                    echo '</button>
                    </a>
                </div>

            </div>';
                }
            }

            ?>

        </div>

    </div>


</div>


</body>
</html>