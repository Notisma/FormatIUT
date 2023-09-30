<?php

namespace App\FormatIUT\Modele\Repository;

class OffreRepository
{
    public function creerOffre(Offre $offre){
        $sql="INSERT INTO offre values(";
        foreach ($this->getNomsColonnes() as $formatTableau) {
            if($formatTableau!=$this->getNomsColonnes()[0]){
                $sql.=",";
            }
            $sql.=":Tag".$formatTableau;
            $values["Tag".$formatTableau]=$offre->formatTableau()[$formatTableau];
        }
        $sql.=")";
        $pdoStatement=ConnexionBaseDeDonnee::getPdo()->prepare($sql);
        $pdoStatement->execute($values);
    }
    public function getNomsColonnes() : array{
        return ["idOffre","nomOffre","dateDebut","dateFin","sujet","detailProjet","gratification","dureeHeures","joursParSemaine","nbHeuresHebdo"];
    }
}