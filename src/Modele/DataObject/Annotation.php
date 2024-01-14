<?php

namespace App\FormatIUT\Modele\DataObject;

class Annotation extends AbstractDataObject
{
    private string $loginProf;
    private int $siretEntreprise;
    private string $messageAnnotation;
    private string $dateAnnotation;
    private int $noteAnnotation;

    /**
     * @param string $loginProf
     * @param int $siretEntreprise
     * @param string $messageAnnotation
     * @param string $dateAnnotation
     * @param int $noteAnnotation
     */
    public function __construct(string $loginProf, int $siretEntreprise, string $messageAnnotation, string $dateAnnotation, int $noteAnnotation)
    {
        $this->loginProf = $loginProf;
        $this->siretEntreprise = $siretEntreprise;
        $this->messageAnnotation = $messageAnnotation;
        $this->dateAnnotation = $dateAnnotation;
        $this->noteAnnotation = $noteAnnotation;
    }

    /**
     * @return string
     */
    public function getLoginProf(): string
    {
        return $this->loginProf;
    }

    /**
     * @return int
     */
    public function getSiretEntreprise(): int
    {
        return $this->siretEntreprise;
    }

    /**
     * @return string
     */
    public function getMessageAnnotation(): string
    {
        return $this->messageAnnotation;
    }

    /**
     * @return string
     */
    public function getDateAnnotation(): string
    {
        return $this->dateAnnotation;
    }

    /**
     * @return int
     */
    public function getNoteAnnotation(): int
    {
        return $this->noteAnnotation;
    }

    public function formatTableau(): array
    {
        return array(
            "loginProf" => $this->loginProf,
            "siretEntreprise" => $this->siretEntreprise,
            "messageAnnotation" => $this->messageAnnotation,
            "dateAnnotation" => $this->dateAnnotation,
            "noteAnnotation" => $this->noteAnnotation,
        );
    }
}
