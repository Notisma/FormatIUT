<div class="boiteMain">
    <div class="etudiantInfos">
        <div class="h3centre">
            <h3>Votre Identité Visuelle</h3>
        </div>
        <div class="petiteDiv">
            <div class="texteAGauche">
                <p>Changez votre logo ici :</p>
                <form enctype="multipart/form-data" action="?action=updateImage&controleur=EntrMain" method="post">
                    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" >
                    <input type="file" name="pdp" size=50 >
                    <input type="submit" value="Envoyer" >
                </form>
            </div>
            <div class="imageEtu">
                <?php
                //echo ((new \App\FormatIUT\Modele\Repository\ImageRepository())->getImage(1));
                //echo '<img src="data:image/jpeg;base64,'.base64_encode( $result['IMAGE'] ).'" >';
                //on affiche le logo de l'entreprise depuis ImageRepository
                use App\FormatIUT\Modele\Repository\OffreRepository;

                echo '<img src="data:image/jpeg;base64,' . base64_encode($entreprise->getImg()) . '" alt="profilePic" >';
                ?>
                <!--
                <img src="../ressources/images/logo_CA.png" alt="logoEntreprise">
                -->
            </div>
        </div>
    </div>

    <div class="conteneurBienvenueEtu">
        <div class="texteBienvenue">
            <h3>Bonjour, bienvenue sur votre compte entreprise</h3>
            <p>Voici toutes les informations de votre compte :</p>
        </div>
        <div class="imageBienvenue">
            <img src="../ressources/images/parametresEntr.png" alt="image de bienvenue">
        </div>
    </div>


    <div class="informationsActuellesEtu">
        <h3>Vos Informations Actuelles</h3>
        <div class="infosActu">
            <ul id="infosEntr">
                <?php
                $ville = (new \App\FormatIUT\Modele\Repository\VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille());
                echo "<li>Siret : " . $entreprise->getSiret() . "</li>
            <li>Nom : " . $entreprise->getNomEntreprise() . "</li>
            <li>Statut juridique : " . $entreprise->getStatutJuridique() . "</li>
            <li>Effectif : " . $entreprise->getEffectif() . "</li>
            <li>CodeNAF : " . $entreprise->getCodeNaf() . "</li>
            <li>Téléphone : " . $entreprise->getTel() . "</li>
            <li>Adresse : " . $entreprise->getAdresse() . "</li>
            <li>Ville : " . $ville->getNomVille() . "</li>
            " ?>
                <a href="?action=afficherFormulaireModification&controleur=EntrMain">Modifier vos informations</a>
            </ul>

            <img src="../ressources/images/infosEntre.png" alt="illu">

        </div>
    </div>


    <div class="detailsDeEntreprise">
        <h3>Vos Statistiques</h3>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/offres.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4><?php
                    $OffresEnLigne = ((new OffreRepository())->OffresParEntrepriseDispo(\App\FormatIUT\Lib\ConnexionUtilisateur::getLoginUtilisateurConnecte()));
                    $nbOffresEnLigne = sizeof($OffresEnLigne);
                    echo $nbOffresEnLigne . " Offre";
                    if ($nbOffresEnLigne != 1) echo "s";
                    ?> en ligne
                </h4>
            </div>

        </div>


        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/etudiant.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4><?php
                    $nbEtudiant = 0;
                    foreach ($OffresEnLigne as $item) {
                        $nbEtudiant += ((new \App\FormatIUT\Modele\Repository\EtudiantRepository())->nbPostulation($item->getIdOffre()));
                    }
                    $s = "";
                    if ($nbEtudiant != 1) $s = "s";
                    echo $nbEtudiant . " étudiant" . $s . " postultant" . $s;
                    ?> </h4>
            </div>

        </div>

        <div class="statistiques">
            <div class="illustrationStat">
                <img src="../ressources/images/archiver.png" alt="illustration postuler">
            </div>

            <div class="descStat">
                <h4>0 offres ou contrats archivés</h4>
            </div>

        </div>

    </div>
</div>
