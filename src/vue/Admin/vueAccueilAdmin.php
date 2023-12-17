<div class="adminMain">
    <div class="wrapBonjour">
        <div class="texteBonjour">
            <h3>Bonjour, <?php

                use App\FormatIUT\Configuration\Configuration;

                $prof = \App\FormatIUT\Lib\ConnexionUtilisateur::getUtilisateurConnecte();
                $prenomHTML = htmlspecialchars($prof->getPrenomProf());
                echo $prenomHTML;
                ?></h3>
            <?php
            if (\App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                echo "<p>Retrouvez les informations de votre tableau de bord Administrateur :</p>";
            } else {
                echo "<p>Retrouvez les informations de votre tableau de bord Enseignant :</p>";
            }
            ?>

        </div>

        <div class="imageBonjour">
            <img src="../ressources/images/bonjourEntr.png" alt="image de bienvenue" class="imageMoyenne">
        </div>
    </div>

    <div class="wrapEntrCount">
        <h3 class="titre">Données Entreprises :</h3>
        <div>
            <img src="../ressources/images/creationCompte.png" alt="image">
            <h4 class="titre">
                <?php
                $nb = sizeof($listeEntreprises);
                $s = "";
                if ($nb > 1) $s = "s";
                echo $nb . " Création" . $s . " compte" . $s;
                ?></h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>

        <div>
            <img src="../ressources/images/offres.png" alt="image">
            <h4 class="titre">
                <?php
                $nb = sizeof($listeOffres);
                $s = "";
                if ($nb > 1) $s = "s";
                echo $nb . " Création" . $s . " offre" . $s;
                ?></h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>
    </div>

    <div class="wrapEtuCount">
        <h3 class="titre">Données Étudiants :</h3>
        <div>
            <img src="../ressources/images/anomalies.png" alt="image">
            <h4 class="titre">
                <?php
                $nb = sizeof($listeEtudiants);
                $s = "";
                if ($nb > 1) $s = "s";
                echo $nb . " Anomalie" . $s . " Étudiant" . $s;
                ?></h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>

        <div>
            <img src="../ressources/images/modifications.png" alt="image">
            <h4 class="titre">100 Modifications</h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>
    </div>


    <div class="wrapAdminEntr">
        <h3 class="titre">Alertes - Entreprises</h3>
        <div class="wrapAlertes">
            <?php
            if ($listeEntreprises == null && $listeOffres == null) {
                echo '<div class="erreur"><img src="../ressources/images/erreur.png" alt="erreur"><h3 class="titre">Aucune alerte à afficher ici</h3> </div>';
            } else {
                foreach ($listeEntreprises as $entreprise) {

                    ?>
                    <a href="?action=afficherDetailEntreprise&controleur=AdminMain&idEntreprise=<?php echo $entreprise->getSiret() ?>"
                       class="alerteEntr">
                        <div class="imageAlerte">
                            <?php
                            echo '<img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">';
                            ?>
                        </div>

                        <div class="contenuAlerte">
                            <h3 class="titre" id="rouge">
                                <?php
                                $nomEntrHTML = htmlspecialchars($entreprise->getNomEntreprise());
                                echo $nomEntrHTML;
                                ?>

                                - Demande de création de compte</h3>
                            <div class="sujetAlerte">
                                <img src="../ressources/images/attention.png" alt="image">
                                <p>Demande de création de compte le 11/11/2023</p>
                            </div>
                        </div>
                    </a>
                <?php }
                ?>


                <!-- exemple d'alerte - offre postée -->
                <?php
                foreach ($listeOffres as $offre) {
                    $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
                    ?>

                    <a href="?action=afficherVueDetailOffre&controleur=AdminMain&idFormation=<?php echo $offre->getidFormation() ?>"
                       class="alerteEntr">
                        <div class="imageAlerte">
                            <?php
                            echo '<img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">';
                            ?>
                        </div>

                        <div class="contenuAlerte">
                            <h3 class="titre" id="rouge">
                                <?php
                                $nomEntrHTML = htmlspecialchars($entreprise->getNomEntreprise());
                                echo $nomEntrHTML;
                                ?> - Offre en attente</h3>
                            <div class="sujetAlerte">
                                <img src="../ressources/images/attention.png" alt="image">
                                <p>Demande d'envoi d'une offre le 13/11/2023</p>
                            </div>
                        </div>
                    </a>
                <?php }
            } ?>

        </div>
        <div class="wrapBoutons">
            <a href="?action=afficherListeEntreprises&controleur=AdminMain">VOIR PLUS</a>
        </div>
    </div>

    <div class="wrapAdminEtu">
        <h3 class="titre">Alertes - Étudiants</h3>

        <div class="wrapAlertes">

            <!-- exemple d'alerte - compte créé -->
            <?php

            if ($listeEtudiants == null) {
                echo '<div class="erreur"><img src="../ressources/images/erreur.png" alt="erreur"><h3 class="titre">Aucune anomalie à afficher ici</h3> </div>';
            } else {

                foreach ($listeEtudiants as $etudiant) { ?>

                    <a href="?action=afficherDetailEtudiant&controleur=AdminMain&numEtu= <?php echo $etudiant->getNumEtudiant() ?>"
                       class="alerteEntr" id="hoverRose">
                        <div class="imageAlerte">
                            <?php
                            echo '<img src="' . Configuration::getUploadPathFromId($etudiant->getImg()) . '" alt="pp entreprise">';
                            ?>
                        </div>

                        <div class="contenuAlerte">
                            <h3 class="titre" id="rouge">
                                <?php
                                $prenomEtuHTML = htmlspecialchars($etudiant->getPrenomEtudiant());
                                $nomEtuHTML = htmlspecialchars($etudiant->getNomEtudiant());
                                echo $prenomEtuHTML . " " . strtoupper($nomEtuHTML);
                                ?></h3>
                            <p>
                                <?php
                                if ($etudiant->getParcours() == "") {
                                    echo "Données non renseignées";
                                } else {

                                    $parcoursHTML = htmlspecialchars($etudiant->getParcours());
                                    $groupeHTML = htmlspecialchars($etudiant->getGroupe());
                                    echo $parcoursHTML . " - " . $groupeHTML;
                                }
                                ?></p>
                            <div class="sujetAlerte">
                                <img src="../ressources/images/attention.png" alt="image">
                                <p>Aucun Stage/Alternance</p>
                            </div>
                        </div>
                    </a>
                <?php }
            } ?>


            <!-- un exemple différent -->
            <a href="tt" class="alerteEntr" id="hoverRose">
                <div class="imageAlerte">
                    <img src="../ressources/images/profil.png" alt="image">
                </div>

                <div class="contenuAlerte">
                    <h3 class="titre" id="rouge">Thomas LOYE</h3>
                    <p>2e année - RACDV - Q2</p>
                    <div class="sujetAlerte">
                        <img src="../ressources/images/attention.png" alt="image">
                        <p>A modifié sa convention le 13/11/2023</p>
                    </div>
                </div>
            </a>


        </div>

        <div class="wrapBoutons">
            <a href="?action=afficherListeEtudiant&controleur=AdminMain">VOIR PLUS</a>
        </div>

    </div>


</div>