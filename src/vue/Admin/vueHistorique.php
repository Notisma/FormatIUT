<div class="historiqueMain">
    <div class="stats">
        <div class="elem">
            <h4 class="titreStats">Statistiques des étudiants sur les dernières années</h4>
            <div>
                <p>Nombre d'étudiants ayant eu une formation l'année dernière : <?php echo $nbEtuAvecFormAnneeDerniere ?></p>
                <p>Nombre d'étudiants ayant eu une formation en moyenne chaque année : <?php echo $nbMoyenEtuAvecForm ?></p>
            </div>
        </div>
        <div class="elem">
            <h4 class="titreStats">Statistiques des entreprises sur les dernières années</h4>
            <div>
                <p>Nombre d'entreprises étant déjà sur Format'IUT l'année dernière : <?php echo $nbEntreAnneeDerniere ?></p>
                <p>Nombre moyen d'entreprises présentant des offres chaque année : <?php echo $nbMoyenEntrQuiPosteOffre ?></p>
                <p>Nombre d'entreprises n'ayant pas soumis d'offre l'année dernière : <?php echo $nbEntrSansOffreAnneeDerniere ?></p>
            </div>
        </div>
        <div class="elem">
            <h4 class="titreStats">Statistiques sur les formations les dernières années</h4>
            <div>
                <p>Nombre d'offres de formation postées en moyenne chaque année : <?php echo $nbMoyenOffresChaqueAnnee ?></p>
                <p>Nombre d'offres de formation postées l'année dernière : <?php echo $nbOffresAnneeDerniere ?></p>
                <p>Nombre de formations n'ayant pas eu de convention validée l'année dernière : <?php echo $nbOffresSansConvValideeAnneeDerniere ?></p>
            </div>
        </div>
    </div>
    <div class="boutonStats">
        <a href="?action=afficherVueStatistiques"><button>Voir statistiques principales</button></a>
    </div>
</div>