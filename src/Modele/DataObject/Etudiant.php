<?php

namespace App\FormatIUT\Modele\DataObject;

class Etudiant extends AbstractDataObject
{
    private float $numEtudiant;
    private string $prenomEtudiant;
    private string $nomEtudiant;
    private string $loginEtudiant;
    private ?string $sexeEtu;
    private ?string $mailUniersitaire;
    private ?string $mailPerso;
    private ?string $telephone;
    private ?string $groupe;
    private ?string $parcours;
    private ?int $validationPedagogique;
    private ?bool $presenceForumIUT;
    private string $img_id;

    /**
     * @param float $numEtudiant
     * @param string $prenomEtudiant
     * @param string $nomEtudiant
     * @param string $loginEtudiant
     * @param string|null $sexeEtu
     * @param string|null $mailUniersitaire
     * @param string|null $mailPerso
     * @param string|null $telephone
     * @param string|null $groupe
     * @param string|null $parcours
     * @param int|null $validationPedagogique
     * @param bool|null $presenceForumIUT
     * @param string $img
     */
    public function __construct(float $numEtudiant, string $prenomEtudiant, string $nomEtudiant, string $loginEtudiant, ?string $sexeEtu, ?string $mailUniersitaire, ?string $mailPerso, ?string $telephone, ?string $groupe, ?string $parcours, ?int $validationPedagogique, ?bool $presenceForumIUT, string $img)
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
        $this->presenceForumIUT = $presenceForumIUT;
        $this->img_id = $img;
    }


    public function getImg(): string
    {
        return $this->img_id;
    }

    public function setImg(string $img_id): void
    {
        $this->img_id = $img_id;
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


    public function getSexeEtu(): string
    {
        if ($this->sexeEtu == null) return "";
        else return $this->sexeEtu;
    }

    public function setSexeEtu(?string $sexeEtu): void
    {
        $this->sexeEtu = $sexeEtu;
    }

    public function getMailUniersitaire(): string
    {
        if ($this->mailUniersitaire == null) return "";
        else return $this->mailUniersitaire;
    }

    public function setMailUniersitaire(?string $mailUniersitaire): void
    {
        $this->mailUniersitaire = $mailUniersitaire;
    }

    public function getMailPerso(): string
    {
        if ($this->mailPerso == null) return "";
        else return $this->mailPerso;
    }

    public function setMailPerso(?string $mailPerso): void
    {
        $this->mailPerso = $mailPerso;
    }

    public function getTelephone(): string
    {
        if ($this->telephone == null) return "";
        else return $this->telephone;
    }

    public function setTelephone(?string $telephone): void
    {
        $this->telephone = $telephone;
    }

    public function getGroupe(): string
    {
        if ($this->groupe == null) return "";
        else return $this->groupe;
    }

    public function setGroupe(?string $groupe): void
    {
        $this->groupe = $groupe;
    }

    public function getParcours(): string
    {
        if ($this->parcours == null) return "";
        else return $this->parcours;
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

    /**
     * @return bool|null
     */
    public function getPresenceForumIUT(): ?bool
    {
        return $this->presenceForumIUT;
    }

    /**
     * @param bool|null $presenceForumIUT
     */
    public function setPresenceForumIUT(?bool $presenceForumIUT): void
    {
        $this->presenceForumIUT = $presenceForumIUT;
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
            "numEtudiant" => $this->numEtudiant,
            "prenomEtudiant" => $this->prenomEtudiant,
            "nomEtudiant" => $this->nomEtudiant,
            "loginEtudiant" => $this->loginEtudiant,
            "sexeEtu" => $this->sexeEtu,
            "mailUniversitaire" => $this->mailUniersitaire,
            "mailPerso" => $this->mailPerso,
            "telephone" => $this->telephone,
            "groupe" => $this->groupe,
            "parcours" => $this->parcours,
            "validationPedagogique" => $this->validationPedagogique,
            "presenceForumIUT"=> $this->presenceForumIUT,
            "img_id" => $this->img_id
        );
    }

    public static function creerEtudiant(array $etu) : Etudiant
    {
        return new Etudiant(
            $etu["numEtudiant"],
            $etu["prenomEtudiant"],
            $etu["nomEtudiant"],
            strtolower($etu["loginEtudiant"]),
            null,
            $etu["mailUniversitaire"],
            null,
            null,
            $etu["groupe"],
            $etu["parcours"],
            0,
            0,
            1
        );
    }
}
