<div class="boiteMain">
    <div class="ProfInfos">
        <div class="h3centre">
            <h3>Votre Photo de Profil</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre photo ici :</p>
                pas dispo
                <!--<form enctype="multipart/form-data" action="?action=updateImage&controleur=ProfMain" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                    <input type="file" name="fic" size="500">
                    <input type="submit" value="Envoyer">
                </form>-->
            </div>
            <div class="imageProf">
                <?php
                $prof=(new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte());
                echo '<img src="' . Configuration::getUploadPathFromId($prof->getImg()) . '" alt="profile_pic etudiant">'; ?>
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueProf">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte personnel</h3>
            <p>Visualisez les données de votre compte en un coup d'oeil</p>
            <br>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/compteEtu.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="informationsActuellesProf">
        <h3>Vos Informations Actuelles</h3>
        <div class="infosActu">
            <ul id="infosProf">
                <?php
                $prenomHTML=htmlspecialchars($prof->getPrenomProf());
                $nomHTML=htmlspecialchars($prof->getNomProf());
                $mailHTML=htmlspecialchars($prof->getMailUniversitaire());
                echo "
            <li>Prénom : " . $prenomHTML . "</li>
            <li>Nom : " . $nomHTML . "</li>
            <li>Mail universitaire : " . $mailHTML . "</li>
            " ?>
            </ul>

            <img src="../ressources/images/donneesEtu.png" alt="illu">

        </div>
    </div>


    <div class="detailsDeProf">
        <!-- TODO/ STats 2/3-->
        <h3>Vos Statistiques</h3>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/postulation.png" alt="illustration postuler">
            </div>

            <div class="descStat">

            </div>

        </div>


        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/choix.png" alt="illustration postuler">
            </div>

            <div class="descStat">

            </div>

        </div>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/archiver.png" alt="illustration postuler">
            </div>

            <div class="descStat">
            </div>
        </div>
    </div>
</div>
