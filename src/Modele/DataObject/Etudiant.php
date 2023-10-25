<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\DataObject\AbstractDataObject;

class Etudiant extends AbstractDataObject
{

    private float $numEtudiant;
    private string $prenomEtudiant;
    private string $nomEtudiant;
    private string $loginEtudiant;
    private ?string $sexeEtu;
    private ?string $mailUniersitaire;
    private ?string $mailPerso;
    private ?int $telephone;
    private ?string $groupe;
    private ?string $parcours;
    private ?int $validationPedagogique;
    private int $codeEtape;
    private string $idResidence;
    private string $img;

    /**
     * @param float $numEtudiant
     * @param string $prenomEtudiant
     * @param string $nomEtudiant
     * @param string $loginEtudiant
     * @param string|null $sexeEtu
     * @param string|null $mailUniersitaire
     * @param string|null $mailPerso
     * @param int|null $telephone
     * @param string|null $groupe
     * @param string|null $parcours
     * @param int|null $validationPedagogique
     * @param int $codeEtape
     * @param string $idResidence
     * @param string $img
     */
    public function __construct(float $numEtudiant, string $prenomEtudiant, string $nomEtudiant, string $loginEtudiant, ?string $sexeEtu, ?string $mailUniersitaire, ?string $mailPerso, ?int $telephone, ?string $groupe, ?string $parcours, ?int $validationPedagogique, int $codeEtape, string $idResidence, string $img)
    {
        $this->numEtudiant = $numEtudiant;
        $this->prenomEtudiant = $prenomEtudiant;
        $this->nomEtudiant = $nomEtudiant;
        $this->loginEtudiant = $loginEtudiant;
        $this->sexeEtu = $sexeEtu;
        $this->mailUniersitaire = $mailUniersitaire;
        $this->mailPerso = $mailPerso;
        $this->telephone = $telephone;
        $this->groupe = $groupe;
        $this->parcours = $parcours;
        $this->validationPedagogique = $validationPedagogique;
        $this->codeEtape = $codeEtape;
        $this->idResidence = $idResidence;
        $this->img = $img;
    }


    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    public function getPrenomEtudiant(): string
    {
        return $this->prenomEtudiant;
    }

    public function setPrenomEtudiant(string $prenomEtudiant): void
    {
        $this->prenomEtudiant = $prenomEtudiant;
    }

    public function getNomEtudiant(): string
    {
        return $this->nomEtudiant;
    }

    public function setNomEtudiant(string $nomEtudiant): void
    {
        $this->nomEtudiant = $nomEtudiant;
    }

    public function getLoginEtudiant(): string
    {
        return $this->loginEtudiant;
    }

    public function setLoginEtudiant(string $loginEtudiant): void
    {
        $this->loginEtudiant = $loginEtudiant;
    }


    public function getSexeEtu(): ?string
    {
        return $this->sexeEtu;
    }

    public function setSexeEtu(?string $sexeEtu): void
    {
        $this->sexeEtu = $sexeEtu;
    }

    public function getMailUniersitaire(): ?string
    {
        return $this->mailUniersitaire;
    }

    public function setMailUniersitaire(?string $mailUniersitaire): void
    {
        $this->mailUniersitaire = $mailUniersitaire;
    }

    public function getMailPerso(): ?string
    {
        return $this->mailPerso;
    }

    public function setMailPerso(?string $mailPerso): void
    {
        $this->mailPerso = $mailPerso;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(?string $groupe): void
    {
        $this->groupe = $groupe;
    }

    public function getParcours(): ?string
    {
        return $this->parcours;
    }

    public function setParcours(?string $parcours): void
    {
        $this->parcours = $parcours;
    }

    public function getValidationPedagogique(): ?int
    {
        return $this->validationPedagogique;
    }

    public function setValidationPedagogique(?int $validationPedagogique): void
    {
        $this->validationPedagogique = $validationPedagogique;
    }

    public function getCodeEtape(): int
    {
        return $this->codeEtape;
    }

    public function setCodeEtape(int $codeEtape): void
    {
        $this->codeEtape = $codeEtape;
    }

    public function getIdResidence(): string
    {
        return $this->idResidence;
    }

    public function setIdResidence(string $idResidence): void
    {
        $this->idResidence = $idResidence;
    }


    public function getNumEtudiant(): float
    {
        return $this->numEtudiant;
    }

    public function setNumEtudiant(float $numEtudiant): void
    {
        $this->numEtudiant = $numEtudiant;
    }

    public function getLogin(): string
    {
        return $this->loginEtudiant;
    }

    public function setLogin(string $login): void
    {
        $this->loginEtudiant = $login;
    }



    public function formatTableau(): array
    {
        return array(
            "numEtudiant"=>$this->numEtudiant,
            "prenomEtudiant",$this->prenomEtudiant,
            "nomEtudiant"=>$this->nomEtudiant,
            "loginEtudiant"=>$this->loginEtudiant,
            "sexeEtu"=>$this->sexeEtu,
            "mailUniversitaire"=>$this->mailUniersitaire,
            "mailPerso"=>$this->mailPerso,
            "telephone"=>$this->telephone,
            "groupe"=>$this->groupe,
            "parcours"=>$this->parcours,
            "validationPedagogique"=>$this->validationPedagogique,
            "codeEtape"=>$this->codeEtape,
            "idResidence"=>$this->idResidence,
            "img"=>$this->img
        );
    }
}