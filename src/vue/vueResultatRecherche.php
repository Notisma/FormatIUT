<?php

use App\FormatIUT\Configuration\Configuration;
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
            <h2 class="titre" id="rouge">Effectuez une recherche sur Format'IUT</h2>
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
            <h3 class="titre" id="rouge">Paramètres de Recherche</h3>
        </div>

        <div class="allOptions">
            <form method="get" id="options">

                <div>
                    <h4 class="titre">Entreprises</h4>
                    <span>
                        <label for="entreprise"></label><input class="switch" type="checkbox" name="entreprise"
                                                               id="entreprise" value="on" onchange="this.form.submit()">
                    </span>
                </div>

                <div>
                    <h4 class="titre">Étudiants</h4>
                    <span>
                    <label for="etudiants"></label><input class="switch" type="checkbox" name="etudiants" id="etudiants"
                                                          value="on" onchange="this.form.submit()">
                    </span>
                </div>

                <div>
                    <h4 class="titre">Offres</h4>
                    <span>
                    <label for="offres"></label><input class="switch" type="checkbox" name="offres" id="offres"
                                                       value="on" onchange="this.form.submit()">
                    </span>
                </div>

                <div>
                    <h4 class="titre">Personnels</h4>
                    <span>
                    <label for="personnels"></label><input class="switch" type="checkbox" name="personnels"
                                                           id="personnels" value="on">
                        </span>
                </div>




                <input type="hidden" name="service" value="Recherche">
                <input type="hidden" name="action" value="rechercher">
                <input type="hidden" name="recherche" value="<?php echo $url ?>">
            </form>
        </div>
    </div>

</div>
