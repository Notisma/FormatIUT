<div id="center">
    <div class="import">
        <h2 class="titre rouge">Importer un fichier CSV</h2>
        <div class="information">
            <img src="../ressources/images/attention.png" alt="csv">
            <div>
                <h3 class="titre">Attention !</h3>
                <p>Le fichier CSV permet d'ajouter des étudiants dans la base de données du site. Le fichier CSV
                    n'écrase pas les données du site !</p>
            </div>
        </div>
        <form class="formulaire" enctype="multipart/form-data" action="?action=ajouterCSV&controleur=AdminMain"
              method="post">
            <img src="../ressources/images/upload.png" alt="csv">
            <h5 class="titre">Glissez - Déposez ici votre fichier</h5>
            <h5 class="titre">ou :</h5>
            <input class="survol" type="file" name="file">
            <input class="survol" type="submit" value="Envoyer">
        </form>
    </div>

    <div class="export">
        <h2 class="titre">Exporter les données</h2>
        <img src="../ressources/images/csvIcone.png" alt="export">
        <p>Exportez les données de Format'IUT en format CSV</p>
        <form method="post" action="?controleur=AdminMain&action=exporterCSV">
            <input type="submit" value="Télécharger">
        </form>
    </div>

</div>
