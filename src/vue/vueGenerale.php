<?php

use App\FormatIUT\Configuration\Configuration;

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
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
                    $type = \App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte();
                    $liaison = "";
                    $src = "../ressources/images/profil.png";
                    $liaison = "?controleur=Main&action=afficherPageConnexion";
                    $codeRecherche = "<div class='rechercheResp'><img src='../ressources/images/rechercher.png' alt='img'></div>
                <form action='?action=nothing' method='post'>            
                <input class='searchField' id='hide' name='recherche' placeholder='Rechercher... ' disabled>
                </form>";
                    $menu = \App\FormatIUT\Controleur\ControleurMain::getMenu();

                    if (\App\FormatIUT\Lib\ConnexionUtilisateur::estConnecte()) {
                        $user = \App\FormatIUT\Lib\ConnexionUtilisateur::getUtilisateurConnecte();
                        $src = $user->getImageProfil();
                        $liaison = "?controleur=" . $user->getControleur() . "&action=afficherProfil";
                        $menu = $user->getMenu();

                        $codeRecherche = "
                        <a class='rechercheResp' href='?controleur=Main&action=rechercher&recherche='><img src='../ressources/images/rechercher.png' alt='img'></a>
                        <form action='?' method='get'>
                            <input class='searchField' name='recherche' formmethod='post' placeholder='Rechercher dans $type...' required";
                        if (isset($recherche)) $codeRecherche .= " value='" . urlencode($recherche) . "'";
                        $codeRecherche .=
                            ">
                            <input type='hidden' name='controleur' value='Main'>
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
                        echo "<a " . $actuel . " href='{$item['lien']}'><div class='icone '><img src='{$item['image']}' alt=\"imgmenu\"><p>{$item['label']}</p></div></a>";
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
        <div class="footerContent">
            <div class="footerForm">
                <img src="../ressources/images/Logo_rouge.png" alt="petit logo footer">
                <div>
                    <h4 class="titre blanc">Sources : Cliquer <a
                                href="?action=afficherSources&controleur=Main">ICI</a>
                    </h4>
                    <h4 class="titre blanc">Mentions Légales : Cliquer <a
                                href="?action=afficherMentionsLegales&controleur=Main">ICI</a>
                    </h4>
                </div>
            </div>

            <div id="footerLogo">
                <img src="../ressources/images/LogoIutMontpellier-removed.png" class="grandLogo"
                     alt="grand logo footer">
                <h2 class="titre blanc">© 2023 - Format'IUT</h2>
            </div>
        </div>
    </footer>
</div>
</body>
</html>
