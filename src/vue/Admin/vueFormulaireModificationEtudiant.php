<div class="mainForm">
    <?php
    $etu = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire($_GET['numEtu'])
    ?>
    <div class="wrapDroite">
        <form method="POST">
            <label for="nomEtudiant_id">Nom :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getNomEtudiant() ?>" name="nomEtudiant"
                       id="nomEtudiant_id" placeholder="Dubois" required maxlength="32">
            </div class="inputCentre">

            <label for="prenomEtudiant_id">Prénom :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getPrenomEtudiant() ?>" name="prenomEtudiant"
                       id="prenomEtudiant_id" placeholder="Hugo" required maxlength="32">
            </div class="inputCentre">

            <label for="loginEtudiant_id">Login :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getLoginEtudiant() ?>" name="loginEtudiant"
                       id="loginEtudiant_id" placeholder="duboish" required maxlength="32">
            </div class="inputCentre">

            <label for="sexeId">Sexe :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getSexeEtu() ?>" name="sexeEtu" id="sexeId"
                       placeholder="M" maxlength="1">
            </div>

            <label for="mailUniversitaire_id">Mail universitaire :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getMailUniersitaire() ?>" name="mailUniversitaire"
                       placeholder="duboish@etu.umontpellier.fr" id="mailUniversitaire_id" maxlength="50">
            </div class="inputCentre">

            <label for="mailPerso_id">Mail personnel :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getMailPerso() ?>" name="mailPerso"
                       placeholder="darkhugo@gmail.com" id="mailPerso_id" maxlength="50">
            </div class="inputCentre">

            <label for="telephone_id">Téléphone :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getTelephone() ?>" name="telephone"
                       placeholder="06 58 45 12 32" id="telephone_id" maxlength="50">
            </div class="inputCentre">

            <label for="groupe_id">Groupe de classe :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getGroupe() ?>" name="groupe"
                       placeholder="Q2" id="groupe_id" maxlength="2">
            </div class="inputCentre">

            <label for="parcours_id">Parcours du BUT :</label>
            <div class="inputCentre">
                <input type="text" value="<?= $etu->getParcours() ?>" name="parcours"
                       placeholder="RACDV" id="parcours_id" maxlength="5">
            </div class="inputCentre">

            <div class="boutonsForm">
                <input type="submit" value="Envoyer"
                       formaction="?action=modifierEtudiant&controleur=AdminMain&numEtudiant=<?= $etu->getNumEtudiant(); ?>">
            </div>
        </form>
    </div>
</div>
