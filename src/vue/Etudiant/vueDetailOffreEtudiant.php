<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\DataObject\Formation;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());
/** @var Formation $offre */
$offre = (new \App\FormatIUT\Modele\Repository\FormationRepository())->getObjectParClePrimaire($_GET['idFormation']);
$entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
?>

<div class="detailOffreEtu">

    <div class="detailsOffre">

        <div class="entreprise">
            <img src="<?= Configuration::getUploadPathFromId($entreprise->getImg()); ?>" alt="entreprise">
            <h2 class="titre rouge"><?php echo htmlspecialchars($entreprise->getNomEntreprise()) ?></h2>
            <h3 class="titre"><?php echo htmlspecialchars($entreprise->getAdresseEntreprise()) ?>,
                <?php echo htmlspecialchars((new App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille())->getNomVille()) ?></h3>
        </div>

        <div class="offre">
            <h2 class="titre rouge">Description de l'offre :</h2>
            <h3 class="titre"><?php echo htmlspecialchars($offre->getNomOffre()) ?>
                : <?= htmlspecialchars($offre->getSujet()) ?>
                - <?= htmlspecialchars($offre->getTypeOffre()) ?></h3>
            <h4 class="titre"><?php echo "Du " . htmlspecialchars($offre->getDateDebut()) . " au " . htmlspecialchars($offre->getDateFin()) ?></h4>
            <h4 class="titre">Rémunération : <?= $offre->getGratification() ?>€ par mois</h4>
            <h4 class="titre">Durée en heures : <?= $offre->getDureeHeure() ?> heures au total</h4>
            <h4 class="titre">Nombre de jours par semaines : <?= $offre->getJoursParSemaine() ?> jours</h4>
            <h4 class="titre">Nombre d'Heures hebdomadaires : <?= $offre->getNbHeuresHebdo() ?> heures</h4>
            <h5 class="titre">Détails de l'offre : <?php $detailHTML = htmlspecialchars($offre->getDetailProjet());
                echo $detailHTML ?>
            </h5>
        </div>

    </div>

    <div class="actionsOffre">
        <div class="first">
            <img src="../ressources/images/entrepriseOffre.png" alt="details">
            <h3 class="titre">Détails d'une Offre</h3>
        </div>

        <div class="astucesDetails">
            <img src="../ressources/images/astuces.png" alt="astuces">
            <div class="contenuAstuce">
                <h4 class="titre rouge">Astuces</h4>
                <h5 class="titre">
                    Visualisez les informations propres à une offre sur une seule page !
                </h5>
                <h5 class="titre">Pratique : consultez le nombre de candidats et postulez en un seul click !</h5>
            </div>
        </div>

        <div class="wrapActionsCandidat">

            <div class="candidature">
                <img src="../ressources/images/equipe.png" alt="equipe">
                <?php
                $bool = false;
                $formation = (new \App\FormatIUT\Modele\Repository\FormationRepository())->estFormation($offre->getIdFormation());
                if ($formation) {
                    if ($formation->getIdEtudiant() == \App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant()) {
                        echo "
                <h4 class='titre'>Vous avez l'offre</h4>";
                    } else {
                        echo "
                <h4 class='titre'>L'offre est déjà occupée </h4>";
                    }
                } else {
                    $listeEtu = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->EtudiantsEnAttente($offre->getIdFormation()));
                    $nb = (new \App\FormatIUT\Modele\Repository\PostulerRepository())->getNbCandidatsPourOffre($offre->getIdFormation());
                    if ($nb == 0) {
                        echo "
                <h4 class='titre'>Personne n'a postulé. Faites Vite !</h4>
               
                ";
                    } else {

                        //si c'est l'étudiant qui a postulé
                        if (in_array($etudiant, $listeEtu)) {
                            echo " <h4 class='titre'>Vous avez postulé à cette offre</h4>";
                            $bool = true;
                        } else {

                            echo "
               
            
                                <h4 class='titre'>";
                            $nbEtudiants = (new \App\FormatIUT\Modele\Repository\PostulerRepository())->getNbCandidatsPourOffre($offre->getIdFormation());
                            echo $nbEtudiants . " étudiant";
                            if ($nbEtudiants == 1) echo " a";
                            else echo "s ont";
                            echo " déjà postulé.</h4>
                    ";
                        }

                    }
                }


                ?>
            </div>

            <div class="boutonCandidater">
                <?php
                $listeAVerifier = ((new \App\FormatIUT\Modele\Repository\FormationRepository())->offresPourEtudiant($etudiant->getNumEtudiant()));
                if ($bool) {
                    echo "<a id='desac' class='boutonAssigner'>Vous avez déjà postulé</a>";
                } else {
                    if (empty($listeAVerifier) || !in_array($offre, $listeAVerifier)) {
                        if ((new App\FormatIUT\Modele\Repository\EtudiantRepository)->aUneFormation($etudiant->getNumEtudiant())) {
                            if ($offre->getIdEtudiant() == $etudiant->getNumEtudiant()) {
                                echo "<a id='desac' class='boutonAssigner'>Vous avez cette formation</a>";
                            } else {
                                echo "<a id='desac' class='boutonAssigner'>Vous avez déjà une formation</a>";
                            }
                        } else {
                            echo "<a id='my-button' class='boutonAssigner' onclick='afficherPopupDepotCV_LM()'>Postuler à cette Offre</a>";
                        }
                    } else {
                        echo "<a id='my-button' class='boutonAssigner' onclick='afficherPopupModifCV_LM()'>Modifier les Fichiers</a>";
                    }
                }

                ?>

            </div>

        </div>

    </div>

</div>


<div id="popup" class="popup">
    <div class="mainPopup">
        <h2>ENVOYEZ VOS DOCUMENTS POUR POSTULER !</h2>
        <p>Les documents doivent être au format PDF</p>

        <form enctype="multipart/form-data"
              action="?action=postuler&controleur=EtuMain&idFormation=<?= $offre->getIdFormation() ?>"
              method="post">
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre CV :</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                    <input type="file" id="fd1" name="cv" onchange="updateImage(1)" accept=".pdf, .txt" size=500>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose1" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose1" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre lettre de Motivation :</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                    <input type="file" id="fd2" name="lm" onchange="updateImage(2)" accept=".pdf, .txt" size=500>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose2" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose2" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <input type="submit" value="Postuler">
        </form>

        <div class="conteneurBoutonPopup">
            <a onclick="fermerPopupDepotCV_LM()" class="boutonAssignerPopup">
                RETOUR
            </a>

        </div>
    </div>

    <div class="descPopup">
        <img src="../ressources/images/déposerCV.png" alt="image">
        <h2>DEPOSEZ VOS DOCUMENTS POUR AVOIR UN PROFIL COMPLET ET AVOIR PLUS DE CHANCES !</h2>
    </div>
</div>

<div id="popupModif" class="popup">
    <div class="mainPopup">
        <h2>MODIFIEZ VOS DOCUMENTS !</h2>
        <p>Les documents doivent être au format PDF</p>

        <form enctype="multipart/form-data"
              action="?action=modifierFichiers&controleur=EtuMain&idFormation=<?php echo $offre->getIdFormation() ?>"
              method="post">
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre CV :</label>
                    <?php
                    /*$postuler = (new PostulerRepository())->getObjectParClesPrimaires(array(ControleurEtuMain::getCleEtudiant(), $offre->getIdFormation()));
                    if($postuler->formatTableau()["cv"] != null){
                        echo "<p> Vous avez déjà déposé un CV </p>";
                    }
                    else{
                        echo "<p> Vous n'avez pas encore déposé de CV</p>";
                    }*/
                    ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                    <input type="file" id="fd3" name="cv" onchange="updateImage(3)" accept=".odt, .pdf, .txt" size=500>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose3" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose3" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <div>
                <div class="contenuDepot">
                    <label>Déposez votre lettre de Motivation :</label>
                    <?php
                    /*$postuler = (new PostulerRepository())->getObjectParClePrimaire();
                    if($postuler->formatTableau()["lettre"] != null){
                        echo "<p> Vous avez déjà déposé une lettre de motivation </p>";
                    }
                    else{
                        echo "<p> Vous n'avez pas encore déposé de lettre de motivation</p>";
                    }*/
                    ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="10000000">
                    <input type="file" id="fd4" name="lm" onchange="updateImage(4)" accept=".odt, .pdf, .txt" size=500>
                </div>
                <div class="imagesDepot">
                    <img id="imageNonDepose4" src="../ressources/images/rejete.png" alt="image">
                    <img id="imageDepose4" src="../ressources/images/verifie.png" alt="image" style="display: none;">
                </div>

            </div>
            <input type="submit" value="Modifier vos documents">
        </form>

        <div class="conteneurBoutonPopup">
            <a onclick="fermerPopupModifCV_LM()" class="boutonAssignerPopup">
                RETOUR
            </a>

        </div>
    </div>

    <div class="descPopup">
        <img src="../ressources/images/déposerCV.png" alt="image">
        <h2>DEPOSEZ VOS DOCUMENTS POUR AVOIR UN PROFIL COMPLET ET AVOIR PLUS DE CHANCES !</h2>
    </div>
</div>

<div class="annotations">
    <div class="interaction" onclick="toggleExpand()">
        <img src="../ressources/images/gauche.png" alt="">
    </div>
    <div class="wrapAnnotations">
        <h3 class="titre rouge">Annotations des Enseignants</h3>
        <?php
        $listeAnnotations = (new \App\FormatIUT\Modele\Repository\AnnotationRepository())->annotationsParEntreprise($offre->getIdEntreprise());
        ?>

        <div class="moyenne">
            <h4 class="titre">Moyenne des Commentaires</h4>
            <div>
                <?php
                if (!empty($listeAnnotations)) {
                    foreach ($listeAnnotations as $annotation) {
                        $moyenne = $annotation->getNoteAnnotation();
                    }
                    $moyenne = $moyenne / count($listeAnnotations);

                    if ($moyenne - floor($moyenne) >= 0.5) {
                        $moyenne = ceil($moyenne);
                    } else {
                        $moyenne = floor($moyenne);
                    }
                    echo "<div>";
                    for ($i = 0; $i < $moyenne; $i++) {
                        echo "<img src='../ressources/images/etoile.png' alt='etoile'>";
                    }
                    echo "</div>";
                    echo "<h4 class='titre'>" . $moyenne . "/5</h4>";
                }
                ?>
            </div>

        </div>

        <div class="autresComm">
            <h4 class="titre">Autres Commentaires</h4>
            <?php
            if (!empty($listeAnnotations)) {
                foreach ($listeAnnotations as $annotation) {
                    $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($annotation->getLoginProf());
                    echo "<div class='commentaire'>";
                    echo "<img src='../ressources/images/admin.png' alt='etoile'>";
                    echo "<div>";
                    echo "<h4 class='titre rouge'>" . $prof->getPrenomProf() . " " . $prof->getNomProf() . " - " . $annotation->getNoteAnnotation() . "/5 </h4>";
                    echo "<h5 class='titre'>" . $annotation->getMessageAnnotation() . "</h5>";
                    echo "<h5 class='titre'>Posté le " . $annotation->getDateAnnotation() . "</h5>";
                    echo "</div>";
                    echo "</div>";

                }
            } else {
                echo "<h5 class='titre'>Aucun commentaire pour le moment</h5>";
            }
            ?>
        </div>

    </div>
</div>

