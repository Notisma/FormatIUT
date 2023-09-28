<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../ressources/css/vueGeneraleStyle.css">
    <title>Format'IUT</title>
    <link rel="icon" type="image/png" href="../ressources/images/UM.png"/>
</head>
<body>


<div id="headerContent">
    <div id="texteAccueil">
        <?php
        echo "<h1>{$titrePage}</h1>";
        ?>
    </div>

    <div id="Gestionrecherche">
        <?php
        $liaison = "";
        if ($titrePage == "Accueil") {
            $liaison = "?controleur=etuMain&action=afficherAccueilEtu";
            echo "<form action='' method='get'>            
            <input class='searchField' id='hide' name='recherche' placeholder='Rechercher...'>
        </form>";
        } else {
            $liaison = "?controleur=etuMain&action=afficherProfilEtu";
            echo "<form action='controleurFrontal.php' method='get'>
            <input type='hidden' name='action' value='rechercher'>
            <input type='hidden' name='controleur' value='Main''>
            <input class='searchField' name='recherche' placeholder='Rechercher...'>
        </form>";
        }
        
    echo"</div>
        <div id='profil'>
        <a href='{$liaison}'><img id='petiteIcone' src='../ressources/images/profil.png'></a>
        </div>";
    ?>
</div>



<div class="bandeau">
    <?php
    foreach ($menu as $item) {
        $actuel = "";
        if ($item['label'] == $titrePage) {
            $actuel = "id='active'";
        }
        echo "<a " . $actuel . " href='{$item['lien']}'><div class='icone'><img src='{$item['image']}'><p>{$item['label']}</p></div></a>";
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

</body>
</html>
