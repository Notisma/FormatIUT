<?php

use App\FormatIUT\Configuration\Configuration;
use App\FormatIUT\Lib\ConnexionUtilisateur;

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../ressources/css/vueGeneraleStyle.css">
    <link rel="stylesheet" href="../ressources/css/<?= $css ?>">
    <script src="../ressources/javaScript/mesFonctions.js"></script>
    <title>Format'IUT - <?= $titrePage ?></title>
    <link rel="icon" type="image/png" href="../ressources/images/UM.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body
    <?php
    if (isset($_REQUEST["premiereConnexion"])) {
        echo "onload='afficherPopupPremiereCo(0)'";
    }
    ?>
>

<div class="couleur">

    <div id="headerContent">
        <div id="texteAccueil">
            <?php
            echo "<h1>{$titrePage}</h1>";
            ?>
        </div>

        <div class="wrapHead">
            <div class="separator">
                <div id="gestionRecherche">
                    <?php
                    $menu=\App\FormatIUT\Controleur\ControleurMain::getMenu();
                    $type = ConnexionUtilisateur::getTypeConnecte();
                    $liaison = "";
                    $src = "../ressources/images/profil.png";
                    $liaison = "?controleur=Main&action=afficherPageConnexion";
                    $codeRecherche = "<div class='rechercheResp'><img src='../ressources/images/rechercher.png' alt='img'></div>
                <form action='?action=nothing' method='post'>            
                <input class='searchField' id='hide' name='recherche' placeholder='Rechercher... ' disabled>
                </form>";


                    if (ConnexionUtilisateur::estConnecte()) {

                        $user = ConnexionUtilisateur::getUtilisateurConnecte();
                        $menu=$user->getMenu();
                        $src = $user->getImageProfil();
                        $liaison = "?controleur=" . $user->getControleur() . "&action=afficherProfil";
                        $controleur=$user->getControleur();
                        $codeRecherche = "
                        <a class='rechercheResp' href='?controleur=$controleur&action=rechercher&recherche='><img src='../ressources/images/rechercher.png' alt='img'></a>
                        <form action='?' method='get'>
                            <input class='searchField' name='recherche' placeholder='Rechercher dans $type...' required";
                        if (isset($recherche)) $codeRecherche .= " value='" . htmlspecialchars($recherche) . "'";
                        $codeRecherche .=
                            ">
                            <input type='hidden' name='controleur' value='$controleur'>
                            <input type='hidden' name='action' value='rechercher'>                    
                        </form>";
                    }
                    echo $codeRecherche;
                    echo "</div>
        <div id='profil'>
        <a href='{$liaison}'>";

                    echo '<img id="petiteIcone" src="' . $src . '" alt="petite icone"></a>
        </div>'; ?>
                </div>

                <div class="flash" id="flash">
                    <?php
                    foreach (\App\FormatIUT\Lib\MessageFlash::lireTousMessages() as $type => $lireMessage) {
                        echo "<div onclick='supprimerElement(\"flash\")' class='alert alert-" . $type . "'>";
                        echo "<img src='../ressources/images/" . $type . ".png' alt='icone'>";
                        echo '<p>' . $lireMessage . '</p></div>';
                    }
                    ?>
                </div>
            </div>
        </div>


        <div class="centrePage">
            <div class="wrapBandeau">
                <div class="bandeau">
                    <div class="menuBurger" onclick="afficherSousMenu()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <?php
                    foreach ($menu as $item) {
                        $actuel = "";
                        if ($item['label'] == $titrePage) {
                            $actuel = "class='active'";
                        }
                        echo "<a " . $actuel . " href='{$item['lien']}'><div class='icone'><img src='{$item['image']}' alt=\"imgmenu\"><p>{$item['label']}</p></div></a>";
                    }
                    ?>
                </div>
            </div>


            <div id="corpsPage">
                <?php
                require __DIR__ . "/{$chemin}";
                ?>
            </div>
        </div>
    </div>


    <div class="sousMenu" id="sousMenu">
        <?php
        foreach ($menu as $item) {
            $actuel = "";
            if ($item['label'] == $titrePage) {
                $actuel = "class='active'";
            }
            echo "<a " . $actuel . " href='{$item['lien']}'><img src='{$item['image']}' alt=\"imgmenu\"><p>{$item['label']}</p></a>";
        }
        echo "<a onclick='fermerSousMenu()'><img src='../ressources/images/fermer.png' alt=\"imgmenu\"><p>Fermer le Menu</p></a>";
        ?>
    </div>


    <footer>
        <div id="footerContent">
            <div id="footerText">
                <h4>Equipe de Développement :</h4>
                <div class="UlConteneur">
                    <div>
                        <ul>
                            <li>Romain TOUZE</li>
                            <li>Raphaël IZORET</li>
                            <li>Matteo TORDEUX</li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li>Enzo GUILHOT</li>
                            <li>Noé FUERTES-TORREDEME</li>
                            <li>Thomas LOYE</li>
                        </ul>
                    </div>
                </div>
                <p>Sources : Cliquer <a
                            href="controleurFrontal.php?action=afficherSources&controleur=Main">ICI</a>
                </p>
            </div>
            <div id="footerLogo">
                <img src="../ressources/images/LogoIutMontpellier-removed.png" class="grandLogo"
                     alt="grand logo footer">
                <h2>© 2023 - Format'IUT</h2>
            </div>
        </div>
    </footer>
</div>

<div class="decoAuto" id="decoAuto">
    <img src="../ressources/images/warning.png" alt="warning">
    <h2 class="titre" id="rouge">AVERTISSEMENT</h2>
    <h3 class="titre">Vous serez déconnecté automatiquement à
        <?php
        date_default_timezone_set('Europe/Paris');
        $date = date("H:i");
        $time = strtotime($date . " +10 minutes");
        echo date("H:i", $time);
        ?>
    </h3>
    <a class="boutonFermer" onclick="supprimerElement('decoAuto')">J'ai Compris</a>
</div>

<?php

if (isset($_SESSION['script'])) {
    echo $_SESSION['script'];
    unset($_SESSION['script']);
}

?>

</body>
</html>
