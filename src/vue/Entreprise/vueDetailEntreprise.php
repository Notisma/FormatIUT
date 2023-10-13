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
                        <li>Rémunération : 100€ par mois</li>
                        <li>Durée en heures : 900 heures au total</li>
                        <li>Nombre de jours par semaines : 5 jours</li>
                        <li>Nombre d'Heures hebdomadaires : 30 heures</li>
                        <li>Détails de l'offre : Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris egestas
                            enim vehicula arcu facilisis facilisis. Pellentesque ipsum leo, malesuada ac odio in,
                            scelerisque interdum nisl. Maecenas justo risus, tincidunt id erat posuere, varius gravida
                            eros.
                            Praesent sed lectus urna. Maecenas auctor odio tellus, vitae mattis orci consequat non.
                            Phasellus efficitur, eros ut varius hendrerit, enim neque ullamcorper libero, sed tristique
                            velit tortor non lectus. Phasellus tincidunt lectus est, eu auctor elit dictum id. Sed
                            tempor
                            dignissim felis vel laoreet. Mauris sed blandit libero, ac dictum mauris. Vestibulum semper
                            scelerisque elit, eu mollis lorem mollis in. Pellentesque id ipsum ante. Fusce a magna
                            tempor,
                            aliquam risus posuere, lacinia augue.
                        </li>
                        <li>Nombre de refus : 0</li>
                        <li>Nombre de candidats en attente : 0</li>
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

            <div class="etudiantPostulant">
                <div class="illuPostulant">
                    <img src="../ressources/images/profil.png" alt="illustration">
                </div>

                <div class="nomEtuPostulant">
                    <h4>Raphaël IZORET</h4>
                    <a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'>
                        <button class="boutonAssigner">Assigner</button>
                    </a>
                </div>

            </div>


            <div class="etudiantPostulant">
                <div class="illuPostulant">
                    <img src="../ressources/images/profil.png" alt="illustration">
                </div>

                <div class="nomEtuPostulant">
                    <h4>Lorick VERGNES</h4>
                    <a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'>
                        <button class="boutonAssigner">Assigner</button>
                    </a>
                </div>

            </div>

            <div class="etudiantPostulant">
                <div class="illuPostulant">
                    <img src="../ressources/images/profil.png" alt="illustration">
                </div>

                <div class="nomEtuPostulant">
                    <h4>Jérôme PALAYSI</h4>
                    <a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'>
                        <button class="boutonAssigner">Assigner</button>
                    </a>
                </div>

            </div>

            <div class="etudiantPostulant">
                <div class="illuPostulant">
                    <img src="../ressources/images/profil.png" alt="illustration">
                </div>

                <div class="nomEtuPostulant">
                    <h4>Néo KONIKOFF-GARAIX</h4>
                    <a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'>
                        <button class="boutonAssigner">Assigner</button>
                    </a>
                </div>

            </div>

            <div class="etudiantPostulant">
                <div class="illuPostulant">
                    <img src="../ressources/images/profil.png" alt="illustration">
                </div>

                <div class="nomEtuPostulant">
                    <h4>Thomas LOYE</h4>
                    <a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'>
                        <button class="boutonAssigner">Assigner</button>
                    </a>
                </div>

            </div>

            <div class="etudiantPostulant">
                <div class="illuPostulant">
                    <img src="../ressources/images/profil.png" alt="illustration">
                </div>

                <div class="nomEtuPostulant">
                    <h4>Romain TOUZE</h4>
                    <a href='?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=" . $idOffreURl . "&idEtudiant=" . $idURL . "'>
                        <button class="boutonAssigner">Assigner</button>
                    </a>
                </div>

            </div>

        </div>

    </div>


</div>


</body>
</html>