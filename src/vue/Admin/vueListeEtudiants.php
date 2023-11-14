<div id="center">
<div class="offresEtu">
    <div class="contenuOffresEtu">
<?php
foreach ($listeEtudiants as $etudiant){
    echo $etudiant["etudiant"]->getPrenomEtudiant()." ".$etudiant["etudiant"]->getNomEtudiant(). " : ".$etudiant["aUneFormation"] ."<br>";
}
?>
    </div>
</div>
</div>
