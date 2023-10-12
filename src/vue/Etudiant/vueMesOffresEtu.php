<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffres.css">
</head>
<body>
<div id="center">
    <div class="offresEntr">
        <div class="contenuOffresEntr">
            <div class='partieGauche'>
                <?php
                foreach ($listOffre as $offre) {
                    echo '<p>' . $offre->getNomOffre() . '</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>