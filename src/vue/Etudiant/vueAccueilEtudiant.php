<div class="conteneurPrincipal" id="conteneurPrincipal">
    <div class="conteneurBienvenue">
        <div class="texteBienvenue">
            <h3>Bonjour, <?php
                $etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
                echo $etudiant->getPrenomEtudiant();
                ?></h3>

            <p>Voici les dernières nouveautés en offres de stage et d'alternance :</p>
        </div>

        <div class="imageBienvenue">
            <img src="../ressources/images/bienvenueRemoved.png" alt="image de bienvenue" class="imageMoyenne">
        </div>
    </div>

    <div class="notifications">
        <h4>Vos Notifications :</h4>
        <!-- affichage d'une erreur pour dire qu'il n'y a pas de notifications -->
        <div class="wrapErreur">
            <img src="../ressources/images/erreur.png" alt="image d'erreur" class="imageErreur">
            <h4>Aucune notification pour le moment.</h4>
        </div>
    </div>

    <div class="nouveautesWrap">
        <div class="nouveautesStages">
            <h4>Nouveautés Stages de la semaine :</h4>
            <div class="conteneurAnnonces">
                <?php /**
                 * @param $listeStage
                 * @return array
                 */
                function extracted($listeStage): array
                {
                    $entreprise = null;
                    $lien = null;
                    for ($i = 0; $i < sizeof($listeStage); $i++) {
                        if ($listeStage[$i]->getEstValide()) {
                            $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($listeStage[$i]->getIdEntreprise());
                            $ville = (new \App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
                            $lien = "?controleur=EtuMain&action=afficherVueDetailOffre&idFormation=" . $listeStage[$i]->getIdFormation();
                            echo '<a href ="' . $lien . '">
                    <div class="imagesAnnonce" >';
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '" alt="pp entreprise">
                    </div>
                    <div class="texteAnnonce" >
                        <h4 >';
                            echo $entreprise->getNomEntreprise();
                            echo ' </h4 >
                        <div class="detailsAnnonce" >
                            <div class="lieuRemun" >
                                <div class="lieuAnnonce" >
                                    <img src = "../ressources/images/emplacement.png" alt = "image" class="imagesPuces" >
                                    <p class="petitTexte" >';
                            echo $ville->getNomVille();
                            echo ' </p >
                                </div >
                                <div class="remunAnnonce" >
                                    <img src = "../ressources/images/euros.png" alt = "image" class="imagesPuces" >
                                    <p class="petitTexte" >';
                            echo $listeStage[$i]->getGratification();
                            echo ' €/ mois</p >
                                </div >
                            </div >
                            <div class="dureeLibelle" >
                                <div class="dureeAnnonce" >
                                    <img src = "../ressources/images/histoire.png" alt = "image" class="imagesPuces" >
                                    <p class="petitTexte" >';
                            echo (new DateTime($listeStage[$i]->getDateDebut()))->diff(new DateTime($listeStage[$i]->getDateFin()))->format('%m mois');

                            echo '</p >
                                </div >
                                <div class="libelleAnnonce" >
                                    <img src = "../ressources/images/emploi.png" alt = "image" class="imagesPuces" >
                                    <p class="petitTexte" >';
                            $nomHTML = htmlspecialchars($listeStage[$i]->getNomOffre());
                            echo $nomHTML;
                            echo '</p >
                                </div >
                            </div >
                        </div >
                    </div >
                </a >';
                        }
                    }
                    return array($i, $entreprise, $lien);
                }

                if (empty($listeStage)) {
                    echo "Vide";
                } else list($i, $entreprise, $lien) = extracted($listeStage);
                ?>

            </div>
        </div>
        <div class="nouveautesAltern">
            <h4>Nouveautés Alternances de la semaine :</h4>
            <div class="conteneurAnnonces">
                <?php if (empty($listeAlternance)) {
                    echo "Vide";
                } else list($i, $entreprise, $lien) = extracted($listeAlternance);
                ?>
            </div>
        </div>

    </div>
</div>

<!-- apeller cette fonction pour afficher le popup : afficherPopupPremiereCo(0) -->
<div class="premiereCo" id="popupPremiereCo">

    <div id="0" class="enfant">
        <div class="imagePremiereCo">
            <img src="../ressources/images/0.png" alt="image">
            <h2>COMPLETEZ VOTRE PROFIL AVANT DE COMMENCER</h2>
        </div>
        <div class="contenuPremiereCo">
            <h3>Pour avoir plus de visibilité pour les entreprises</h3>
            <p>En quelques clics, complétez votre profil, puis démarrez l'aventure Format'IUT !</p>

            <div class="wrapBoutons">
                <a href="?action=seDeconnecter">RETOUR</a>
                <a onclick="afficherPopupPremiereCo(1)">SUIVANT</a>
            </div>
        </div>
    </div>

    <div id="1" class="enfant">
        <div class="imagePremiereCo">
            <img src="../ressources/images/mesInfos.jpg" alt="image">
            <h2>MES INFORMATIONS</h2>
        </div>
        <div class="contenuPremiereCo">
            <form method="post" action="../web/controleurEtuMain.php" onsubmit="afficherPopupPremiereCo(2)">
                <label for="numEtu">Numéro étudiant :
                    <input type="number" name="numEtu" placeholder="11102117" required>
                </label>


                <label for="sexe">Sexe :
                    <select name="sexe" required>
                        <option value="M">Homme</option>
                        <option value="F">Femme</option>
                        <option value="X">Je préfère ne pas répondre</option>
                    </select>
                </label>
                <?php
                $ancienNumEtu = $etudiant->getNumEtudiant();
                ?>

                <div class="wrapBoutons">
                    <a onclick="afficherPopupPremiereCo(0)">RETOUR</a>
                    <input type="hidden" name="oldNumEtu" value="<?php echo $ancienNumEtu ?>">
                    <input type="hidden" name="controleur" value="EtuMain">
                    <input type="submit" value="SUIVANT" formaction="?action=setnumEtuSexe">
                </div>
            </form>
        </div>
    </div>

    <div id="2" class="enfant">
        <div class="imagePremiereCo">
            <img src="../ressources/images/mesContacts.jpg" alt="image">
            <h2>MES CONTACTS</h2>
        </div>
        <div class="contenuPremiereCo">
            <form method="post" action="../web/controleurEtuMain.php" onsubmit="afficherPopupPremiereCo(3)">
                <label for="telephone">Téléphone :
                    <input type="number" name="telephone" placeholder="0670809010">
                </label>

                <label for="telephone">Mail personnel :
                    <input type="email" name="mailPerso" placeholder="exemple@exemple.ex">
                </label>

                <?php
                $numEtu = $etudiant->getNumEtudiant();
                ?>

                <div class="wrapBoutons">
                    <a onclick="afficherPopupPremiereCo(1)">RETOUR</a>
                    <input type="hidden" name="numEtu" value="<?php echo $numEtu ?>">
                    <input type="hidden" name="controleur" value="EtuMain">
                    <input type="submit" value="SUIVANT" formaction="?action=setTelMailPerso">
                </div>
            </form>
        </div>
    </div>

    <div class="enfant" id="3">
        <div class="imagePremiereCo">
            <img src="../ressources/images/maFormation.jpg" alt="image">
            <h2>MA FORMATION</h2>
        </div>
        <div class="contenuPremiereCo">
            <form method="post" action="../web/controleurEtuMain.php" onsubmit="afficherPopupPremiereCo(4)">
                <label for="groupe">Groupe de TD :
                    <input type="text" name="groupe" placeholder="Q1" required>
                </label>

                <label for="parcours">Parcours :
                    <input type="text" name="parcours" placeholder="RACDV" required>
                </label>

                <div class="wrapBoutons">
                    <a onclick="afficherPopupPremiereCo(2)">RETOUR</a>
                    <input type="hidden" name="numEtu" value="<?php echo $numEtu ?>">
                    <input type="hidden" name="controleur" value="EtuMain">
                    <input type="submit" value="SUIVANT" formaction="?action=setGroupeParcours">
                </div>
            </form>
        </div>
    </div>

    <div class="enfant" id="4">
        <div class="imagePremiereCo">
            <img src="../ressources/images/maFormation.jpg" alt="image">
            <h2>MA PHOTO DE PROFIL (FACULTATIF)</h2>
        </div>
        <div class="contenuPremiereCo">
            <form enctype="multipart/form-data" action="?action=updateImage&controleur=EtuMain" method="post">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                <input type="file" name="fic" size=500/>

                <h4>Cliquez sur "Terminer" pour enregistrer vos informations et commencer l'aventure Format'IUT !</h4>

                <div class="wrapBoutons">
                    <a onclick="afficherPopupPremiereCo(3)">RETOUR</a>
                    <input type="hidden" name="numEtu" value="<?php echo $numEtu ?>">
                    <input type="hidden" name="estPremiereCo" value="true">
                    <input type="submit" value="TERMINER" onclick="fermerPopupPremiereCo()"/>
                </div>
            </form>
        </div>
    </div>


</div>

