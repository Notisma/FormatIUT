<div class="adminMain">
    <div class="wrapBonjour">
        <div class="texteBonjour">
            <h3>Bonjour, <?php
                $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte());
                echo $prof->getPrenomProf();
                ?></h3>
            <p>Retrouvez les dernières informations :</p>
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
                $nb= sizeof($listeEntreprises);
                $s="";
                if ($nb>1) $s="s";
                echo $nb ." Création".$s." compte".$s;
                ?></h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>

        <div>
            <img src="../ressources/images/offres.png" alt="image">
            <h4 class="titre">
                <?php
                $nb= sizeof($listeOffres);
                $s="";
                if ($nb>1) $s="s";
                echo $nb ." Création".$s." offre".$s;
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
                $nb=sizeof($listeEtudiants);
                $s="";
                if ($nb>1) $s="s";
                echo $nb . " Anomalie".$s." Étudiant".$s;
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
            <!-- exemple d'alerte - compte créé -->
            <a href="tt" class="alerteEntr">
                <div class="imageAlerte">
                    <?php
                    $src='"data:image/jpeg;base64,' . base64_encode($listeEntreprises[0]->getImg()). '"';
                    echo '<img src='. $src . 'alt="image">';
                    ?>
                </div>

                <div class="contenuAlerte">
                    <h3 class="titre" id="rouge">
                    <?php
                    echo $listeEntreprises[0]->getNomEntreprise();
                     ?>

                        - Demande de création de compte</h3>
                    <div class="sujetAlerte">
                        <img src="../ressources/images/attention.png" alt="image">
                        <p>Demande de création de compte le 11/11/2023</p>
                    </div>
                </div>
            </a>

            <!-- exemple d'alerte - offre postée -->
            <a href="?action=afficherDetailOffre&controleur=AdminMain" class="alerteEntr">
                <div class="imageAlerte">
                    <?php
                    $entreprise=(new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($listeOffres[0]->getSiret());
                    $src='"data:image/jpeg;base64,' . base64_encode($entreprise->getImg()). '"';
                    echo '<img src='. $src . 'alt="image">';
                    ?>
                </div>

                <div class="contenuAlerte">
                    <h3 class="titre" id="rouge">
                        <?php
                        echo $entreprise->getNomEntreprise();
                        ?> - Offre en attente</h3>
                    <div class="sujetAlerte">
                        <img src="../ressources/images/attention.png" alt="image">
                        <p>Demande d'envoi d'une offre le 13/11/2023</p>
                    </div>
                </div>
            </a>

        </div>
        <div class="wrapBoutons">
            <a href="?action=afficherListeEntreprises&controleur=AdminMain">VOIR PLUS</a>
        </div>
    </div>

    <div class="wrapAdminEtu">
        <h3 class="titre">Alertes - Étudiants</h3>

        <div class="wrapAlertes">

            <!-- exemple d'alerte - compte créé -->
            <a href="tt" class="alerteEntr" id="hoverRose">
                <div class="imageAlerte">
                    <?php
                    $src='"data:image/jpeg;base64,' . base64_encode($listeEtudiants[0]->getImg()). '"';
                    echo '<img src='. $src . 'alt="image">';
                    ?>
                </div>

                <div class="contenuAlerte">
                    <h3 class="titre" id="rouge">
                        <?php
                        echo $listeEtudiants[0]->getPrenomEtudiant() . " " . strtoupper($listeEtudiants[0]->getNomEtudiant());
                        ?></h3>
                    <p>
                        <?php
                        echo $listeEtudiants[0]->getParcours()." - ".$listeEtudiants[0]->getGroupe();
                        ?></p>
                    <div class="sujetAlerte">
                        <img src="../ressources/images/attention.png" alt="image">
                        <p>Aucun Stage/Alternance</p>
                    </div>
                </div>
            </a>

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