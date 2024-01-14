<div class="statistiques">
    <div class="grille">
        <div id="etu" class="gridElem">
            <h4 class="titreStats">Statistiques sur les étudiants</h4>
            <div class="listeStats">
                <p class="pStat">Nombre d'étudiants inscrits sur Format'IUT: <?php echo $nbEtudiants ?></p>
                <p class="pStat">Nombre d'étudiants ayant postulé à une offre: <?php echo $nbEtudiantsPostulant ?></p>
                <p class="pStat">Nombre d'étudiants ayant une formation: <?php echo $nbEtudiantsAvecFormation ?></p>
            </div>
        </div>
        <div id="entr" class="gridElem">
            <h4 class="titreStats">Statistiques sur les entreprises</h4>
            <div class="listeStats">
                <p class="pStat">Nombre d'entreprises inscrites sur Format'IUT: <?php echo $nbEntreprises ?></p>
                <p class="pStat">Nombre d'entreprises n'ayant pas soumis d'offre: <?php echo $nbEntreprisesSansOffre ?></p>
                <p class="pStat">Nombre moyen d'offres par entreprise: <?php echo $nbOffresMoyen ?></p>
            </div>
        </div>
        <div id="form" class="gridElem">
            <h4 class="titreStats">Statistiques sur les formations</h4>
            <div class="listeStats" id="listeForm">
                <p class="pStat">Nombre d'offres de formation sur le site : <?php echo $nbFormations ?></p>
                <p class="pStat">Nombre d'offres de stage : <?php echo $nbStages ?></p>
                <p class="pStat">Nombre d'offres d'alternance : <?php echo $nbAlternances ?></p>
                <p class="pStat">Nombre d'offres non validées : <?php echo $nbOffresNonValidees ?></p>
                <p class="pStat">Nombre de formations assignées à un étudiant : <?php echo $nbOffresAvecEtudiant ?> </p>
                <p class="pStat">Nombre de formations n'ayant pas de convention validée : <?php echo $nbOffresConventionNonValidee ?></p>
            </div>
        </div>
    </div>
    <div class="boutonHistorique">
        <a href="?action=afficherVueHistorique">Voir historique</a>
    </div>
</div>