<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Configuration\Configuration;

class Prof extends AbstractDataObject implements UtilisateurObject
{
    private string $loginProf;
    private ?string $nomProf;
    private ?string $prenomProf;
    private ?string $mailUniversitaire;
    private bool $estAdmin;
    private string $img;

    /**
     * @param string $loginProf
     * @param ?string $nomProf
     * @param ?string $prenomProf
     * @param ?string $mailUniversitaire
     * @param string $img
     */
    public function __construct(string $loginProf, ?string $nomProf, ?string $prenomProf, ?string $mailUniversitaire,bool $estAdmin, string $img)
    {
        $this->loginProf = $loginProf;
        $this->nomProf = $nomProf;
        $this->prenomProf = $prenomProf;
        $this->mailUniversitaire = $mailUniversitaire;
        $this->estAdmin =$estAdmin;
        $this->img = $img;
    }

    public function isEstAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }


    public function getMailUniversitaire(): ?string
    {
        return $this->mailUniversitaire;
    }

    public function setMailUniversitaire(?string $mailUniversitaire): void
    {
        $this->mailUniversitaire = $mailUniversitaire;
    }


    public function getLoginProf(): string
    {
        return $this->loginProf;
    }

    public function setLoginProf(string $loginProf): void
    {
        $this->loginProf = $loginProf;
    }


    public function getNomProf(): ?string
    {
        return $this->nomProf;
    }

    public function setNomProf(?string $nomProf): void
    {
        $this->nomProf = $nomProf;
    }

    public function getPrenomProf(): ?string
    {
        return $this->prenomProf;
    }

    public function setPrenomProf(?string $prenomProf): void
    {
        $this->prenomProf = $prenomProf;
    }

    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg(string $img): void
    {
        $this->img = $img;
    }


    public function formatTableau(): array
    {
        $estAdmin=0;
        if ($this->estAdmin){
            $estAdmin=1;
        }
        return array(
            "loginProf" => $this->loginProf,
            "nomProf" => $this->nomProf,
            "prenomProf" => $this->prenomProf,
            "mailUniversitaire" => $this->mailUniversitaire,
            "estAdmin"=>$estAdmin,
            "img_id" => $this->img,
        );
    }

    public function getControleur(): string
    {
        return "AdminMain";
    }

    public function getImageProfil(): string
    {
        return "../ressources/images/admin.png";
    }

    public function getTypeConnecte(): string
    {
        if ($this->estAdmin){
            return "Administrateurs";
        }else if ($this->loginProf=="SecretariatTest"){
            return "Secretariat";
        }
        else {
            return "Personnels";
        }
    }

}
