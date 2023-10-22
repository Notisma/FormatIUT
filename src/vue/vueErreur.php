<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueErreur.css">
</head>
<body>
<div class="boiteMain">
    <div class="conteneurErreur">
        <div class="image">
            <img src="../ressources/images/danger.png" alt="imageErreur">
        </div>
        <div class="texte">
            <h2>Erreur <?php
            if (isset($erreurStr))
                echo ": $erreurStr.";
            else
                echo "inconnue.";
            ?></h2>
        </div>
    </div>
</div>


</body>
</html>
