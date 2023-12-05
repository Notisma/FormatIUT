<?php

use App\FormatIUT\Configuration\Configuration;

$admin = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte());
?>

<div class="centreCompte">
    <script>window.onload = function () {
            afficherPageCompte("compte");
        };</script>
    <div class="menuAdmin">
        <div class="sousMenuAdmin compteM" onclick="afficherPageCompte('compte')">
            <img src="../ressources/images/profil.png" alt="profil">
            <div>
                <h3 class="titre">Mon Compte</h3>
            </div>
        </div>

        <div class="sousMenuAdmin notifsM" onclick="afficherPageCompte('notifs')">
            <img src="../ressources/images/notif.png" alt="profil">
            <div>
                <h3 class="titre">Mes Notifications</h3>
            </div>
        </div>

        <div class="sousMenuAdmin profsM" onclick="afficherPageCompte('profs')">
            <img src="../ressources/images/professeur.png" alt="profil">
            <div>
                <h3 class="titre">Mes Collègues</h3>
            </div>
        </div>

        <div class="sousMenuAdmin etuM" onclick="afficherPageCompte('etu')">
            <img src="../ressources/images/etudiants.png" alt="profil">
            <div>
                <h3 class="titre">Mes Étudiants</h3>
            </div>
        </div>
    </div>

    <div class="mainAdmins" id="compte">
        <h2 class="titre" id="rouge">Modifier mon Profil</h2>
        <form method="POST">
            <h3 class="titre">Mon Avatar</h3>
            <div class="avatar">
                <img src="../ressources/images/admin.png" alt="avatar">
                <div>
                    <input type="file" name="avatar" id="avatar_id" accept="image/png/jpeg, image/jpeg">
                    <p>Glissez-déposez un fichier ou parcourez vos fichiers. JPEG et PNG uniquement</p>
                </div>
            </div>

            <h3 class="titre">Nom</h3>
            <div class="inputCentre">
                <input type="text" value='<?= htmlspecialchars($admin->getNomProf()); ?>' name="nom" id="nom_id"
                       required maxlength="50"/>
            </div>

            <h3 class="titre">Prénom</h3>
            <div class="inputCentre">
                <input type="text" value='<?= htmlspecialchars($admin->getPrenomProf()); ?>' name="prenom"
                       id="prenom_id" required maxlength="50"/>
            </div>

            <div class="inputCentre">
                <input type="submit" value="Enregistrer" name="modifier" id="modifier_id"/>
            </div>


        </form>

    </div>

    <div class="mainAdmins" id="notifs">
        <p>notifs</p>
    </div>

    <div class="mainAdmins" id="profs">
        <p>profs</p>
    </div>

    <div class="mainAdmins" id="etu">
        <p>etudiants</p>
    </div>


</div>