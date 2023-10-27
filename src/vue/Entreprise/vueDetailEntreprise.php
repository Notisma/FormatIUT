<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueDetailEntreprise.css">
    <script src="../ressources/javaScript/mesFonctions.js"></script>
</head>
<div>
    <div class="boiteMain" id="aGriser">
        <div class="conteneurBienvenueDetailEntr">
            <div class="texteBienvenue">
                <!-- affhichage des informations principales de l'offre -->
                <h2><?php $nomOffreHTML = htmlspecialchars($offre->getNomOffre());
                    echo $nomOffreHTML . " - " . $offre->getTypeOffre() ?></h2>
                <h4><?php echo "Du " . date_format($offre->getDateDebut(), 'd F Y') . " au " . date_format($offre->getDateFin(), 'd F Y') ?></h4>
                <p><?php echo ($offre->getDateDebut()->diff($offre->getDateFin()))->format('Durée : %m mois, %d jours.'); ?></p>
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
                        <div id="liseInfosOffreEntr">
                            <p><span>Rémunération :</span> <?php echo $offre->getGratification() ?>€ par mois</p>
                            <p><span>Durée en heures :</span> <?php echo $offre->getDureeHeures() ?> heures au total</p>
                            <p><span>Nombre de jours par semaines :</span> <?php echo $offre->getJoursParSemaine() ?>
                                jours
                            </p>
                            <p><span>Nombre d'Heures hebdomadaires :</span> <?php echo $offre->getNbHeuresHebdo() ?>
                                heures
                            </p>
                            <p>
                                <span>Détails de l'offre :</span> <?php $detailHTML = htmlspecialchars($offre->getDetailProjet());
                                echo $detailHTML ?></p>
                        </div>
                    </div>
                </div>
                <img src="../ressources/images/entrepriseData.png" alt="illu">
            </div>
        </div>


        <div class="actionsRapidesEntr">
            <h3>Actions Rapides</h3>
            <?php
            if ($entreprise->getSiret() == \App\FormatIUT\Controleur\ControleurEntrMain::getCleEntreprise()) {
                echo "<a href='?controleur=EntrMain&action=supprimerOffre&idOffre=" . rawurlencode($offre->getIdOffre()) . "'>
            <button class='boutonAssigner'>SUPPRIMER L'OFFRE</button>
        </a>
        <a href='?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=3'>
            <button class='boutonAssigner' id='disabled' disabled>MODIFIER L'OFFRE</button>
        </a>
        ";

            }
            ?>
            <a href='?action=mesOffres&controleur=EntrMain'>
                <button class='boutonAssigner'>RETOUR</button>
            </a>
        </div>


        <div class="listeEtudiantsPostulants">
            <h3>Etudiants Postulants</h3>

            <div class="wrapPostulants">
                <?php
                $listeEtu = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsEnAttente($offre->getIdOffre()));
                if (empty($listeEtu)) {
                    $formation = (new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdOffre());
                    if ($formation) {
                        $etudiant = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant()));
                        echo '<div class="etudiantPostulant" onclick="afficherPopupInfosEtu()">
                        <div class="illuPostulant">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($etudiant->getImg()) . '"/>';
                        echo '</div>
                        <div class="nomEtuPostulant">
                            <h4>';
                        echo $etudiant->getPrenomEtudiant() . " " . $etudiant->getNomEtudiant() . "</h4>";
                        echo "<a><button class='boutonAssigner' disabled id='disabled' >Assigné</button></a>";

                    } else {
                        echo "
                <div class='erreur'>
                <h4>Personne n'a postulé.</h4>
                <img src='../ressources/images/erreur.png' alt='erreur'>
                </div>
                ";
                    }
                } else {
                    foreach ($listeEtu as $etudiant) {
                        echo '<div class="etudiantPostulant" onclick="afficherPopupInfosEtu()">
                        <div class="illuPostulant">';
                        echo '<img src="data:image/jpeg;base64,' . base64_encode($etudiant->getImg()) . '"/>';
                        echo '</div>
                        <div class="nomEtuPostulant">
                            <h4>';
                        echo $etudiant->getPrenomEtudiant() . " " . $etudiant->getNomEtudiant();
                        $idOffreURl = rawurlencode($offre->getIdOffre());
                        $idURL = rawurlencode($etudiant->getNumEtudiant());
                        echo '</h4>
                            <a href="?controleur=EntrMain&action=assignerEtudiantOffre&idOffre=' . $idOffreURl . '&idEtudiant=' . $idURL . '">';
                        echo '<button class="boutonAssigner" ';
                        if ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->aUneFormation($etudiant->getNumEtudiant())) {
                            echo ' id="disabled" disabled';
                        }
                        if ((new \App\FormatIUT\Modele\Repository\RegarderRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offre->getIdOffre()) == "A Choisir") {
                            echo 'id="disabled" disabled>Envoyée';
                        } else {
                            $formation = (new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdOffre());
                            if (!is_null($formation)) {
                                echo ' id="disabled" disabled';
                                if ($formation->getIdEtudiant() == $etudiant->getNumEtudiant()) {
                                    echo ">Assigné";
                                } else {
                                    echo ">Assigner";
                                }
                            } else {
                                echo ">Assigner";
                            }
                        }
                        echo '</button></a></div>;
                </div>';
                    }
                }
                ?>
            </div>

        </div>

    </div>


</div>
</div>


<div id="infosEtuCandidat">
    <h1>INFORMATIONS SUR LE CANDIDAT</h1>
    <h4>Retrouvez toutes les informations sur un étudiant et les actions qui y sont associées</h4>
    <div class="detailsEtu">
        <div class="PPEtu">
            <?php
            echo '<img src="data:image/jpeg;base64,' . base64_encode($etudiant->getImg()) . '"/>';
            ?>
        </div>

        <div class="infosEtu">
            <?php
            echo "<h2>" . $etudiant->getPrenomEtudiant() . " " . $etudiant->getNomEtudiant() . "</h2>";
            echo "<p><span>Numéro Etudiant :</span> " . $etudiant->getNumEtudiant() . "</p>";
            echo "<p><span>Mail Universitaire :</span> " . $etudiant->getMailUniersitaire() . "</p>";
            echo "<p><span>Mail Personnel :</span> " . $etudiant->getMailPerso() . "</p>";
            echo "<p><span>Téléphone :</span> " . $etudiant->getTelephone() . "</p>";
            echo "<p><span>Groupe :</span> " . $etudiant->getGroupe() . "</p>";
            echo "<p><span>Parcours :</span> " . $etudiant->getParcours() . "</p>";
            ?>
        </div>
    </div>

    <div class="wrapBoutonsDoc">
        <a href="">
            <button class="boutonDoc">TELECHARGER CV</button>
        </a>
        <a href="">
            <button class="boutonDoc">TELECHARGER LETTRE</button>
        </a>
    </div>

    <div class="wrapActions">
        <a onclick="fermerPopupInfosEtu()">
            <button class="boutonAction">RETOUR</button>
        </a>

        <!-- TODO : RELIER A LA BD -->
        <a href="">
            <button class="boutonAction">ASSIGNER</button>
        </a>

    </div>

</div>

</body>
</html>