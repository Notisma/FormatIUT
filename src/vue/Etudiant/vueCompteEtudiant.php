<div class="boiteMain">
    <div class="etudiantInfos">
        <div class="h3centre">
            <h3>Votre Photo de Profil</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre photo ici :</p>
                <form enctype="multipart/form-data" action="?action=updateImage&controleur=EtuMain" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                    <input type="file" name="pdp" size="500">
                    <input type="submit" value="Envoyer">
                </form>
            </div>
            <div class="imageEtu">
                <?= '<img src="data:image/jpeg;base64,' . base64_encode($etudiant->getImg()) . '" alt="profile_pic etudiant">'; ?>
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueEtu">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte étudiant</h3>
            <p>Visualisez les données de votre compte en un coup d'oeil</p>
            <br>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/compteEtu.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="informationsActuellesEtu">
        <h3>Vos Informations Actuelles</h3>
        <div class="infosActu">
            <ul id="infosEtu">
                <?php
                echo "
            <li>Prénom : ".htmlspecialchars($etudiant->getPrenomEtudiant())."</li>
            <li>Nom : ".htmlspecialchars($etudiant->getNomEtudiant())."</li>
            <li>Login : ".htmlspecialchars($etudiant->getLogin())."</li>
            <li>Numéro Etudiant : ".$etudiant->getNumEtudiant()."</li>
            <li>Mail universitaire : ".htmlspecialchars($etudiant->getMailUniersitaire())."</li>
            <li>Mail personnel : ".htmlspecialchars($etudiant->getMailPerso())."</li>
            <li>Téléphone : ".htmlspecialchars($etudiant->getTelephone())."</li>
            <li>Groupe : ".htmlspecialchars($etudiant->getGroupe())."</li>
            <li>Parcours : ".htmlspecialchars($etudiant->getParcours())."</li>
            " ?>
                <a href="?action=afficherFormulaireModification&controleur=EtuMain">Modifier vos informations</a>
            </ul>

            <img src="../ressources/images/donneesEtu.png" alt="illu">

        </div>
    </div>


    <div class="detailsDeEntreprise">
        <h3>Vos Statistiques</h3>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/postulation.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4><?php
                    $nb = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbEnEtat($etudiant->getNumEtudiant(), "En Attente"));
                    echo $nb . " Postulation";
                    if ($nb != 1) echo "s";
                    ?>

                    en attente d'assignation</h4>
            </div>

        </div>


        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/choix.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4><?php
                    $nb = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbEnEtat($etudiant->getNumEtudiant(), "A Choisir"));
                    echo $nb . " assignation";
                    if ($nb != 1) echo "s";
                    ?> en attente de choix</h4>
            </div>

        </div>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/archiver.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4>0 documents ou contrats archivés</h4>
            </div>
        </div>
    </div>
</div>
