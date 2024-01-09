<div id="center" class="antiPadding">
    <div class="wrapDroite">
        <form method="POST">
            <fieldset>
                <legend>Modifier <?php use App\FormatIUT\Modele\Repository\EtudiantRepository;

                    $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtudiant']);
                    echo $etu->getPrenomEtudiant();
                    echo " ";
                    echo $etu->getNomEtudiant(); ?></legend>

                <label for="nomEtudiant_id">Nom</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getNomEtudiant() ?>" name="nomEtudiant"
                           id="nomEtudiant_id" required maxlength="32"/>
                </div class="inputCentre">

                <label for="prenomEtudiant_id">Prénom</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getPrenomEtudiant() ?>" name="prenomEtudiant"
                           id="prenomEtudiant_id" required maxlength="32"/>
                </div class="inputCentre">

                <label for="loginEtudiant_id">Login</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getLoginEtudiant() ?>" name="loginEtudiant"
                           id="loginEtudiant_id" required maxlength="32"/>
                </div class="inputCentre">

                <label for="sexeId">Sexe</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getSexeEtu() ?>" name="sexeEtu" id="sexeId"
                           maxlength="1"/>
                </div>

                <label for="mailUniversitaire_id">Mail universitaire</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getMailUniersitaire() ?>" name="mailUniversitaire"
                           id="mailUniversitaire_id" maxlength="50"/>
                </div class="inputCentre">

                <label for="mailPerso_id">Mail personnel</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getMailPerso() ?>" name="mailPerso"
                           id="mailPerso_id" maxlength="50"/>
                </div class="inputCentre">

                <label for="telephone_id">Téléphone</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getTelephone() ?>" name="telephone"
                           id="telephone_id" maxlength="50"/>
                </div class="inputCentre">

                <label for="groupe_id">Groupe de classe</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getGroupe() ?>" name="groupe"
                           id="groupe_id" maxlength="2"/>
                </div class="inputCentre">

                <label for="parcours_id">Parcours du BUT</label> :
                <div class="inputCentre">
                    <input type="text" value="<?= $etu->getParcours() ?>" name="parcours"
                           id="parcours_id" maxlength="5"/>
                </div class="inputCentre">

                <div class="boutonsForm">
                    <input type="submit" value="Envoyer"
                           formaction="?action=modifierEtudiant&controleur=AdminMain&numEtudiant=<?= $etu->getNumEtudiant(); ?>"/>
                </div>
            </fieldset>
        </form>
    </div>
</div>
