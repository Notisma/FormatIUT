<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueDetailEtudiant.css">
</head>
<body>
<div class="boiteMain">
    <div class="conteneurBienvenueDetailEntr">
        <div class="texteBienvenue">
            <!-- affhichage des informations principales de l'offre -->
            <h2><?php echo $offre->getNomOffre()?></h2>
            <h4><?php echo "Du ".date_format($offre->getDateDebut(),'d F Y'). " au ".date_format($offre->getDateFin(),'d F Y')?></h4>
            <p><?php  echo ($offre->getDateDebut()->diff($offre->getDateFin()))->format('Durée : %m mois, %d jours.'); ?></p>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/entrepriseOffre.png" alt="image de bienvenue">
        </div>
    </div>

    <!-- TODO finir de lier à la BD -->
    <div class="infosOffreEntr">
        <h3>Les Informations de l'Offre</h3>
        <div class="petitConteneurInfosOffre">
            <div class="overflowListe">
                <div class="overflowListe2">
                    <div id="liseInfosOffreEntr">
                        <p><span>Rémunération :</span> <?php echo $offre->getGratification() ?>€ par mois</p>
                        <p><span>Durée en heures :</span> <?php echo $offre->getDureeHeures() ?> heures au total</p>
                        <p><span>Nombre de jours par semaines :</span> <?php echo $offre->getJoursParSemaine()?> jours</p>
                        <p><span>Nombre d'Heures hebdomadaires :</span> <?php echo $offre->getNbHeuresHebdo() ?> heures</p>
                        <p><span>Détails de l'offre :</span> <?php echo $offre->getDetailProjet() ?></p>
                    </div>
                </div>
            </div>
            <img src="../ressources/images/etudiantsHeureux.png" alt="illu">
        </div>
    </div>


    <div class="actionsRapidesEntr">
        <h3>Actions Rapides</h3><a href="?controleur=EntrMain&action=supprimerOffre&idOffre=">
            <button class='boutonAssigner'>POSTULER</button>
        </a>
        <a href='?action=afficherAccueilEtu&controleur=EtuMain'>
            <button class='boutonAssigner'>RETOUR</button>
        </a>
    </div>


    <div class="listeEtudiantsPostulants">
        <h3>Nombre d'étudiants postulants</h3>

        <div class="wrapPostulants">
            <?php
            $listeEtu=((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsEnAttente($offre->getIdOffre()));
            if (empty($listeEtu)){
                echo "
                <div class='erreur'>
                <h4>Personne n'a postulé. Faites Vite !</h4>
                <img src='../ressources/images/erreur.png' alt='erreur'>
                </div>
                ";
            }else {
                echo "
                <div class='nbPostulants'>
                <img src='../ressources/images/equipe.png' alt='postulants'>
                <h4>5 Etudiants ont déjà postulé.</h4>
                </div>          
                
                
            ";
            }

            ?>

        </div>

    </div>


</div>


</body>
</html>