<?php

use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;

$entreprise = (new EntrepriseRepository())->getObjectParClePrimaire(ConnexionUtilisateur::getNumEntrepriseConnectee());
?>

<div class="centreCompte">
    <script>window.onload = function () {
            afficherPageCompteEntr("compte");
        };</script>
    <div class="menuEntr">
        <div class="sousMenuEntr compteM" onclick="afficherPageCompteEntr('compte')">
            <img src="../ressources/images/profil.png" alt="profil">
            <div>
                <h3 class="titre">Mon Compte</h3>
            </div>
        </div>

        <div class="sousMenuEntr notifsM" onclick="afficherPageCompteEntr('notifs')">
            <img src="../ressources/images/notif.png" alt="profil">
            <div>
                <h3 class="titre">Notifications</h3>
            </div>
        </div>

        <div class="sousMenuEntr mdpM" onclick="afficherPageCompteEntr('mdp')">
            <img src="../ressources/images/cadenas.png" alt="profil">
            <div>
                <h3 class="titre">Mon Mot de Passe</h3>
            </div>
        </div>

    </div>

    <div class="mainEntr" id="compte">

        <h2 class="titre rouge">Modifier mon Profil</h2>
        <form method="POST" enctype="multipart/form-data">
            <h3 class="titre">Mon Avatar</h3>
            <div class="avatar">
                <?php
                echo "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($entreprise->getImg()) . "' alt='etudiant'>";
                ?>
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                    <input type="file" name="pdp" size="500">
                    <p>Glissez-déposez un fichier ou parcourez vos fichiers. JPEG et PNG uniquement</p>
                </div>
            </div>


            <h3 class="titre">Nom</h3>
            <div class="inputCentre">
                <label for="nom_id"></label><input type="text"
                                                   value='<?= htmlspecialchars($entreprise->getNomEntreprise()); ?>' name="nom"
                                                   id="nom_id" required maxlength="50">
            </div>

            <h3 class="titre">Statut Juridique</h3>
            <div class="inputCentre">
                <label for="statutJ_id"></label><input type="text"
                                                       value='<?= htmlspecialchars($entreprise->getStatutJuridique()); ?>' name="statutJ"
                                                       id="statutJ_id" required maxlength="50">
            </div>

            <h3 class="titre">Effectif</h3>
            <div class="inputCentre">
                <label for="effectif_id"></label><input type="number"
                                                        value='<?= htmlspecialchars($entreprise->getEffectif()); ?>' name="effectif"
                                                        id="effectif_id" required max="999999999">
            </div>

            <h3 class="titre">Code NAF</h3>
            <div class="inputCentre">
                <label for="codeNAF_id"></label><input type="text"
                                                       value='<?= htmlspecialchars($entreprise->getCodeNAF()); ?>' name="codeNAF"
                                                       id="codeNAF_id" required maxlength="50">
            </div>

            <h3 class="titre">Numéro de Téléphone</h3>
            <div class="inputCentre">
                <label for="tel_id"></label><input type="text"
                                                   value='<?= htmlspecialchars($entreprise->getTel()); ?>' name="tel"
                                                   id="tel_id" required maxlength="11">
            </div>

            <h3 class="titre">Adresse</h3>
            <div class="inputCentre">
                <label for="adresse_id"></label><input type="text"
                                                       value='<?= htmlspecialchars($entreprise->getAdresseEntreprise()); ?>' name="adresse"
                                                       id="adresse_id" required maxlength="255">
            </div>

            <div class="inputCentre">
                <input type="hidden" name="siret" value="<?= htmlspecialchars($entreprise->getSiret()); ?>">
                <input type="submit" value="Enregistrer" formaction="?action=mettreAJour&controleur=EntrMain">
            </div>


        </form>

    </div>

    <div class="mainEntr" id="notifs">
        <h2 class="titre rouge">Gérer les paramètres de Notifications</h2>
    </div>

    <div class="mainEntr" id="mdp">
        <h2 class="titre rouge">Modifier le Mot de Passe</h2>
        <form method="post">
            <h3 class="titre">Ancien Mot de Passe</h3>
            <div class="inputCentre">
                <label>
                    <input type="password" name="ancienMdp" required maxlength="50">
                </label>
            </div>

            <h3 class="titre">Nouveau Mot de Passe</h3>
            <div class="inputCentre">
                <label>
                    <input type="password" name="nouveauMdp" required maxlength="50">
                </label>
            </div>

            <h3 class="titre">Confirmer le Nouveau Mot de Passe</h3>
            <div class="inputCentre">
                <label>
                    <input type="password" name="confirmerMdp" required maxlength="50">
                </label>
            </div>

            <div class="inputCentre">
                <input type="submit" value="Enregistrer" formaction="?action=mettreAJourMdp&controleur=EntrMain">
            </div>
        </form>
    </div>


</div>