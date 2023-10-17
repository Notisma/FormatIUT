<html>

<head>
    <link rel="stylesheet" href="../ressources/css/styleVueAccueilEntreprise.css">
</head>

<body>

<div class="conteneurPrincipal">
    <div class="conteneurBienvenue">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue dans votre compte Entreprise</h3>
            <p>Retrouvez ici vos annonces et leur statut actuel :</p>
        </div>

        <div class="imageBienvenue">
            <img src="../ressources/images/bonjourEntr.png" alt="image de bienvenue" class="imageMoyenne">
        </div>
    </div>

    <div class="notifications">
        <h4>Vos Notifications :</h4>
        <!-- affichage d'un erreur pour dire qu'il n'y a pas de notifications -->
        <div class="wrapErreur">
            <img src="../ressources/images/erreur.png" alt="image d'erreur" class="imageErreur">
            <h4>Aucune notification pour le moment.</h4>
        </div>
    </div>


    <div class="conteneurAnnoncesEntr">
        <div class="titre">
            <h3>Vos annonces publiées ou en attente de publication :</h3>
        </div>

        <div class="wrapAnnonces">

            <!-- exemple d'annonce en attente de publication
            <a href="http://localhost:8080" class="annonceEntreprise">
                <div class="imgAnnonce">
                    <img src="../ressources/images/logo_CA.png" class="imageEntr">
                </div>
                <div class="wrapTexte">
                <h4>CREDIT AGRICOLE FRANCE</h4>
                    <div class="detailsAnnonce">
                        <div class="lieuRemun">
                            <div class="lieuAnnonce">
                                <img src="../ressources/images/emplacement.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">Montpellier, 34</p>
                            </div>
                            <div class="remunAnnonce">
                                <img src="../ressources/images/euros.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">280/mois</p>
                            </div>
                        </div>
                        <div class="dureeLibelle">
                            <div class="dureeAnnonce">
                                <img src="../ressources/images/histoire.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">3 mois</p>
                            </div>
                            <div class="libelleAnnonce">
                                <img src="../ressources/images/emploi.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">Développeur Front-end</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="statutAnnonceEntr">
                    <div class="statut" id="enAttente">
                        <img src="../ressources/images/sablier.png" alt="image" class="imagesStatut">
                        <p class="petitTexte">En attente de vérification</p>
                    </div>
                </div>
            </a>
            -->
            <!-- exemple d'annonce publiée -->
            <?php
            for ($i=0;$i<sizeof($listeOffre);$i++) {
                $entreprise=(new \App\FormatIUT\Modele\Repository\EntrepriseRepository())->getObjectParClePrimaire($listeOffre[$i]->getSiret());
                $ville=(new \App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
                $lien="?controleur=EntrMain&action=afficherVueDetailOffre&idOffre=".$listeOffre[$i]->getIdOffre();
                echo '<a href="'.$lien.'" class="annonceEntreprise">
                <div class="imgAnnonce">
                    <img src="data:image/jpeg;base64,'.base64_encode( $entreprise->getImg()).'" class="imageEntr">
                </div>
                <div class="wrapTexte">
                    <h4>';
                $nomEntrHTML=htmlspecialchars($entreprise->getNomEntreprise());
                echo $nomEntrHTML;
                echo '</h4>
                    <div class="detailsAnnonce">
                        <div class="lieuRemun">
                            <div class="lieuAnnonce">
                                <img src="../ressources/images/emplacement.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">';
                $nomVilleHTML=htmlspecialchars($ville->getNomVille());
                echo $nomVilleHTML;
                echo '</p>
                            </div>
                            <div class="remunAnnonce">
                                <img src="../ressources/images/euros.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">';
                echo $listeOffre[$i]->getGratification();
                echo '/mois</p>
                            </div>
                        </div>
                        <div class="dureeLibelle">
                            <div class="dureeAnnonce">
                                <img src="../ressources/images/histoire.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">';
                echo ($listeOffre[$i]->getDateDebut()->diff($listeOffre[$i]->getDateFin()))->format('%m mois');
                echo '</p>
                            </div>
                            <div class="libelleAnnonce">
                                <img src="../ressources/images/emploi.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">';
                $nomOffreHTML=htmlspecialchars($listeOffre[$i]->getNomOffre());
                echo $nomOffreHTML;
                echo '</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="statutAnnonceEntr">
                    <div class="statut" id="valide">
                        <img src="../ressources/images/verifie.png" alt="image" class="imagesStatut">
                        <p class="petitTexte">Offre publiée.</p>
                    </div>
                </div>
            </a>';
            }
            ?>

            <!-- exemple d'annonce refusée

            <a href="http://localhost:8080" class="annonceEntreprise">
                <div class="imgAnnonce">
                    <img src="../ressources/images/logo_CA.png" class="imageEntr">
                </div>
                <div class="wrapTexte">
                    <h4>CREDIT AGRICOLE FRANCE</h4>
                    <div class="detailsAnnonce">
                        <div class="lieuRemun">
                            <div class="lieuAnnonce">
                                <img src="../ressources/images/emplacement.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">Montpellier, 34</p>
                            </div>
                            <div class="remunAnnonce">
                                <img src="../ressources/images/euros.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">280/mois</p>
                            </div>
                        </div>
                        <div class="dureeLibelle">
                            <div class="dureeAnnonce">
                                <img src="../ressources/images/histoire.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">3 mois</p>
                            </div>
                            <div class="libelleAnnonce">
                                <img src="../ressources/images/emploi.png" alt="image" class="imagesPuces">
                                <p class="petitTexte">Développeur Front-end</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="statutAnnonceEntr">
                    <div class="statut" id="refuse">
                        <img src="../ressources/images/rejete.png" alt="image" class="imagesStatut">
                        <p class="petitTexte">Annonce refusée</p>
                    </div>
                </div>
            </a>
            -->




        </div>


    </div>

</div>

</body>



</html>