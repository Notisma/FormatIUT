<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffres.css">
</head>
<body>
<div id="center">

    <div class="presentation">

        <form method="post">
            <fieldset>
                <legend> Ma convention :</legend>
                <p><label for="offre_id">Votre alternance : </label>
                    <?php
                    if ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getOffreValidee($etudiant->getNumEtudiant(), "Alternance")) {
                        foreach ($listOffres as $offre) {
                            if ((new \App\FormatIUT\Modele\Repository\RegarderRepository())->getEtatEtudiantOffre($etudiant->getNumEtudiant(), $offre->getIdOffre()) == "Validée" && $offre->getTypeOffre() == "Alternance") {
                                echo '<input value="' . $offre->getNomOffre() . '" name="nomOffre" id="offre_id"  readonly required> </input>';
                                echo '<input type="hidden" value="' . $offre->getIdOffre() . '" name="idOff"> </input>';
                            }
                        }
                    } else {
                        echo '<input value="aucune" name="idOff" id="offre_id"  readonly required>';
                    } ?>

                </p>
                <p> Informations de l'étudiant :</p>
                <p><label for="num_id"> N° étudiant </label>
                    <input type="text" value="<?= $etudiant->getNumEtudiant(); ?>" name="numEtudiant" id="num_id"
                           readonly required>
                </p>
                <p><label for="nom_id"> Nom </label>
                    <input type="text" value="<?= $etudiant->getNomEtudiant(); ?>" name="nomEtudiant" id="nom_id"
                           readonly required>
                </p>
                <p><label for="prenom_id"> Nom </label>
                    <input type="text" value="<?= $etudiant->getPrenomEtudiant(); ?>" name="prenomEtudiant"
                           id="prenom_id" readonly required>
                </p>
                <p><label for="tel_id"> N° tel </label>
                    <input type="text" value="<?= $etudiant->getTelephone() ?>" name="telephone" id="tel_id" readonly
                           required></p>
                <p><label for="adr_id"> Adresse </label>
                    <input type="text" value="<?= $residence->getVoie(); ?>" name="adresseEtu" id="ard_id" readonly
                           required>
                </p>
                <p><label for="post_id"> Code postal </label>
                    <input type="number" value="<?= $residence->getLibCedex(); ?>" name="codePostalEtu" id="post_id"
                           readonly required>
                </p>
                <p><label for="ville_id"> Ville </label>
                    <input type="text" value="<?= $ville->getNomVille(); ?>" name="villeEtu" id="ville_id" readonly
                           required>
                </p>
                <p><label for="mail_id">Mail</label>
                    <input type="text" value="<?= $etudiant->getMailPerso(); ?>" name="mailEtu" id="mail_id" readonly
                           required></p>
                <p><label for="assu_id">Assurance</label>
                    <input type="text" name="assurance" id="assu_id" required></p>
                <p>Informations de l'entreprise :</p>
                <p><label for="sir_id">Siret</label>
                    <input type="number" name="siret" id="assu_id" required></p>
                <p><label for="nomEntr_id"> Nom entreprise </label>
                    <input type="text" name="nomEntreprise" id="nomEntr_id" required>
                </p>
                <p><label for="adrEntr_id">Adresse Entreprise</label>
                    <input type="text" name="adresseEntr" id="adrEntr_id" required></p>
                <p><label for="villeEntr_id"> Ville </label>
                    <input type="text" name="villeEntr" id="villeEntr_id" required>
                <p><label for="cpEntr_id">Code postal </label>
                    <input type="text" name="codePostalEntr" id="cpEntr_id" required></p>
                <p><label for="debut_id"> Alternance : Date début </label>
                    <input type="date" name="dateDebut" id="debut_id" required>
                    <label for="fin_id"> Date fin </label>
                    <input type="date" name="dateFin" id="fin_id" required></p>
                <p>
                    <label class="labelFormulaire" for="objStage_id">Programme de formation : </label>
                <div class="grandInputCentre">
                    <textarea class="inputFormulaire" name="objfOffre" id="objStage_id"
                              required maxlength="255"></textarea>
                </div>
                </p>


                <input type="hidden" value="<?= date("d-m-Y"); ?>" name="dateCreation">
                <input type="submit" value="Envoyer"
                       formaction="?action=creationConvention&controleur=EtuMain">
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>