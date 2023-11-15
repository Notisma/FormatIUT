<html>
<head>
    <link rel="stylesheet" href="../ressources/css/styleVueMesOffres.css">
</head>
<body>
<div id="center">

    <div class="presentation">
        <p>ajouter CSV dans la BD :</p>
        <form enctype="multipart/form-data" action="?action=ajouterCSV&controleur=EtuMain" method="post" >
            <input type="file" name="file"/>
            <input type="submit" value="Envoyer"/>
        </form>
    </div>
</div>
</body>
</html>



