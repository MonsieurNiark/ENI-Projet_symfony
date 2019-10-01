<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SitesRepository")
 */
class Sites
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_site", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $no_Site;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_site", type="string", length=30, nullable=false)
     */
    private $nom_Site;


    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Sorties", mappedBy="siteSortie")
     */
    private $sortiesSite;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Participants", mappedBy="siteParticipant")
     */
    private $participantsSite;

    public function __construct()
    {
        $this->sortiesSite = new ArrayCollection();
        $this->participantsSite = new ArrayCollection();
    }

    public function getNoSite()
    {
        return $this->no_Site;
    }

    public function getNomSite()
    {
        return $this->nom_Site;
    }


    public function setNom_Site(string $nomSite)
    {
        $this->nom_Site = $nomSite;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortiesSite(): ArrayCollection
    {
        return $this->sortiesSite;
    }

    /**
     * @param ArrayCollection $sortiesSite
     */
    public function setSortiesSite(ArrayCollection $sortiesSite)
    {
        $this->sortiesSite = $sortiesSite;
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipantsSite(): ArrayCollection
    {
        return $this->participantsSite;
    }

    /**
     * @param ArrayCollection $participantsSite
     */
    public function setParticipantsSite(ArrayCollection $participantsSite)
    {
        $this->participantsSite = $participantsSite;
    }


}
