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
            echo $codeRecherche
            ?>
            <div class="filtresRech">

            </div>

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
                $privilege = ConnexionUtilisateur::getUtilisateurConnecte()->getRecherche();
                foreach ($privilege as $name) {
                    $name2 = ucfirst($name) . "s";
                    echo '<div>
                    <h4 class="titre">' . $name2 . '</h4>
                    <span>
                        <label for="' . $name . '"></label><input class="switch" type="checkbox" name="' . $name . '"
                                                               id="' . $name . '" value="on" onchange="this.form.submit()"';
                    if (isset($_REQUEST[$name])) {
                        echo 'checked';
                    }
                    echo '>
                    </span>
                </div>';
                }
                ?>

                <div class="filtresDetail">
                    <?php
                    //si l'utilisateur est un admin, et qu'il a sélectionné uniquement les entreprises
                    if (isset($_REQUEST['entreprise']) && !isset($_REQUEST['etudiants']) && !isset($_REQUEST['offres']) && !isset($_REQUEST['personnels'])) {
                        echo "entreprises sélectionnées";
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
