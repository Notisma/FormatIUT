
<div id="center">

    <div class="presentation">

        <form method="post">
            <fieldset>
                <legend> Ma convention :</legend>
                <p><label for="offre_id">Votre alternance : </label>
                    <?php
                    if ($offre) {
                        echo '<input value="' . htmlspecialchars($offre->getNomOffre()) . '" name="nomOffre" id="offre_id"  readonly required> </input>';
                        echo '<input type="hidden" value="'.$offre->getidFormation().'" name="idOff"> </input>';

                        }
                     else {
                        echo '<input value="aucune" name="idOff" id="offre_id"  readonly required>';
                    } ?>

                </p>
                <p> Informations de l'étudiant :</p>
                <p><label for="num_id"> N° étudiant </label>
                    <input type="text" value="<?= $etudiant->getNumEtudiant(); ?>" name="numEtudiant" id="num_id"
                           readonly required>
                </p>
                <p><label for="nom_id"> Nom </label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getNomEtudiant()); ?>" name="nomEtudiant" id="nom_id"
                           readonly required>
                </p>
                <p><label for="prenom_id"> Nom </label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getPrenomEtudiant()); ?>" name="prenomEtudiant"
                           id="prenom_id" readonly required>
                </p>
                <p><label for="tel_id"> N° tel </label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getTelephone()) ?>" name="telephone" id="tel_id" readonly
                           required></p>
                <p><label for="mail_id">Mail</label>
                    <input type="text" value="<?= htmlspecialchars($etudiant->getMailPerso()); ?>" name="mailEtu" id="mail_id" readonly
                           required></p>
                <p><label for="assu_id">Assurance</label>
                    <input type="text" name="assurance" id="assu_id" required></p>
                <p>Informations de l'entreprise :</p>
                <p><label for="sir_id">Siret</label>
                    <input type="number" name="siret" value="<?= $entreprise->getSiret();?>" id="sir_id" required></p>
                <p><label for="nomEntr_id"> Nom entreprise </label>
                    <input type="text" name="nomEntreprise" value="<?= htmlspecialchars($entreprise->getNomEntreprise());?>" id="nomEntr_id" required>
                </p>
                <p><label for="adrEntr_id">Adresse Entreprise</label>
                    <input type="text" name="adresseEntr" value="<?= htmlspecialchars($entreprise->getAdresseEntreprise());?>" id="adrEntr_id" required></p>
                <p><label for="villeEntr_id"> Ville </label>
                    <input type="text" name="villeEntr" value="<?= htmlspecialchars($villeEntr->getNomVille());?>" id="villeEntr_id" required>
                <p><label for="cpEntr_id">Code postal </label>
                    <input type="text" name="codePostalEntr" value="<?= $villeEntr->getCodePostal();?>" id="cpEntr_id" required></p>
                <?php
                $dateDebut = $offre->getDateDebut();
                $dateFin = $offre->getDateFin();
                echo '<p><label for="debut_id"> Alternance : Date début </label>
                    <input type="date" name="dateDebut" value="'.$dateDebut.'" id="debut_id" required>
                    <label for="fin_id"> Date fin </label>
                    <input type="date" name="dateFin" value="'.$dateFin.'" id="fin_id" required></p>
                <p>'
                ?>
                    <label class="labelFormulaire" for="objStage_id">Programme de formation : </label>
                <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="objfOffre" id="objStage_id"
                              required maxlength="255"><?php echo $offre->getObjectifOffre() ?></textarea>
                </div>
                </p>



                <input type="hidden" value="<?= date("d-m-Y"); ?>" name="dateCreation">
                <input type="submit" value="Envoyer"
                       formaction="?action=creerConvention&controleur=EtuMain">
            </fieldset>
        </form>
    </div>
</div>
