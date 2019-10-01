<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortiesRepository")
 */
class Sorties
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_sortie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $noSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime", nullable=false)
     */
    private $datedebut;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecloture", type="datetime", nullable=false)
     */
    private $datecloture;

    /**
     * @var int
     *
     * @ORM\Column(name="nbinscriptionsmax", type="integer", nullable=false)
     */
    private $nbinscriptionsmax;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descriptioninfos", type="string", length=500, nullable=true)
     */
    private $descriptioninfos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @var \App\Entity\Participants
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Participants", inversedBy="sortiesOrganisateur")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_participant")
     */
    private $organisateurSortie;

    /**
     * @var \App\Entity\Lieux
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Lieux", inversedBy="sortiesLieu")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_lieu")
     */
    private $lieuSortie;

    /**
     * @var \App\Entity\Etats
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Etats", inversedBy="sortiesEtat")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_etat")
     */
    private $etatSortie;

    /**
     * @var \App\Entity\Sites
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Sites", inversedBy="sortiesSite")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_site")
     */
    private $siteSortie;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Inscriptions", mappedBy="sortieInscription")
     */
    private $inscriptionsSortie;

    public function __construct()
    {
        $this->inscriptionsSortie = new ArrayCollection();
        $this->siteSortie = new Sites();
        $this->etatSortie = new Etats();
        $this->lieuSortie = new Lieux();
        $this->organisateurSortie = new Participants();
    }

    public function getNoSortie()
    {
        return $this->noSortie;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatedebut()
    {
        return $this->datedebut;
    }

    public function setDatedebut(string $datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    public function getDuree()
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDatecloture()
    {
        return $this->datecloture;
    }

    public function setDatecloture(string $datecloture)
    {
        $this->datecloture = $datecloture;

        return $this;
    }

    public function getNbinscriptionsmax()
    {
        return $this->nbinscriptionsmax;
    }

    public function setNbinscriptionsmax(int $nbinscriptionsmax)
    {
        $this->nbinscriptionsmax = $nbinscriptionsmax;

        return $this;
    }

    public function getDescriptioninfos()
    {
        return $this->descriptioninfos;
    }

    public function setDescriptioninfos(string $descriptioninfos)
    {
        $this->descriptioninfos = $descriptioninfos;

        return $this;
    }

    public function getUrlphoto()
    {
        return $this->urlphoto;
    }

    public function setUrlphoto(string $urlphoto): self
    {
        $this->urlphoto = $urlphoto;

        return $this;
    }

    public function getOrganisateurSortie()
    {
        return $this->organisateurSortie;
    }

    public function setOrganisateurSortie(int $organisateurSortie): self
    {
        $this->organisateurSortie = $organisateurSortie;

        return $this;
    }

    public function getLieuSortie()
    {
        return $this->lieuSortie;
    }

    public function setLieuSortie(Lieux $lieuSortie): self
    {
        $this->lieuSortie = $lieuSortie;

        return $this;
    }

    public function getEtatSortie()
    {
        return $this->etatSortie;
    }

    public function setEtatSortie(Etats $etatSortie): self
    {
        $this->etatSortie = $etatSortie;

        return $this;
    }

    /**
     * @return Sites
     */
    public function getSiteSortie(): Sites
    {
        return $this->siteSortie;
    }

    /**
     * @param Sites $siteSortie
     */
    public function setSiteSortie(Sites $siteSortie)
    {
        $this->siteSortie = $siteSortie;
    }

    /**
     * @return ArrayCollection
     */
    public function getInscriptionsSortie(): ArrayCollection
    {
        return $this->inscriptionsSortie;
    }

    /**
     * @param ArrayCollection $inscriptionsSortie
     */
    public function setInscriptionsSortie(ArrayCollection $inscriptionsSortie)
    {
        $this->inscriptionsSortie = $inscriptionsSortie;
    }
}
