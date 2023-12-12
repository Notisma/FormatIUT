<?php
use App\FormatIUT\Configuration\Configuration;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());

?>

<div class="mainAcc">

    <div class="gaucheAcc">
        <h3 class="titre" id="rouge">Les Dernières Offres sorties :</h3>
        <?php
        $data = $listeStage + $listeAlternance;

        echo '<table>';
        for ($i = 0; $i < count($data); $i++) {
            $offre = $data[$i];
            $red = "";
            $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
            if ($i % 2 == 0) {
                echo '<tr>';
                $red = "demi";
            }
            echo '<td> <a href="?controleur=EtuMain&action=afficherVueDetailOffre&idFormation='. $offre->getIdFormation() .'" class="offre '. $red .'">
            <img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">
           <div>
           <h3 class="titre" id="rouge">' . $entreprise->getNomEntreprise() . '</h3>
           <h4 class="titre">' . $offre->getNomOffre() . '</h4>
           <h4 class="titre">' . $offre->getTypeOffre() . '</h4>
           <h5 class="titre">' . $offre->getSujet() . '</h5>
           
            </div>
            </td></div>';
            if ($i % 2 == 1) {
                echo '</tr>';
            }
        }
        echo '</table>';
        ?>
    </div>

    <div class="droiteAcc">

    </div>

</div>


