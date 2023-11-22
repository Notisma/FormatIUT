<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Controleur\ControleurMain;
use App\FormatIUT\Lib\MotDePasse;
use App\FormatIUT\Modele\Repository\AbstractRepository;
use App\FormatIUT\Modele\Repository\ImageRepository;
use App\FormatIUT\Modele\Repository\VilleRepository;
use DateTime;

class Entreprise extends AbstractDataObject
{
    private float $siret;
    private string $nomEntreprise;
    private ?string $statutJuridique;
    private ?int $effectif;
    private ?string $codeNAF;
    private ?string $tel;
    private string $adresseEntreprise;
    private string $idVille;
    private string $img;
    private string $mdpHache;
    private string $email;
    private string $emailAValider;
    private string $nonce;
    private bool $estValide;
    private DateTime $dateCreationCompte;

    /**
     * @param float $siret
     * @param string $nomEntreprise
     * @param string|null $statutJuridique
     * @param int|null $effectif
     * @param string|null $codeNAF
     * @param string|null $tel
     * @param string $AdresseEntreprise
     * @param string $idVille
     * @param string $img
     * @param string $mdpHache
     * @param string $email
     * @param string $emailAValider
     * @param string $nonce
     * @param bool $estValide
     * @param DateTime $dateCreationCompte
     */
    public function __construct(float $siret, string $nomEntreprise, ?string $statutJuridique, ?int $effectif, ?string $codeNAF, ?string $tel, string $AdresseEntreprise, string $idVille, string $img, string $mdpHache, string $email, string $emailAValider, string $nonce, bool $estValide, DateTime $dateCreationCompte)
    {
        $this->siret = $siret;
        $this->nomEntreprise = $nomEntreprise;
        $this->statutJuridique = $statutJuridique;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;
        $this->adresseEntreprise = $AdresseEntreprise;
        $this->idVille = $idVille;
        $this->img = $img;
        $this->mdpHache = $mdpHache;
        $this->email = $email;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
        $this->estValide = $estValide;
        $this->dateCreationCompte = $dateCreationCompte;
    }


    public function formatTableau(): array
    {
        $valide=0;
        if ($this->estValide) $valide=1;
        return ['numSiret' => $this->siret,
            'nomEntreprise' => $this->nomEntreprise,
            'statutJuridique' => $this->statutJuridique,
            'effectif' => $this->effectif,
            'codeNAF' => $this->codeNAF,
            'tel' => $this->tel,
            "AdresseEntreprise"=>$this->adresseEntreprise,
            "idVille"=>$this->idVille,
            "img_id"=>$this->img,
            "mdpHache"=>$this->mdpHache,
            "email"=>$this->email,
            "emailAValider"=>$this->emailAValider,
            "nonce"=>$this->nonce,
            "estValide"=>$valide,
            "dateCreationCompte"=>$this->dateCreationCompte,
        ];
    }


    public static function construireDepuisFormulaire(array $EntrepriseEnFormulaire):Entreprise{
        $ville=(new VilleRepository())->getVilleParNom($EntrepriseEnFormulaire["ville"]);
        if (!$ville){
            $newVille=new Ville(self::autoIncrementVille((new VilleRepository())->getListeID(),"idVille"),$EntrepriseEnFormulaire["ville"],$EntrepriseEnFormulaire["codePostal"]);
            (new VilleRepository())->creerObjet($newVille);
            $ville=$newVille->getIdVille();
        }

        return new Entreprise(
            $EntrepriseEnFormulaire["siret"],
            $EntrepriseEnFormulaire["nomEntreprise"],
            $EntrepriseEnFormulaire["statutJuridique"],
            $EntrepriseEnFormulaire["effectif"],
            $EntrepriseEnFormulaire["codeNAF"],
            $EntrepriseEnFormulaire["tel"],
            $EntrepriseEnFormulaire["adresseEntreprise"],
            $ville,
            0,
            MotDePasse::hacher($EntrepriseEnFormulaire["mdp"]),
            "",
            $EntrepriseEnFormulaire["email"],
            MotDePasse::genererChaineAleatoire(),
            false,
            (new DateTime())->format('d-m-Y')
        );
    }
    protected static function autoIncrementVille($listeId, $get): string
    {
        $id = 1;
        while (!isset($_REQUEST[$get])) {
            if (in_array("V".$id, $listeId)) {
                $id++;
            } else {
                $_REQUEST[$get] = $id;
            }
        }
        return "V".$id;
    }

    public function getSiret(): float
    {
        return $this->siret;
    }

    public function setSiret(float $siret): void
    {
        $this->siret = $siret;
    }

    public function getNomEntreprise(): string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): void
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

    public function getAdresseEntreprise(): string
    {
        return $this->adresseEntreprise;
    }

    public function setAdresseEntreprise(string $adresseEntreprise): void
    {
        $this->adresseEntreprise = $adresseEntreprise;
    }

    public function getIdVille(): string
    {
        return $this->idVille;
    }

    public function setIdVille(string $idVille): void
    {
        $this->idVille = $idVille;
    }

    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg(string $img): void
    {
        $this->img = $img;
    }

    public function getMdpHache(): string
    {
        return $this->mdpHache;
    }

    public function setMdpHache(string $mdpHache): void
    {
        $this->mdpHache = $mdpHache;
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

    public function isEstValide(): bool
    {
        return $this->estValide;
    }

    public function setEstValide(bool $estValide): void
    {
        $this->estValide = $estValide;
    }

    public function getDateCreationCompte(): DateTime
    {
        return $this->dateCreationCompte;
    }

    public function setDateCreationCompte(DateTime $dateCreationCompte): void
    {
        $this->dateCreationCompte = $dateCreationCompte;
    }

}
