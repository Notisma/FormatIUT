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
            <h4 class="titre">400 Créations comptes</h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>

        <div>
            <img src="../ressources/images/offres.png" alt="image">
            <h4 class="titre">500 Créations offres</h4>
            <div class="wrapBoutons" id="boutonsGO">
                <a href="">VOIR</a>
            </div>
        </div>
    </div>

    <div class="wrapEtuCount">
        <h3 class="titre">Données Étudiants :</h3>
        <div>
            <img src="../ressources/images/anomalies.png" alt="image">
            <h4 class="titre">100 Anomalies Étudiants</h4>
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
            <!-- exemple d'alerte -->
            <a href="tt" class="alerteEntr">
                <div class="imageAlerte">
                    <img src="../ressources/images/logo_CA.png" alt="image">
                </div>

                <div class="contenuAlerte">
                    <h3 class="titre" id="rouge">CRÉDIT AGRICOLE - Demande de création de compte</h3>
                    <div class="sujetAlerte">
                        <img src="../ressources/images/attention.png" alt="image">
                        <p>Compte créé</p>
                        <p>Demande de création de compte le 11/11/2023</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="wrapBoutons">
            <a href="">VOIR PLUS</a>
        </div>
    </div>

    <div class="wrapAdminEtu">
        <h3 class="titre">Alertes - Étudiants</h3>
    </div>




</div>