<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;
use App\FormatIUT\Lib\PrivilegesUtilisateursRecherche;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;

if (!isset($_REQUEST['triPar'])) {
    $_REQUEST['triPar'] = 'type';
}

?>

<div class="mainRecherche">

    <div class="bodyRecherche">

        <div class="controleRech">
            <h2 class="titre rouge">Effectuez une recherche sur Format'IUT</h2>
            <?php
            echo $codeRecherche;
            ?>

            <div class="trierPar">
                <h4 class="titre">Trier Par :</h4>

                <?php
                $url = $_REQUEST['recherche'];

                ?>

                <form method="get" id="formTrierPar">
                    <select name="triPar" onchange="this.form.submit()">
                        <option value="type">Type</option>
                        <option value="date">Date</option>
                        <option value="asc">Ordre Alphabétique</option>
                    </select>
                    <input type="hidden" name="service" value="Recherche">
                    <input type="hidden" name="action" value="rechercher">
                    <input type="hidden" name="recherche" value="<?php echo $url ?>">
                </form>
            </div>

        </div>

        <div class="resultatsRecherche">
            <?php
            if (!empty($liste)) {

                foreach ($liste as $type => $elements) {
                    for ($i = 0; $i < count($elements); $i++) {
                        $red = "";
                        $n = 2;
                        $row = intdiv($i, $n);
                        $col = $i % $n;
                        if (($row + $col) % 2 != 0) {
                            $red = "demi";
                        }

                        if ($type == 'Etudiant') {
                            $etudiant = (new EtudiantRepository())->getObjectParClePrimaire($elements[$i]->getNumEtudiant());
                            echo '<a class="element ' . $red . '" href="?action=afficherDetailEtudiant&controleur=' . Configuration::getControleurName() . '&numEtu=' . $etudiant->getNumEtudiant() . '">
                            <img src="' . Configuration::getUploadPathFromId($etudiant->getImg()) . '" alt="pp etudiant">
                            <div>
                                <h3 class="titre rouge">' . htmlspecialchars($etudiant->getPrenomEtudiant()) . ' ' . htmlspecialchars($etudiant->getNomEtudiant()) . '</h3>
                                <h4 class="titre">' . htmlspecialchars($etudiant->getParcours()) . '</h4>
                                <h4 class="titre">' . htmlspecialchars($etudiant->getGroupe()) . '</h4>
                                <h5 class="titre">' . htmlspecialchars($etudiant->getMailUniersitaire()) . '</h5>';
                            if (Configuration::getControleurName() == 'AdminMain') {
                                if ((new App\FormatIUT\Modele\Repository\EtudiantRepository)->aUneFormation($etudiant->getNumEtudiant())) {
                                    echo "<div class='statutEtu valide'><img src='../ressources/images/success.png' alt='valide'><p>A une formation validée</p></div>";
                                } else {
                                    echo "<div class='statutEtu nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Aucun stage/alternance</p></div>";
                                }
                            }
                            echo '</div>


                            </a>';

                        } elseif ($type == 'Formation') {
                            $formation = (new FormationRepository())->getObjectParClePrimaire($elements[$i]->getIdFormation());
                            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($formation->getIdEntreprise());
                            echo '<a class="element ' . $red . '" href="?action=afficherVueDetailOffre&controleur=' . Configuration::getControleurName() . '&idFormation=' . $formation->getIdFormation() . '">
                            <img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">
                            <div>
                                <h3 class="titre rouge">' . htmlspecialchars($formation->getNomOffre()) . '</h3>
                                <h4 class="titre">' . htmlspecialchars($entreprise->getNomEntreprise()) . '</h4>
                                <h4 class="titre">' . htmlspecialchars($formation->getTypeOffre()) . ' - '; if (Configuration::getControleurName() == "AdminMain") { if ($formation->getEstValide()) {echo 'VALIDÉE';} else {echo 'NON VALIDÉE';}}  echo'</h4>
                                <h5 class="titre">' . htmlspecialchars($formation->getSujet()) . '</h5>
                                <div><img src="../ressources/images/equipe.png" alt="candidats"> <h4 class="titre">';
                            if (!$formation->estAssignee()) {
                                $nb = (new EtudiantRepository())->nbPostulations($formation->getidFormation());
                                if ($nb == 0) {
                                    echo "Aucun";
                                } else {
                                    echo $nb;
                                }
                                echo " candidat";
                                if ($nb > 1) {
                                    echo "s";
                                }
                            } else {
                                echo "Assignée";
                            }
                            echo
                            '</h4> </div>
                            </div>  
                               </a>';
                        } elseif ($type == 'Entreprise') {
                            $entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($elements[$i]->getSiret());
                            $countValide = count((new App\FormatIUT\Modele\Repository\EntrepriseRepository)->getOffresValidesDeEntreprise($entreprise->getSiret()));
                            $countNonValide = count((new App\FormatIUT\Modele\Repository\EntrepriseRepository)->getOffresNonValidesDeEntreprise($entreprise->getSiret()));
                            echo '<a class="element ' . $red . '" href="?action=afficherDetailEntreprise&controleur=' . Configuration::getControleurName() . '&siret=' . $entreprise->getSiret() . '">
                            <img src="' . Configuration::getUploadPathFromId($entreprise->getImg()) . '" alt="pp entreprise">
                            <div>
                                <h3 class="titre rouge">' . htmlspecialchars($entreprise->getNomEntreprise()) . '</h3>
                                <h4 class="titre">' . htmlspecialchars($entreprise->getAdresseEntreprise()) . ', '. htmlspecialchars((new \App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille())->getNomVille()) .'</h4>
                                <h5 class="titre">' . htmlspecialchars($entreprise->getEmail()) . '</h5>';
                               if (Configuration::getControleurName() == 'AdminMain') {
                                   echo '<h5 class="titre">' . $countNonValide . ' offres non validées et ' . $countValide . ' offres validées.</h5>';
                                   if ($entreprise->isEstValide()) {
                                       echo "<div class='statutEtu valide'><img src='../ressources/images/success.png' alt='valide'><p>Compte validé</p></div>";
                                   } else {
                                       echo "<div class='statutEtu nonValide'><img src='../ressources/images/warning.png' alt='valide'><p>Compte non validé</p></div>";
                                   }
                               }
                            echo '</div>
                            </a>';
                        } elseif ($type == 'Prof') {
                            $prof = (new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire($elements[$i]->getLoginProf());
                        }
                    }
                }
            }

            ?>
        </div>

    </div>

    <div class="parametresRecherche">

        <div class="vitrine">
            <img src="../ressources/images/recherchez.png" alt="">
            <h3 class="titre rouge">Paramètres de Recherche</h3>
        </div>

        <div class="allOptions">
            <form method="get" id="options">


                <?php
                $privilege = ConnexionUtilisateur::getUtilisateurConnecte()->getFiltresRecherche();
                foreach ($privilege as $name => $filtres) {
                    $name2 = ucfirst($name) . "s";
                    echo '<div class="generique">
                    <h4 class="titre">' . $name2 . '</h4>
                    <span>
                        <label for="' . $name2 . '"></label><input class="switch" type="checkbox" name="' . $name2 . '"
                                                               id="' . $name2 . '" value="on" onchange="this.form.submit()"';
                    if (isset($_REQUEST[$name2])) {
                        echo 'checked';
                    }
                    echo '>
                    </span>
                </div>';
                }
                ?>

                <div class="filtresDetail">
                    <?php
                    $liste = ConnexionUtilisateur::getUtilisateurConnecte()->getFiltresRecherche();

                    foreach ($liste as $recherchables => $filtres) {
                        if (isset($_REQUEST[$recherchables . "s"])) {
                            ;
                            foreach ($filtres as $filtre) {

                                echo '
                                <span class="filtre">
                                    <label for="' . $filtre['value'] . '">' . ucfirst($filtre["label"]) . '</label>
                                    <input class="filter" type="checkbox" name="' . $filtre['value'] . '" id="' . $filtre['value'] . '" value="' . $filtre['value'] . '" onchange="this.form.submit()" ';
                                if (isset($_REQUEST[$filtre["value"]])) {
                                    echo 'checked';
                                }
                                echo '>
                                </span>
                                ';
                            }
                        }
                    }

                    ?>
                </div>

                <input type="hidden" name="controleur" value="<?php echo Configuration::getControleurName() ?>">
                <input type="hidden" name="action" value="rechercher">
                <input type="hidden" name="recherche" value="<?php echo $url ?>">
            </form>
        </div>
    </div>

</div>
