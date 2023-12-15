<?php

namespace App\FormatIUT\Lib;

class PrivilegesUtilisateursRecherche
{
    private static ?PrivilegesUtilisateursRecherche $instance=null;

    private array $privileges;

    private function __construct()
    {
        $this->privileges=array(
            "Entreprise"=>$this->getPrivilegesEntreprise(),
            "Etudiants"=>$this->getPrivilegesEtudiant(),
            "Administrateurs"=>$this->getPrivilegesAdmins(),
            "Personnels"=>$this->getPrivilegesProfs()
        );
    }

    /**
     * @return PrivilegesUtilisateursRecherche
     */
    public static function getInstance(): PrivilegesUtilisateursRecherche
    {
        if (self::$instance==null){
            self::$instance=new PrivilegesUtilisateursRecherche();
        }
        return self::$instance;
    }

    private function getPrivilegesEntreprise():array
    {
        return array(
            "Formation"
        );
    }
    private function getPrivilegesEtudiant():array
    {
        return array(
            "Formation",
            "Entreprise"
        );
    }
    private function getPrivilegesAdmins():array
    {
        return array(
            "Formation",
            "Entreprise",
        );
    }
    private function getPrivilegesProfs():array
    {
        return array(
            "Formation",
            "Entreprise",
            "Etudiant"
        );
    }

    /**
     * @return array
     */
    public function getPrivileges(): array
    {
        return $this->privileges;
    }
}