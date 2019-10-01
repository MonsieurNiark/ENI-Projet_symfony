<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VillesRepository")
 */
class Villes
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_ville", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $noVille;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_ville", type="string", length=30, nullable=false)
     */
    private $nomVille;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=10, nullable=false)
     */
    private $codePostal;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Lieux", mappedBy="villeLieu")
     */
    private $lieuxVille;

    public function __construct()
    {
        $this->lieuxVille = new ArrayCollection();
    }

    public function getNoVille()
    {
        return $this->noVille;
    }

    public function getNomVille()
    {
        return $this->nomVille;
    }

    public function setNomVille(string $nomVille): self
    {
        $this->nomVille = $nomVille;

        return $this;
    }

    public function getCodePostal()
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLieuxVille(): ArrayCollection
    {
        return $this->lieuxVille;
    }

    /**
     * @param ArrayCollection $lieuxVille
     */
    public function setLieuxVille(ArrayCollection $lieuxVille)
    {
        $this->lieuxVille = $lieuxVille;
    }

}
