<div class="wrapCentreDetailEntr">
    <?php
    $entreprise = (new App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["idEntreprise"]);
    $nomEntrHTML=htmlspecialchars($entreprise->getNomEntreprise());
    $adresseHTML=htmlspecialchars($entreprise->getAdresseEntreprise());
    $statutHTML=htmlspecialchars($entreprise->getStatutJuridique());
    $nafHTML=htmlspecialchars($entreprise->getCodeNAF());
    $telHTML=htmlspecialchars($entreprise->getTel());
    $mailHTML=htmlspecialchars($entreprise->getEmail());
    ?>

    <div class="gaucheEntr">
        <div class="wrapImgEntr">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($entreprise->getImg()) ?>" alt="entreprise">
            <h2 class="titre" id="rouge"><?php echo $nomEntrHTML ?></h2>
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
            if (\App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()=="Administrateurs") {
                if ($entreprise->isEstValide()) {
                    echo '<a href="?action=supprimerEntreprise&controleur=AdminMain&siret=<?php echo $entreprise->getSiret() ?>">SUPPRIMER</a>';
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
                        $nomOffreHTML=htmlspecialchars($offre->getNomOffre());
                        echo "<a class='offre' href='?action=afficherVueDetailOffre&controleur=AdminMain&idFormation=" . $offre->getIdFormation() . "'>" .
                            "<div class='imgOffre'>" .
                            "<img src='data:image/jpeg;base64," . base64_encode($entreprise->getImg()) . "' alt='offre'>" .
                            "</div>" .
                            "<div class='infosOffre'>" .
                            "<h3 class='titre'>" . $nomOffreHTML . " - " . $offre->getTypeOffre() . "</h3>" .
                            "<h4 class='titre'>" . $nomEntrHTML . "</h4>";

                        if ($offre->getEstValide()) {
                            echo '<div class="statut" id="valide"> <img src="../ressources/images/success.png" alt="sab"> <p>Offre Postée</p> </div>';
                        } else {
                            echo '<div class="statut" id="attente"> <img src="../ressources/images/sablier.png" alt="sab"> <p>En attente de validation</p> </div>';
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
