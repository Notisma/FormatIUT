<head>
    <link rel="stylesheet" href="../ressources/css/styleVueIndex.css">
</head>
<body>
<div id="center">
    <form >
        <?php
        echo '<input type="submit" name="type" value="Offre" ';
        if ($type=="Offre") echo 'id="typeActuel" disabled';
        echo '><input type="submit" name="type" value="Stage" ';
        if ($type=="Stage") echo 'id="typeActuel" disabled';
        echo '><input type="submit" name="type" value="Alternance" ';
        if ($type=="Alternance") echo 'id="typeActuel" disabled';
        echo '>';
        ?>
        <input type="hidden" name="controleur" value="EntrMain">
        <input type="hidden" name="action" value="MesOffres">
    </form>
<ul>
    <?php
foreach ($listeOffres as $offre) {
    echo "<li>";
    echo "L'offre ".$offre->getNomOffre()." du ".$offre->getDateDebut(). " au ".$offre->getDateFin(). " pour ".$offre->getSujet();
    echo "<br> ".$offre->getDetailProjet();
    echo "</li>";

} ?>
</ul>
</div>
</body>
