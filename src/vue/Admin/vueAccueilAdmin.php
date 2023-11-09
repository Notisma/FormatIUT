<div class="conteneurPrincipal">
    <div class="conteneurBienvenue">
        <div class="texteBienvenue">
            <h3>Bonjour, <?php
                $prof=(new \App\FormatIUT\Modele\Repository\ProfRepository())->getObjectParClePrimaire(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte());
                echo $prof->getPrenomProf();
                ?></h3>
            <p>Retrouvez ici vos annonces et leur statut actuel :</p>
        </div>

        <div class="imageBienvenue">
            <img src="../ressources/images/bonjourEntr.png" alt="image de bienvenue" class="imageMoyenne">
        </div>
    </div>
</div>