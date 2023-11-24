<html>
<head>
    <link rel="stylesheet" href="./../ressources/css/styleVueDetailEtudiant.css">
    <script src="../ressources/javaScript/mesFonctions.js"></script>
</head>
<body>
<div class="boiteMain" id="aGriser">


    <div class="conteneurBienvenueDetailEntr">
        <div class="texteBienvenue">
            <!-- affichage des informations principales de l'offre -->
            <h2><?php use App\FormatIUT\Controleur\ControleurEtuMain;
                use App\FormatIUT\Modele\DataObject\Postuler;
                use App\FormatIUT\Modele\Repository\EtudiantRepository;
                use App\FormatIUT\Modele\Repository\FormationRepository;
                use App\FormatIUT\Modele\Repository\PostulerRepository;

                $nomHTML = htmlspecialchars($offre->getNomOffre());
                echo $nomHTML . " - " . $offre->getTypeOffre() ?></h2>
            <h4><?php echo "Du " . $offre->getDateDebut() . " au " . $offre->getDateFin() ?></h4>
            <p><?php echo (new DateTime($offre->getDateDebut()))->diff(new DateTime($offre->getDateFin()))->format('Durée : %m mois, %d jours.'); ?></p>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/entrepriseOffre.png" alt="image de bienvenue">
        </div>
    </div>

    <div class="infosOffreEntr">
        <h3>Les Informations de l'Offre</h3>
        <div class="petitConteneurInfosOffre">
            <div class="overflowListe">
                <div class="overflowListe2">
                    <div id="liseInfosOffreEntr">
                        <p><span>Rémunération :</span> <?php echo $offre->getGratification() ?>€ par mois</p>
                        <p><span>Durée en heures :</span> <?php echo $offre->getDureeHeure() ?> heures au total</p>
                        <p><span>Nombre de jours par semaines :</span> <?php echo $offre->getJoursParSemaine() ?> jours
                        </p>
                        <p><span>Nombre d'Heures hebdomadaires :</span> <?php echo $offre->getNbHeuresHebdo() ?> heures
                        </p>
                        <p>
                            <span>Détails de l'offre :</span> <?php $detailHTML = htmlspecialchars($offre->getDetailProjet());
                            echo $detailHTML ?></p>
                        <div class="infosSurEntreprise">
                            <div class="left">
                                <?php
                                echo '<img src="data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '" class="imageEntr">';
                                ?>
                            </div>
                            <div class="right">
                                <h3><?php echo htmlspecialchars($entreprise->getNomEntreprise()); ?></h3>
                                <p><span>Téléphone : </span><?php echo htmlspecialchars($entreprise->getTel()); ?></p>
                                <p><span>Adresse : </span><?php echo htmlspecialchars($entreprise->getAdresseEntreprise()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="../ressources/images/etudiantsHeureux.png" alt="illu">
        </div>
    </div>


    <div class="actionsRapidesEntr">
        <h3>Actions Rapides</h3>

        <?php

        echo '<a id="my-button">
                <button class="boutonAssigner" onclick="afficherPopupDepotCV_LM()" ';
        $bool = false;
        $formation = ((new FormationRepository())->estFormation($_GET['idFormation']));
        if (is_null($formation)) {
            if (!(new EtudiantRepository())->aUneFormation(\App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant())) {
                if (!(new EtudiantRepository())->aPostule(\App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant(), $_GET['idFormation'])) {
                    $bool = true;
                }
            }
        }
        if (!$bool) {
            echo 'id="disabled" disabled';
        }
        echo ">POSTULER</button></a>";

        echo '<a id="my-button">
                <button class="boutonAssigner" onclick="afficherPopupModifCV_LM()" ';

        if ($bool) {
            echo 'id="disabled" disabled';
        }
        echo ">MODIFIER VOS FICHIERS</button></a>";
        ?>


        <a href='?action=afficherAccueilEtu&controleur=EtuMain'>
            <button class='boutonAssigner'>RETOUR</button>
        </a>
    </div>


    <div class="listeEtudiantsPostulants">
        <h3>Nombre d'étudiants postulants</h3>

        <div class="wrapPostulants">
            <?php

            $formation = (new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdFormation());
            if ($formation) {
                if ($formation->getIdEtudiant() == \App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant()) {
                    echo "<div class='nbPostulants'>
                <img src='../ressources/images/equipe.png' alt='postulants'>
                <h4>Vous avez l'offre</h4></div>";
                } else {
                    echo "<div class='nbPostulants'>
                <img src='../ressources/images/equipe.png' alt='postulants'>
                <h4>L'offre est déjà occupée </h4></div>";
                }
            } else {
                $listeEtu = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsEnAttente($offre->getIdFormation()));
                if (empty($listeEtu)) {
                    echo "
                <div class='erreur'>
                <h4>Personne n'a postulé. Faites Vite !</h4>
                <img src='../ressources/images/erreur.png' alt='erreur'>
                </div>
                ";
                } else {
                    echo "
                <div class='nbPostulants'>
                <img src='../ressources/images/equipe.png' alt='postulants'>
                <h4>";
                    $nbEtudiants = ((new EtudiantRepository())->nbPostulations($offre->getIdFormation()));
                    echo $nbEtudiants . " étudiant";
                    if ($nbEtudiants == 1) echo " a";
                    else echo "s ont";
                    echo " déjà postulé.</h4>
                    </div>";
                }
            }

            ?>

        </div>

    </div>


</div>

<div id="popup" class="popup">
    <div class="mainPopup">
        <h2>ENVOYEZ VOS DOCUMENTS POUR POSTULER !</h2>
        <p>Les documents doivent être au format PDF</p>

        <form enctype="multipart/form-data"
              action="?action=postuler&controleur=EtuMain&idFormation=<?php echo $offre->getIdFormation() ?>"
              method="post">
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre CV :</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <input type="file" id="fd1" name="fic" onchange="updateImage(1)" accept=".pdf, .txt" size=500/>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose1" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose1" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre lettre de Motivation :</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <input type="file" id="fd2" name="ficLM" onchange="updateImage(2)" accept=".pdf, .txt" size=500/>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose2" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose2" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <input type="submit" value="Postuler">
        </form>

        <div class="conteneurBoutonPopup">
            <a onclick="fermerPopupDepotCV_LM()">
                <button class="boutonAssignerPopup">RETOUR</button>
            </a>

        </div>
    </div>

    <div class="descPopup">
        <img src="../ressources/images/déposerCV.png" alt="image">
        <h2>DEPOSEZ VOS DOCUMENTS POUR AVOIR UN PROFIL COMPLET ET AVOIR PLUS DE CHANCES !</h2>
    </div>
</div>

<div id="popupModif" class="popup">
    <div class="mainPopup">
        <h2>MODIFIEZ VOS DOCUMENTS !</h2>
        <p>Les documents doivent être au format PDF</p>

        <form enctype="multipart/form-data"
              action="?action=modifierFichiers&controleur=EtuMain&idFormation=<?php echo $offre->getIdFormation() ?>"
              method="post">
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre CV :</label>
                    <?php
                        /*$postuler = (new PostulerRepository())->getObjectParClesPrimaires(array(ControleurEtuMain::getCleEtudiant(), $offre->getIdFormation()));
                        if($postuler->formatTableau()["cv"] != null){
                            echo "<p> Vous avez déjà déposé un CV </p>";
                        }
                        else{
                            echo "<p> Vous n'avez pas encore déposé de CV</p>";
                        }*/
                    ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <input type="file" id="fd3" name="fic" onchange="updateImage(3)" accept=".pdf, .txt" size=500/>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose3" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose3" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre lettre de Motivation :</label>
                    <?php
                        /*$postuler = (new PostulerRepository())->getObjectParClePrimaire();
                        if($postuler->formatTableau()["lettre"] != null){
                            echo "<p> Vous avez déjà déposé une lettre de motivation </p>";
                        }
                        else{
                            echo "<p> Vous n'avez pas encore déposé de lettre de motivation</p>";
                        }*/
                    ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                    <input type="file" id="fd4" name="ficLM" onchange="updateImage(4)" accept=".odt, .docx, .pdf, .txt" size=500/>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose4" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose4" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <input type="submit" value="Modifier vos documents">
        </form>

        <div class="conteneurBoutonPopup">
            <a onclick="fermerPopupModifCV_LM()">
                <button class="boutonAssignerPopup">RETOUR</button>
            </a>

        </div>
    </div>

    <div class="descPopup">
        <img src="../ressources/images/déposerCV.png" alt="image">
        <h2>DEPOSEZ VOS DOCUMENTS POUR AVOIR UN PROFIL COMPLET ET AVOIR PLUS DE CHANCES !</h2>
    </div>
</div>


</body>
</html>