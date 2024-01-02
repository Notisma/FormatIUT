<?php
use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\EtudiantRepository;
use App\FormatIUT\Modele\Repository\FormationRepository;
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
                //on récupère le contenu de l'url après le querry string
                $url = $_SERVER['REQUEST_URI'];
                $url = explode("?", $url);
                $url = $url[1];
                $url = "?" . $url;
                //echo $url;
                ?>

                <form method="get" action="<?php echo $url ?>" id="formTrierPar">
                    <select name="triPar" onchange="this.form.submit()">
                        <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option>
                        <!-- Ajoutez autant d'options que nécessaire -->
                    </select>
                </form>
            </div>

        </div>

    </div>

    <div class="parametresRecherche">
        <p></p>
    </div>

</div>
