<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../ressources/css/vueGeneraleStyle.css">
    <title>Format'IUT</title>
    <link rel="icon" type="image/png" href="../ressources/images/UM.png"/>
</head>
<body>

<nav>
    <div class="navbar">
        <div class="container nav-container">
            <input class="checkbox" type="checkbox" name="" id=""/>
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>

            <div id="search">
                <form action=""> <!-- action à définir -->
                    <label for="searchField"></label><input type="text" placeholder="Rechercher..." id="searchField">
                </form>
            </div>

            <div class="logo">
                <img src="../ressources/images/LogoIutMontpellier-removed.png" id="logoUm">
            </div>

            <div id="profilBox">
                <img src="../ressources/images/profil.png" id = "imageProfil">
                <p>Se Connecter</p>
            </div>

            <div class="menu-items">
                <?php
                foreach($menu as $li => $href){
                    echo "<li><a href='$href'>$li</a></li>";
                }
                ?>
            </div>
        </div>
    </div>
</nav>


<div id="corpsPage">
    <p>test</p>
    <?php
    require __DIR__ . "/{$chemin}";
    ?>
</div>

</body>
</html>
