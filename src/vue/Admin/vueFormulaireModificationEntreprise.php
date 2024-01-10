<?php use App\FormatIUT\Modele\Repository\EntrepriseRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;

$entreprise = (new EntrepriseRepository())->getObjectParClePrimaire($_REQUEST["siret"]);
$ville = (new VilleRepository())->getObjectParClePrimaire($entreprise->getIdVille()) ?>
<div id="center" class="antiPadding">
    <div class="wrapDroite">
        <form method="post">
            <fieldset>
                <legend>Modifier
                    <?php
                    echo $entreprise->getNomEntreprise();
                    ?></legend>
                <label for="nomEntreprise_id">Nom de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="text" name="nomEntreprise" id="nomEntreprise_id" placeholder="Ankama"
                           <?php echo "value='" . $entreprise->getNomEntreprise() . "'" ?>required>
                </div>
                <label for="adresseEntreprise_id">Adresse de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="text" name="adresseEntreprise" id="adresseEntreprise_id"
                           placeholder="75 Boulevard Armentières"
                           <?php echo "value='" . $entreprise->getAdresseEntreprise() . "'" ?>required>
                </div>
                <label for="email_id">Adresse mail de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="email" name="email" id="email_id" placeholder="ankama@hotmail.com"
                           <?php echo "value='" . $entreprise->getEmail() . "'" ?>required>
                </div>
                <label for="codePostal_id">Code postal de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="number" name="codePostal" id="codePostal_id" placeholder="59100"
                           <?php echo "value='" . $ville->getCodePostal() . "'" ?>required>
                </div>
                <label for="nomVille_id">Ville de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="text" name="ville" id="nomVille_id" placeholder="Roubaix"
                           <?php echo "value='" . $ville->getNomVille() . "'" ?>required>
                </div>
                <label for="tel_id">Téléphone de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="number" name="tel" id="tel_id" placeholder="03 20 36 30 00"
                           <?php echo "value='" . $entreprise->getTel() . "'" ?>>
                </div>
                <label for="statutJuridique_id">Statut juridique</label> :
                <div class="inputCentre">
                    <input type="text" name="statutJuridique" id="statutJuridique_id" placeholder="SAS"
                           <?php echo "value='" . $entreprise->getStatutJuridique() . "'" ?>>
                </div>
                <label for="effectif_id">Effectif de l'entreprise</label> :
                <div class="inputCentre">
                    <input type="number" name="effectif" id="effectif_id" placeholder="33"
                           <?php echo "value='" . $entreprise->getEffectif() . "'" ?>>
                </div>
                <label for="codeNAF_id">Code NAF</label> :
                <div class="inputCentre">
                    <input type="text" name="codeNAF" id="codeNAF_id" placeholder="7010Z"
                           <?php echo "value='" . $entreprise->getCodeNAF() . "'" ?>>
                </div>
                <div class="boutonsForm">
                    <input type="submit" value="Envoyer"
                           formaction="?action=modifierEntreprise&controleur=AdminMain&siret=<?php echo $entreprise->getSiret(); ?>"/>
                </div>
            </fieldset>
        </form>
