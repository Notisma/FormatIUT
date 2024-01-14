<div class="wrapCentreDetailEntr">
    <?php
    /** @var Entreprise $entreprise */

    use App\FormatIUT\Lib\ConnexionUtilisateur;
    use App\FormatIUT\Modele\DataObject\Entreprise;

    $nomEntrHTML = htmlspecialchars($entreprise->getNomEntreprise());
    $adresseHTML = htmlspecialchars($entreprise->getAdresseEntreprise());
    $statutHTML = htmlspecialchars($entreprise->getStatutJuridique());
    $nafHTML = htmlspecialchars($entreprise->getCodeNAF());
    $telHTML = htmlspecialchars($entreprise->getTel());
    $mailHTML = htmlspecialchars($entreprise->getEmail());
    ?>

    <div class="gaucheEntr">
        <div class="wrapImgEntr">
            <img src="<?= App\FormatIUT\Configuration\Configuration::getUploadPathFromId($entreprise->getImg()) ?>"
                 alt="entreprise">
            <h2 class="titre rouge"><?php echo $nomEntrHTML ?></h2>
        </div>

        <div class="wrapInfosEntr">
            <h3 class="titre">Informations :</h3>
            <p>- SIRET : <?php echo $entreprise->getSiret() ?></p>
            <p>- Adresse : <?php echo $adresseHTML ?></p>
            <p>- Ville : <?php echo $entreprise->getIdVille() ?></p>
            <p>- Statut Juridique : <?php echo $statutHTML ?></p>
            <p>- Effectif : <?php echo $entreprise->getEffectif() ?></p>
            <p>- Code NAF : <?php echo $nafHTML ?></p>
            <p>- Téléphone : <?php echo $telHTML ?></p>
            <p>- Adresse Mail : <?php echo $mailHTML ?></p>
        </div>

        <div class="wrapBoutons">
            <?php
            if (ConnexionUtilisateur::getTypeConnecte() == "Administrateurs") {
                if ($entreprise->isEstValide()) {
                    echo '<a href="?action=supprimerEntreprise&controleur=AdminMain&siret=' . $entreprise->getSiret() . '">SUPPRIMER</a>';
                    echo '<a href="?action=afficherFormulaireModifEntreprise&controleur=AdminMain&siret=' . $entreprise->getSiret() . '">MODIFIER</a>';
                } else {
                    echo '<a href="?action=refuserEntreprise&controleur=AdminMain&siret=' . $entreprise->getSiret() . '">REFUSER</a>';
                    echo '<a id="vert" href="?action=validerEntreprise&controleur=AdminMain&siret=' . $entreprise->getSiret() . '">ACCEPTER</a>';
                }
            }
            ?>
        </div>
    </div>

    <div class="droiteEntr">
        <?php
        //on affiche le nombre d'offres de l'entreprise
        $listeOffres = (new App\FormatIUT\Modele\Repository\FormationRepository())->offresPourEntreprise($entreprise->getSiret());
        $count = sizeof($listeOffres);
        ?>

        <h3 class="titre">Cette entreprise possède <?php echo $count ?> Offre(s) :</h3>

        <div class="wrapAllOffres">
            <?php
            if (sizeof($listeOffres) < 1) {
                echo "<div class='erreur'>";
                echo "<img src='../ressources/images/erreur.png' alt='entreprise'>";
                echo "<h3 class='titre'>Aucune offre n'a été trouvée pour cette entreprise</h3>";
                echo "</div>";
            } else {
                foreach ($listeOffres as $offre) {
                    if ($offre != null) {
                        $nomOffreHTML = htmlspecialchars($offre->getNomOffre());
                        echo "<a class='offre' href='?action=afficherVueDetailOffre&controleur=AdminMain&idFormation=" . $offre->getIdFormation() . "'>" .
                            "<div class='imgOffre'>" .
                            "<img src='" . App\FormatIUT\Configuration\Configuration::getUploadPathFromId($entreprise->getImg()) . "' alt='offre'>" .
                            "</div>" .
                            "<div class='infosOffre'>" .
                            "<h3 class='titre'>" . $nomOffreHTML . " - " . $offre->getTypeOffre() . "</h3>" .
                            "<h4 class='titre'>" . $nomEntrHTML . "</h4>";

                        if ($offre->getEstValide()) {
                            echo '<div class="statut valide"> <img src="../ressources/images/success.png" alt="sab"> <p>Offre Postée</p> </div>';
                        } else {
                            echo '<div class="statut attente"> <img src="../ressources/images/sablier.png" alt="sab"> <p>En attente de validation</p> </div>';
                        }

                        echo
                            "</div>" .
                            "</a>";
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="annotations">
    <div class="interaction" onclick="toggleExpand()">
        <img src="../ressources/images/gauche.png" alt="">
    </div>
    <div class="wrapAnnotations">
        <h3 class="titre rouge">Annotations des Enseignants</h3>
        <?php
        $listeAnnotations = (new \App\FormatIUT\Modele\Repository\AnnotationRepository())->annotationsParEntreprise($entreprise->getSiret());
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

        <?php

        if (!(new \App\FormatIUT\Modele\Repository\AnnotationRepository())->aDeposeAnnotation($entreprise->getSiret(), ConnexionUtilisateur::getLoginUtilisateurConnecte())) {
            echo '     

        <div class="rediger">
            <h4 class="titre">Rédiger Mon Commentaire</h4>
            <form action="?action=ajouterAnnotation&controleur=AdminMain" method="post">
                <input type="hidden" name="idEntreprise" value="' . $entreprise->getSiret() . '">
                <input type="hidden" name="loginProf"
                       value="' . ConnexionUtilisateur::getLoginUtilisateurConnecte() . '">
                <input type="hidden" name="dateAnnotation" value="' . date("d/m/Y") . '">

                <h5 class="titre">Note /5 :</h5>
                <label for="stars"></label>
                <input type="number" id="stars" max="5" min="0" name="noteAnnotation" required>

                <h5 class="titre">Commentaire :</h5>
                <label for="comm"></label><textarea name="messageAnnotation" id="comm" maxlength="255" required></textarea>

                <input type="submit" value="Envoyer">
            </form>
        </div>
            ';
        }
        ?>

    </div>
</div>
