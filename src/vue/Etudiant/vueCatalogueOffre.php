<h1>Catalogue des offres (enlever le footer pour les voir, j'ai pas compris ce que cette section fout tout en bas)</h1>
<?php
if (!$offres)
    echo "<p>Il n'y a aucune offre disponible actuellement. Veuillez revenir plus tard !</p>";
else {
    echo "<ul>";
    foreach ($offres as $offre)
        echo "<li>$offre</li>";
    echo "</ul>";
}
