<?php

/** @var Formation|null $convention */

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\DataObject\Formation;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());

?>

<div class="mainAcc">

    <div class="gaucheAcc">
        <h3 class="titre rouge">Les Dernières Offres sorties :</h3>
        <?php
        $data = $listeStage;
        //$data = array_merge($data, $listeAlternance);

        echo '<div class="grille">';
        for ($i = 0; $i < count($data); $i++) {
            $offre = $data[$i];
            $red = "";
            $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
            $n = 2;
            $row = intdiv($i, $n);
            $col = $i % $n;
            if (($row + $col) % 2 == 0) {
                $red = "demi";
            }
            echo '<a href="?controleur=EtuMain&action=afficherVueDetailOffre&idFormation=' . $offre->getIdFormation() . '" class="offre ' . $red . '">
            <img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">
           <div>
           <h3 class="titre" id="rouge">' . htmlspecialchars($entreprise->getNomEntreprise()) . '</h3>
           <h4 class="titre">' . htmlspecialchars($offre->getNomOffre()) . '</h4>
           <h4 class="titre">' . htmlspecialchars($offre->getTypeOffre()) . '</h4>
           <h5 class="titre">' . htmlspecialchars($offre->getSujet()) . '</h5>
           
            </div>
            </a>';
        }
        echo '</div>';
        ?>
    </div>

    <div class="droiteAcc">

        <img src="../ressources/images/bienvenueRemoved.png" alt="image de bienvenue">
        <h2 class="titre">Bonjour, <?php echo htmlspecialchars($etudiant->getPrenomEtudiant()) . " !" ?></h2>

        <div class="tips">
            <img src="../ressources/images/astuces.png" alt="astuces">
            <div>
                <h5 class="titre">Astuces :</h5>
                <h6 class="titre">Cliquez sur une offre pour afficher plus de détails.</h6>
                <h6 class="titre">Rendez-vous dans l'onglet dédié pour afficher plus d'offres.</h6>
            </div>
        </div>

        <h3 class="titre" id="sep">Vos Notifications :</h3>
        <div class="notifs">
            <?php

            if (isset($convention) && !is_null($convention->getDateTransmissionConvention())) {
                if ($convention->getConventionValidee()) {
                    echo "<div class='erreur'>
                            <h4 class='titre'>Votre convention a été validée, le " . $convention->getDateTransmissionConvention() . " </h4>
                          </div>
                    ";
                } else {
                    echo "<div class='erreur'>
                             <h4 class='titre'>Votre convention a été rejetée, le " . $convention->getDateTransmissionConvention() . " cliquez ci-dessous pour la modifier :</h4>
                             <div class='wrapBoutons'>
                             <a href='?action=afficherFormulaireModifierConvention'>Modifier</a>
                             </div>
                          </div>
                    ";
                }
            } else {
                echo "<div class='erreur'>
                        <img src='../ressources/images/erreur.png' alt='erreur'>
                        <h4 class='titre'>Vous n'avez aucune notification</h4>
                      </div>
                ";
            }
            ?>
        </div>
    </div>
</div>

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
                    <input type="submit" value="SUIVANT" formaction="?action=setNumEtuSexe">
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
            <form enctype="multipart/form-data" action="?action=mettreAJour&controleur=EtuMain" method="post">
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                <input type="file" name="pdp" size=500/>

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


