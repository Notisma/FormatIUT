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
    if (!empty($listeOffres)){
        foreach ($listeOffres as $offre) {
        echo "<li>";
        echo "L'offre " . $offre->getNomOffre() . " du " . date_format($offre->getDateDebut(),'d-M-Y') . " au " . date_format($offre->getDateFin(),'d-M-Y') . " pour " . $offre->getSujet();
        echo '<a href="?controleur=EntrMain&action=afficherVueDetailOffre&idOffre='.$offre->getIdOffre().'"><button>Voir Detail</button></a>';
        echo "<br> " . $offre->getDetailProjet();
        echo "</li>";
        }
    }else {
        echo "Vous n'avez aucune offre";
    } ?>
</ul>
</div>
</body>
