<?php

namespace App\FormatIUT\Modele\DataObject;

use App\FormatIUT\Modele\Repository\VilleRepository;

class EntrepriseFake extends AbstractDataObject
{
    private int $siret;
    private string $nomEntreprise;
    private ?string $statutJuridique;
    private ?int $effectif;
    private ?string $codeNAF;
    private ?string $tel;
    private string $adresseEntreprise;
    private string $idVille;
    private string $email;


    /**
     * @param int $siret
     * @param string $nomEntreprise
     * @param string|null $statutJuridique
     * @param int|null $effectif
     * @param string|null $codeNAF
     * @param string|null $tel
     * @param string $AdresseEntreprise
     * @param string $idVille
     * @param string $email
     */
    public function __construct(int $siret, string $nomEntreprise, ?string $statutJuridique, ?int $effectif, ?string $codeNAF, ?string $tel, string $AdresseEntreprise, string $idVille, string $email)
    {
        $this->siret = $siret;
        $this->nomEntreprise = $nomEntreprise;
        $this->statutJuridique = $statutJuridique;
        $this->effectif = $effectif;
        $this->codeNAF = $codeNAF;
        $this->tel = $tel;
        $this->adresseEntreprise = $AdresseEntreprise;
        $this->idVille = $idVille;
        $this->email = $email;

    }


    public function formatTableau(): array
    {
        return ['numSiret' => $this->siret,
            'nomEntreprise' => $this->nomEntreprise,
            'statutJuridique' => $this->statutJuridique,
            'effectif' => $this->effectif,
            'codeNAF' => $this->codeNAF,
            'tel' => $this->tel,
            "adresseEntreprise" => $this->adresseEntreprise,
            "idVille" => $this->idVille,
            "email" => $this->email,

        ];
    }


    public static function construireDepuisFormulaire(array $EntrepriseEnFormulaire): EntrepriseFake
    {
        $ville = (new VilleRepository())->getVilleParNom($EntrepriseEnFormulaire["ville"]);
        if (!$ville) {
            $newVille = new Ville(null, $EntrepriseEnFormulaire["ville"], $EntrepriseEnFormulaire["codePostal"]);
            $ville = (new VilleRepository())->creerObjet($newVille);
        }

        return new EntrepriseFake(
            $EntrepriseEnFormulaire["siret"],
            $EntrepriseEnFormulaire["nomEntreprise"],
            $EntrepriseEnFormulaire["statutJuridique"],
            $EntrepriseEnFormulaire["effectif"],
            $EntrepriseEnFormulaire["codeNAF"],
            $EntrepriseEnFormulaire["tel"],
            $EntrepriseEnFormulaire["adresseEntreprise"],
            $ville,
            $EntrepriseEnFormulaire["email"]

        );
    }

    protected static function autoIncrementVille($listeId, $get): string
    {
        $id = 1;
        while (!isset($_REQUEST[$get])) {
            if (in_array("V" . $id, $listeId)) {
                $id++;
            } else {
                $_REQUEST[$get] = $id;
            }
        }
        return "V" . $id;
    }

    public function getSiret(): int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): void
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


    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public static function creerEntreprise(array $entreprise): EntrepriseFake
    {
        return new EntrepriseFake(
            $entreprise["siret"],
            $entreprise["nomEntreprise"],
            $entreprise["statutJuridique"],
            $entreprise["effectif"],
            $entreprise['codeNAF'],
            $entreprise["tel"],
            $entreprise["adresseEntreprise"],
            $entreprise["idVille"],
            $entreprise["email"]
        );
    }

}
