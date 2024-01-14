<div class="wrapComplet" id="center">

    <div class="partie1">
        <div>
            <h1>REJOIGNEZ FORMAT'IUT EN TANT QU'ENTREPRISE !</h1>
            <h3>Et profitez d'une application Web innovante pour permettre à des étudiants qualifiés de faire un bond
                vers l'avenir !</h3>
        </div>
        <img src="../ressources/images/bienvenueChezNous.png" alt="image entreprise">
    </div>

    <div class="partie2">
        <div class="sousCategorie" id="SC1">
            <div>
                <img src="../ressources/images/intuitif.png" alt="icone1">
            </div>
            <h4>Une Application Web Intuitive</h4>
            <p>Réalisez toutes vos démarches en toute simplicité</p>
        </div>

        <div class="sousCategorie" id="SC2">
            <div>
                <img src="../ressources/images/couteau-suisse.png" alt="icone1">
            </div>
            <h4>Un Service Polyvalent</h4>
            <p>Gérez vos démarches, et vos offres de stage et d'alternance au même endroit</p>
        </div>

        <div class="sousCategorie" id="SC3">
            <div>
                <img src="../ressources/images/accessible.png" alt="icone1">
            </div>
            <h4>Accessible sur tous vos appareils</h4>
            <p>Une Application Web conçue pour tous vos appareils</p>
        </div>

        <div class="sousCategorie" id="SC4">
            <div>
                <img src="../ressources/images/notification.png" alt="icone1">
            </div>
            <h4>Restez toujours au courant</h4>
            <p>Choisissez de recevoir des mails pour vous tenir informés</p>
        </div>
    </div>


    <div class="partie3">
        <div>
            <img src="../ressources/images/entrepriseConnectee.png" alt="illu">
        </div>
        <div class="textePartie3">
            <h1 class="titresParties">LA SOLUTION POUR FACILITER LE RECRUTEMENT DE STAGIAIRES ET ALTERNANTS</h1>
            <h3 class="grandTexte">Sur le même site, déposez des offres de stage et d'alternance, et choisissez les
                étudiants que vous souhaitez assigner sur vos offres</h3>
            <h3 class="grandTexte">Choisissez vous même les étudiants qui vous intéressent pour chacune de vos offres,
                ou laissez les enseignants tuteurs se charger de ce choix pour vous.</h3>
        </div>
    </div>

    <div class="partie4">
        <div class="textePartie3">
            <h1 class="titresParties">UN GAIN DE TEMPS CONSIDERABLE</h1>
            <h3 class="grandTexte">Dans tous les cas, gérez toutes les démarches sur une seule application. CV, Lettres
                de motivation, démarches administratives, échanges avec les étudiants... Tout est pensé pour vous.</h3>
        </div>
        <div>
            <img src="../ressources/images/gainDeTemps.png" alt="illu">
        </div>
    </div>


    <div class="wrapFormulaireCreationPE">
        <div class="formulaireGauchePE">
            <form action="controleurFrontal.php?controleur=Main&action=creerCompteEntreprise" method="post">
                <h1>CREEZ VOTRE COMPTE ENTREPRISE</h1>
                <?php if (isset($_REQUEST["siret"])) { ?>
                    <label>
                        <input type="number" name="siret" placeholder="SIRET de l'entreprise"
                               <?php echo "value='" . $_REQUEST["siret"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="text" name="nomEntreprise" placeholder="Nom de l'entreprise"
                               <?php echo "value='" . $_REQUEST["nomEntreprise"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="text" name="adresseEntreprise" placeholder="Adresse de l'entreprise"
                               <?php echo "value='" . $_REQUEST["adresseEntreprise"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="email" name="email" placeholder="Email de l'entreprise"
                               <?php echo "value='" . $_REQUEST["email"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="number" name="codePostal" placeholder="Code Postal"
                               <?php echo "value='" . $_REQUEST["codePostal"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="text" name="ville" placeholder="Ville"
                               <?php echo "value='" . $_REQUEST["ville"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="number" name="tel" placeholder="Téléphone"
                               <?php echo "value='" . $_REQUEST["tel"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="text" name="statutJuridique" placeholder="Statut Juridique"
                               <?php echo "value='" . $_REQUEST["statutJuridique"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="number" name="effectif" placeholder="Effectif"
                               <?php echo "value='" . $_REQUEST["effectif"] . "'" ?>required>
                    </label>
                    <label>
                        <input type="text" name="codeNAF" placeholder="Code NAF"
                               <?php echo "value='" . $_REQUEST["codeNAF"] . "'" ?>required>
                    </label>

                <?php } else { ?>
                    <label>
                        <input type="number" name="siret" placeholder="SIRET de l'entreprise" required>
                    </label>
                    <label>
                        <input type="text" name="nomEntreprise" placeholder="Nom de l'entreprise" required>
                    </label>
                    <label>
                        <input type="text" name="adresseEntreprise" placeholder="Adresse de l'entreprise" required>
                    </label>
                    <label>
                        <input type="email" name="email" placeholder="Email de l'entreprise" required>
                    </label>
                    <label>
                        <input type="number" name="codePostal" placeholder="Code Postal" required>
                    </label>
                    <label>
                        <input type="text" name="ville" placeholder="Ville" required>
                    </label>
                    <label>
                        <input type="number" name="tel" placeholder="Téléphone" required>
                    </label>
                    <label>
                        <input type="text" name="statutJuridique" placeholder="Statut Juridique" required>
                    </label>
                    <label>
                        <input type="number" name="effectif" placeholder="Effectif" required>
                    </label>
                    <label>
                        <input type="text" name="codeNAF" placeholder="Code NAF" required>
                    </label>

                <?php } ?>
                <label>
                    <input type="password" name="mdp" placeholder="Mot de passe" required>
                </label>
                <label>
                    <input type="password" name="mdpConf" placeholder="Confirmer le mot de passe" required>
                </label>
                <div>
                    <label for="cgu-id"></label><input type="checkbox" name="cgu" required id="cgu-id">
                    <h4 class="titre">Veuillez accepter les <a target="_blank" class="lien"
                                                               href="../ressources/CGU/CGU-Format'IUT.pdf">CGU</a>
                    </h4>
                </div>
                <input type="submit" class="valider" value="NOUS REJOINDRE">

            </form>
        </div>

        <div class="partieDroitePE">
            <img src="../ressources/images/formulairePE.png" alt="image formulaire">
            <h2>MERCI DE REJOINDRE FORMAT'IUT !</h2>
        </div>
    </div>
</div>
<?php require __DIR__ . "/../CGU.php"; ?>
