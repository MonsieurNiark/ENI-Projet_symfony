<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LieuxRepository")
 */
class Lieux
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_lieu", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $noLieu;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lieu", type="string", length=30, nullable=false)
     */
    private $nomLieu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rue", type="string", length=30, nullable=true)
     */
    private $rue;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var \App\Entity\Villes
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Villes", inversedBy="lieuxVille", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_ville")
     */
    private $villeLieu;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Sorties", mappedBy="lieuSortie", cascade={"remove"})
     */
    private $sortiesLieu;

    public function __construct()
    {
        $this->sortiesLieu = new ArrayCollection();
    }

    public function getNoLieu()
    {
        return $this->noLieu;
    }

    public function getNomLieu()
    {
        return $this->nomLieu;
    }

    public function setNomLieu(string $nomLieu)
    {
        $this->nomLieu = $nomLieu;

        return $this;
    }

    public function getRue()
    {
        return $this->rue;
    }

    public function setRue(string $rue)
    {
        $this->rue = $rue;

        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getVilleLieu()
    {
        return $this->villeLieu;
    }

    public function setVilleLieu(Villes $villeLieu)
    {
        $this->villeLieu = $villeLieu;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortiesLieu(): PersistentCollection
    {
        return $this->sortiesLieu;
    }

    /**
     * @param ArrayCollection $sortiesLieu
     */
    public function setSortiesLieu(PersistentCollection $sortiesLieu)
    {
        $this->sortiesLieu = $sortiesLieu;
    }

    public function getLieuSortie(): PersistentCollection
    {
        return $this->sortiesLieu;
    }
}
