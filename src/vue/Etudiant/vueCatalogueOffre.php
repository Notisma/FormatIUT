<?php
echo "<ul>";
foreach ((new \App\FormatIUT\Modele\Repository\OffreRepository())->getListeObjet() as $item) {
    echo "<li>";
    var_dump($item);
    echo "</li>";
}
echo "</ul>";