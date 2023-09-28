<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../ressources/css/vueGeneraleStyle.css">
    <title>Format'IUT</title>
    <link rel="icon" type="image/png" href="../ressources/images/UM.png"/>
</head>
<body>

<div class="bandeau">
    <?php
    foreach ($menu as $item) {
        echo "<div class='icone'><img src='{$item['image']}'><p>{$item['label']}</p></div>";
    }
    ?>
</div>




<div id="corpsPage">
    <?php
require __DIR__ . "/{$chemin}";
?>
</div>

</body>
</html>
