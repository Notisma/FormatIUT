<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;

$etudiant = (new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getNumEtudiantConnecte());

$type = $_REQUEST["type"] ?? "all";

?>

<div class="mainCatalogue">

    <div class="descCatalogue">
        <img src="../ressources/images/vueCatalogueEtu.png" alt="image de bienvenue">
        <h3 class="titre">Catalogue des Offres</h3>
        <h4 class="titre">Retrouvez ici toutes les offres de stage et d'alternance disponibles sur Format'IUT !</h4>
    </div>

    <div class="wrapMosaique">
        <h2 class="titre" id="rouge">Liste des offres de Stage et d'Alternance :</h2>

        <div class="mosaique">
            <?php
            $data = (new FormationRepository())->getListeIDFormationsPourEtudiant($type, $etudiant);

            for ($i = 0; $i < count($data); $i++) {
                $offre = $data[$i];
                $offre = (new \App\FormatIUT\Modele\Repository\FormationRepository())->getObjectParClePrimaire($offre);
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
           <div><img src="../ressources/images/equipe.png" alt="candidats"> <h4 class="titre">';

                $nb = (new EtudiantRepository())->nbPostulations($offre->getidFormation());
                if ($nb == 0) {
                    echo "Aucun";
                } else {
                    echo $nb;
                }

                echo " candidat";
                if ($nb > 1) {
                    echo "s";
                } echo
                '</h4> </div>
            </div>
            </a>';
            }

            ?>
        </div>

    </div>

</div>
