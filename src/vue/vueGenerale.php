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
            <div id="Gestionrecherche">
                <?php
                $liaison = "";
                $src = "../ressources/images/profil.png";
                $liaison = "?controleur=Main&action=afficherPageConnexion";
                $codeRecherche = "<form action='?action=nothing' method='post'>            
            <input class='searchField' id='hide' name='recherche' placeholder='Rechercher...' disabled>
        </form>";
                if (\App\FormatIUT\Lib\ConnexionUtilisateur::estConnecte()) {
                    switch (\App\FormatIUT\Lib\ConnexionUtilisateur::getTypeConnecte()) {
                        case "Entreprise" :
                        {
                            $image = ((new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte()));
                            $src = "data:image/jpeg;base64," . base64_encode($image->getImg());
                            $liaison = "?controleur=entrMain&action=afficherProfil";
                            break;
                        }
                        case "Etudiants" :
                        {
                            $image = ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->getObjectParClePrimaire(\App\FormatIUT\Controleur\ControleurEtuMain::getCleEtudiant()));
                            $src = "data:image/jpeg;base64," . base64_encode($image->getImg());
                            $liaison = "?controleur=etuMain&action=afficherProfil";
                            break;
                        }
                        case "Administrateurs" :
                        {
                            $image = ((new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte()));
                            //$src = "data:image/jpeg;base64," . base64_encode($image->getImg());
                            $src = "../ressources/images/admin.png";
                            $liaison = "?controleur=AdminMain&action=afficherProfilAdmin";
                            break;
                        }
                    }

                    $codeRecherche = "
                        <form action='?' method='get'>
                            <input class='searchField' name='recherche' placeholder='Rechercher...' required";
                    if (isset($recherche)) $codeRecherche .= " value='" . htmlspecialchars($recherche) . "'";
                    $codeRecherche .=
                            ">
                            <input type='hidden' name='controleur' value='" . Configuration::getControleur() . "'>
                            <input type='hidden' name='action' value='rechercher'>                    
                        </form>";
                }
                echo $codeRecherche;
                echo "</div>
        <div id='profil'>
        <a href='{$liaison}'>";

                echo '<img id="petiteIcone" src="' . $src . '" alt="petite icone"></a>
        </div>'; ?>

                <div class="flash">
                    <?php
                    foreach (\App\FormatIUT\Lib\MessageFlash::lireTousMessages() as $type => $lireMessage) {
                        echo "<div onclick='supprimerElement(\"flash\")' id='flash' class='alert alert-" . $type . "'>";
                        echo "<img src='../ressources/images/" . $type . ".png' alt='icone'>";
                        echo '<p>' . $lireMessage . '</p></div>';
                    }
                    ?>
                </div>
            </div>

        </div>


        <div class="bandeau">
            <div class="menuBurger">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <?php
            foreach ($menu as $item) {
                $actuel = "";
                if ($item['label'] == $titrePage) {
                    $actuel = "id='active'";
                }
                echo "<a " . $actuel . " href='{$item['lien']}'><div class='icone'><img src='{$item['image']}' alt=\"imgmenu\"><p>{$item['label']}</p></div></a>";
            }
            ?>
        </div>

        <div id="corpsPage">
            <div id="main">
                <?php
                require __DIR__ . "/{$chemin}";
                ?>
            </div>
        </div>
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
                <p>Sources : <a href="controleurFrontal.php?action=afficherSources">Cliquer ICI</a></p>
            </div>
            <div id="footerLogo">
                <img src="../ressources/images/LogoIutMontpellier-removed.png" class="grandLogo"
                     alt="grand logo footer">
                <h2>© 2023 - Format'IUT</h2>
            </div>
        </div>
    </footer>
</body>
</html>
