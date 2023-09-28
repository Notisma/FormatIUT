<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../ressources/css/vueGeneraleStyle.css">
    <title>Format'IUT</title>
    <link rel="icon" type="image/png" href="../ressources/images/UM.png"/>
</head>
<body>

<header>
    <div id="headerContent">
        <p>test</p>
    </div>
</header>

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
