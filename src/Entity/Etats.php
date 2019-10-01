<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EtatsRepository")
 */
class Etats
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_etat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $noEtat;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=30, nullable=false)
     */
    private $libelle;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Sorties", mappedBy="etatSortie")
     */
    private $sortiesEtat;

    public function __construct()
    {
        $this->sortiesEtat = new ArrayCollection();
    }

    public function getNoEtat()
    {
        return $this->noEtat;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortiesEtat(): ArrayCollection
    {
        return $this->sortiesEtat;
    }

    /**
     * @param ArrayCollection $sortiesEtat
     */
    public function setSortiesEtat(ArrayCollection $sortiesEtat)
    {
        $this->sortiesEtat = $sortiesEtat;
    }

}
