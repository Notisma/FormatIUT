<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueErreur.css">
</head>
<body>
<div class="boiteMain">
    <div class="conteneurErreur">
        <div class="texte">
            <p>Erreur <?php
            if (isset($erreurStr))
                echo ": $erreurStr";
            else
                echo "inconnue.";
            ?></p>
        </div>
    </div>
</div>


</body>
</html>
