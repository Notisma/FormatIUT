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
                    $name = strtolower($name);
                    $name2 = ucfirst($name) . "s";
                    echo '<div class="generique">
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
                    if (isset($_REQUEST['entreprise'])) {
                        echo '
                        <span class="filtre">
                            <label for="entreprise_validee">Validées</label>
                            <input class="filter" type="checkbox" name="filtre1" id="entreprise_validee" value="entreprise_validee" onchange="this.form.submit()" '; if (isset($_REQUEST['filtre1'])) { echo 'checked'; } echo '>
                        </span>
                        
                        <span class="filtre">
                            <label for="entreprise_non_validee">Non Validées</label>
                            <input class="filter" type="checkbox" name="filtre2" id="entreprise_non_validee" value="entreprise_non_validee" onchange="this.form.submit()" '; if (isset($_REQUEST['filtre2'])) {echo 'checked';} echo '>
                        </span>
                        ';
                    }

                    if (isset($_REQUEST['formation']) && (ConnexionUtilisateur::getTypeConnecte()=='Administrateurs' || ConnexionUtilisateur::getTypeConnecte()=='Etudiants' )) {
                        //on affiche ici les deux filtres : stage et alternance
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
