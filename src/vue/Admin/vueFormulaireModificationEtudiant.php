<div id="center" class="antiPadding">
    <div class="wrapDroite">
        <form method="POST">
            <fieldset>
                <legend>Modifier <?php use App\FormatIUT\Modele\Repository\EtudiantRepository;
                    $etu = (new EtudiantRepository())->getObjectParClePrimaire($_REQUEST['numEtu']);
                    echo $etu->getPrenomEtudiant();
                    echo " ";
                    echo $etu->getNomEtudiant();?></legend>

                <label for="numEtudiant_id">Numéro étudiant</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getNumEtudiant()?> name="numEtudiant"
                    id="numEtudiant_id" required/>
                </div>

                <label for="nomEtudiant_id">Nom</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getNomEtudiant()?> name="nomEtudiant"
                           id="nomEtudiant_id" required maxlength="32"/>
                </div class="inputCentre">

                <label for="prenomEtudiant_id">Prénom</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getPrenomEtudiant()?> name="prenomEtudiant"
                           id="prenomEtudiant_id" required maxlength="32"/>
                </div class="inputCentre">

                <label for="loginEtudiant_id">Login</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getLoginEtudiant()?> name="loginEtudiant"
                           id="loginEtudiant_id" required maxlength="32"/>
                </div class="inputCentre">

                <label for="mailUniversitaire_id">Mail universitaire</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getMailUniersitaire()?> name="mailUniversitaire"
                           id="mailUniversitaire_id" required maxlength="50"/>
                </div class="inputCentre">

                <label for="groupe_id">Groupe de classe</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getGroupe()?> name="groupe"
                           id="groupe_id" required maxlength="2"/>
                </div class="inputCentre">

                <label for="parcours_id">Parcours du BUT</label> :
                <div class="inputCentre">
                    <input type="text" value=<?php echo $etu->getParcours()?> name="parcours"
                           id="parcours_id" required maxlength="5"/>
                </div class="inputCentre">

                <div class="boutonsForm">
                    <input type="submit" value="Envoyer" formaction="?action=modifierEtudiant&controleur=AdminMain&numEtu=<?php echo $etu->getNumEtudiant();?>"/>
                </div>
            </fieldset>
        </form>
    </div>
</div>
