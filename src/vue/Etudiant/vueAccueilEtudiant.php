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
            $entreprise = (new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($offre->getIdEntreprise());
            if ($i % 2 == 0) {
                echo '<tr>';
            }
            echo '<td> <a href="?controleur=EtuMain&action=afficherVueDetailOffre&idFormation='. $offre->getIdFormation() .'" class="offre">
            <img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">
           <div>
           <h3 class="titre" id="rouge">' . $entreprise->getNomEntreprise() . '</h3>
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


