<?php
echo "<ul>";
foreach ((new \App\FormatIUT\Modele\Repository\OffreRepository())->getListeOffre() as $item) {
    echo "<li>";
    var_dump($item);
    echo "</li>";
}
echo "</ul>";