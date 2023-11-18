<div id="center">
    <div class="presentation">
        <p>Importer un CSV :</p>
        <form enctype="multipart/form-data" action="?action=ajouterCSV&controleur=AdminMain" method="post" >
            <input type="file" name="file"/>
            <input type="submit" value="Envoyer"/>
        </form>
    </div>
    <div class="presentation">
        <p>Exporter un CSV :</p>
        <form method="post" action="?controleur=AdminMain&action=exporterCSV">
            <input type="submit" value="Envoyer"/>
        </form>
    </div>
</div>
