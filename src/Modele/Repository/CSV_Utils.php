<?php

namespace App\FormatIUT\Modele\Repository;

use PDO;

class CSV_Utils
{
    public function exportCSV(): array
    {
        $sql = "SELECT etu.numEtudiant, prenomEtudiant, nomEtudiant, etu.mailUniversitaire, groupe, parcours,offr.validationPedagogique, typeOffre, dateCreationConvention ,dateDebut, dateFin, nomEntreprise, mailTuteurPro, nomProf 
                FROM Etudiants etu LEFT JOIN Postuler r ON r.numEtudiant = etu.numEtudiant 
                LEFT JOIN Formations offr ON offr.idFormation = r.idFormation 
                LEFT JOIN Entreprises entr ON entr.numSiret = offr.idEntreprise 
                LEFT JOIN Villes vEntr ON vEntr.idVille = entr.idVille 
                LEFT JOIN TuteursPro tp ON offr.idTuteurPro = tp.idTuteurPro 
                LEFT JOIN Profs prof ON prof.loginProf= offr.loginTuteurUM
                WHERE etat = 'Validée'
        ";
        $pdoStatement = ConnexionBaseDeDonnee::getPdo()->query($sql);
        $pdoStatement->setFetchMode(PDO::FETCH_NUM);
        $listeObjet = array();
        foreach ($pdoStatement as $item) {
            $listeObjet[] = $item;
        }
        return $listeObjet;
    }
}
