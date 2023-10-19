<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;

class Entreprise extends AbstractDataObject
{
    private float $siret;
    private ?string $nomEntreprise;
    private ?string $statutJuridique;
    private ?int $effectif;
    private ?string $codeNAF;
    private ?string $tel;
    private string $Adresse_Entreprise;
    private string $idVille;
    private string $img;
    private string $mdpHache;
    private string $email;
    private string $emailAValider;
    private string $nonce;

    /**
     * @param float $siret
     * @param string|null $nomEntreprise
     * @param string|null $statutJuridique
     * @param int|null $effectif
     * @param string|null $codeNAF
     * @param string|null $tel
     * @param string $Adresse_Entreprise
     * @param string $idVille
     * @param string $img
     * @param string $mdpHache
     * @param string $email
     * @param string $emailAValider
     * @param string $nonce
     */
    public function __construct(float $siret, ?string $nomEntreprise, ?string $statutJuridique, ?int $effectif, ?string $codeNAF, ?string $tel, string $Adresse_Entreprise, string $idVille, string $img, string $mdpHache, string $email, string $emailAValider, string $nonce)
    {
        $this->siret = $siret;
        $this->nomEntreprise = $nomEntreprise;
        $this->statutJuridique = $statutJuridique;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;
        $this->Adresse_Entreprise = $Adresse_Entreprise;
        $this->idVille = $idVille;
        $this->img = $img;
        $this->mdpHache = $mdpHache;
        $this->email = $email;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
    }

    public function getAdresseEntreprise(): string
    {
        return $this->Adresse_Entreprise;
    }

    public function setAdresseEntreprise(string $Adresse_Entreprise): void
    {
        $this->Adresse_Entreprise = $Adresse_Entreprise;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmailAValider(): string
    {
        return $this->emailAValider;
    }

    public function setEmailAValider(string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }

    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
    }


    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    public function getVille(): string
    {
        return $this->idVille;
    }

    public function getAdresse(): string
    {
        return $this->Adresse_Entreprise;
    }

    public function setAdresse(string $adresse): void
    {
        $this->Adresse_Entreprise = $adresse;
    }

    public function getIdVille(): string
    {
        return $this->idVille;
    }

    public function setIdVille(string $idVille): void
    {
        $this->idVille = $idVille;
    }


    public function formatTableau(): array
    {
        return ['numSiret' => $this->siret,
            'nomEntreprise' => $this->nomEntreprise,
            'statutJuridique' => $this->statutJuridique,
            'effectif' => $this->effectif,
            'codeNAF' => $this->codeNAF,
            'tel' => $this->tel,
            "Adresse_Entreprise"=>$this->Adresse_Entreprise,
            "idVille"=>$this->idVille,
            "img_id"=>$this->img,
            "mdpHache"=>$this->mdpHache,
            "email"=>$this->email,
            "emailAValider"=>$this->emailAValider,
            "nonce"=>$this->nonce
        ];
    }

    public function __toString(): string
    {
        return $this->nomEntreprise;
    }


    public function getSiret(): float
    {
        return $this->siret;
    }

    public function setSiret(float $siret): void
    {
        $this->siret = $siret;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(?string $nomEntreprise): void
    {
        $this->nomEntreprise = $nomEntreprise;
    }

    public function getStatutJuridique(): ?string
    {
        return $this->statutJuridique;
    }

    public function setStatutJuridique(?string $statutJuridique): void
    {
        $this->statutJuridique = $statutJuridique;
    }

    public function getEffectif(): ?int
    {
        return $this->effectif;
    }

    public function setEffectif(?int $effectif): void
    {
        $this->effectif = $effectif;
    }

    public function getCodeNAF(): ?string
    {
        return $this->codeNAF;
    }

    public function setCodeNAF(?string $codeNAF): void
    {
        $this->codeNAF = $codeNAF;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): void
    {
        $this->tel = $tel;
    }

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
    }

    public static function construireDepuisFormulaire(array $EntrepriseEnFormulaire):Entreprise{

        return new Entreprise(
            $EntrepriseEnFormulaire["siret"],
            $EntrepriseEnFormulaire["nomEntreprise"],
            $EntrepriseEnFormulaire["statutJuridique"],
            $EntrepriseEnFormulaire["effectif"],
            $EntrepriseEnFormulaire["codeNAF"],
            $EntrepriseEnFormulaire["tel"],
            $EntrepriseEnFormulaire["Adresse_Entreprise"],
            (new VilleRepository())->getVilleParNom($EntrepriseEnFormulaire["idVille"]),
            0,
            MotDePasse::hacher($EntrepriseEnFormulaire["mdp"]),
            "",
            $EntrepriseEnFormulaire["email"],
            MotDePasse::genererChaineAleatoire()
        );
    }


}
