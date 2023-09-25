# Format'IUT

Ce projet regroupe les différents fichiers qui composeront le site web : Format'IUT. Un site pour référencer et gérer les offres de stages et d'alternance.

## Participation

- Loye Thomas
- Izoret Raphael
- Tordeux Matteo
- Guilhot Enzo
- Fuertes-Torredeme Noe
- Touzé Romain

## Branches

- main : branche principale
- index+redirection+configBD : branche test pour la page de connexion
- diagramme-ea : contient les outils nécessaires pour commencer la base de donnée

## Conventions du projet

- namespace : App\FormatIUT
- Méthode : $_POST

## Organisation

- Premier Sprint
  - Vues
    - vueGenerale
    - vueIndex
    - Entreprises
      - vueEntrepriseAccueil
      - vueEntrepriseProfil
      - formulaireCreationOffre
    - Etudiant
      - vueEtudiantAccueil
      - vueOffreCatalogue
      - vueOffreDetail
      - vueEtudiantProfil
  - Modele
    - Repository
      - Offre
    - DataObject
      - Offre
  - Controleur
    - Offre
    - ControleurFrontal
  - Lib
    - AutoLoader

## Detail de la branche

- MAIN