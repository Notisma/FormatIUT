<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\Repository\EtudiantRepository;

$etudiant = (new EtudiantRepository())->getEtudiantParLogin(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte());
?>

<div class="centreCompte">
    <script>window.onload = function () {
            afficherPageCompteEtu("compte");
        };</script>
    <div class="menuEtu">
        <div class="sousMenuEtu compteM" onclick="afficherPageCompteEtu('compte')">
            <img src="../ressources/images/profil.png" alt="profil">
            <div>
                <h3 class="titre">Mon Compte</h3>
            </div>
        </div>

        <div class="sousMenuEtu notifsM" onclick="afficherPageCompteEtu('notifs')">
            <img src="../ressources/images/notif.png" alt="profil">
            <div>
                <h3 class="titre">Notifications</h3>
            </div>
        </div>

    </div>

    <div class="mainEtu" id="compte">

        <h2 class="titre rouge">Modifier mon Profil</h2>
        <form method="POST" enctype="multipart/form-data">
            <h3 class="titre">Mon Avatar</h3>
            <div class="avatar">
                <?php
                //echo App\FormatIUT\Configuration\Configuration::getUploadPathFromId($etudiant->getImg());
                echo "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($etudiant->getImg()) . "' alt='etudiant'>";
                ?>
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                    <input type="file" name="pdp" size="500">
                    <p>Glissez-déposez un fichier ou parcourez vos fichiers. JPEG et PNG uniquement</p>
                </div>
            </div>

            <h3 class="titre">Nom</h3>
            <div class="inputCentre">
                <input disabled type="text" value='<?= htmlspecialchars($etudiant->getNomEtudiant()); ?>' name="nom"
                       id="nom_id"
                       required maxlength="50">
            </div>

            <h3 class="titre">Prénom</h3>
            <div class="inputCentre">
                <input disabled type="text" value='<?= htmlspecialchars($etudiant->getPrenomEtudiant()); ?>'
                       name="prenom"
                       id="prenom_id" required maxlength="50">
            </div>

            <h3 class="titre">Mail Personnel</h3>
            <div class="inputCentre">
                <input type="text" value='<?= htmlspecialchars($etudiant->getMailPerso()); ?>' name="mailPerso"
                       id="mailPerso_id"  maxlength="50">
            </div>

            <h3 class="titre">Numéro de téléphone</h3>
            <div class="inputCentre">
                <input type="text" value='<?= htmlspecialchars($etudiant->getTelephone()); ?>' name="numTel"
                       id="numTel_id"  maxlength="11" >
            </div>

            <div class="inputCentre">
                <input type='hidden' name='numEtu' value='<?= htmlspecialchars($etudiant->getNumEtudiant()) ?>'>
                <input type="submit" value="Enregistrer" formaction="?action=mettreAJour&controleur=EtuMain">
            </div>


        </form>

    </div>

    <div class="mainEtu" id="notifs">
        <h2 class="titre rouge">Gérer les paramètres de Notifications</h2>
    </div>


</div>