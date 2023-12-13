<?php

use App\FormatIUT\Configuration\Configuration;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());

?>

<div class="mainAcc">

    <div class="gaucheAcc">
        <h3 class="titre" id="rouge">Les Dernières Offres sorties :</h3>
        <?php
        $data = $listeStage;
        $data = array_merge($data, $listeAlternance);

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
           <h3 class="titre" id="rouge">' . $entreprise->getNomEntreprise() . '</h3>
           <h4 class="titre">' . $offre->getNomOffre() . '</h4>
           <h4 class="titre">' . $offre->getTypeOffre() . '</h4>
           <h5 class="titre">' . $offre->getSujet() . '</h5>
           
            </div>
            </a>';
        }
        echo '</div>';
        ?>
    </div>

    <div class="droiteAcc">

        <img src="../ressources/images/bienvenueRemoved.png" alt="image de bienvenue">
        <h2 class="titre">Bonjour, <?php echo $etudiant->getPrenomEtudiant() . " !" ?></h2>

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
            <div class="erreur">
                <img src="../ressources/images/erreur.png" alt="erreur">
                <h4 class="titre">Vous n'avez aucune notification</h4>
            </div>
        </div>

    </div>

</div>


