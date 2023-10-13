<h1>Catalogue des offres</h1>
<?php
if (!$offres)
    echo "<p>Il n'y a aucune offre disponible actuellement. Veuillez revenir plus tard !</p>";
else {
    echo "<ul>";
    foreach ($offres as $offre)
        echo "<li>$offre</li>";
    echo "</ul>";
}
