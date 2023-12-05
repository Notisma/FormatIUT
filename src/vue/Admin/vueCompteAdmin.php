<div class="centreCompte">
    <script>window.onload = function() {
            afficherPageCompte("compte");
        };</script>
    <div class="menuAdmin">
        <div class="sousMenuAdmin" onclick="afficherPageCompte('compte')">
            <img src="../ressources/images/profil.png" alt="profil">
            <div>
                <h3 class="titre">Mon Compte</h3>
            </div>
        </div>

        <div class="sousMenuAdmin" onclick="afficherPageCompte('notifs')">
            <img src="../ressources/images/notif.png" alt="profil">
            <div>
                <h3 class="titre">Mes Notifications</h3>
            </div>
        </div>

        <div class="sousMenuAdmin" onclick="afficherPageCompte('profs')">
            <img src="../ressources/images/professeur.png" alt="profil">
            <div>
                <h3 class="titre">Mes Collègues</h3>
            </div>
        </div>

        <div class="sousMenuAdmin" onclick="afficherPageCompte('etu')">
            <img src="../ressources/images/etudiants.png" alt="profil">
            <div>
                <h3 class="titre">Mes Étudiants</h3>
            </div>
        </div>
    </div>

    <div class="mainAdmins" id="compte">
        <p>compte</p>
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