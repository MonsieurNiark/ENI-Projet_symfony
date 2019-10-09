<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @ORM\Column(name="motifannulation", type="string", length=500, nullable=true)
     */
    private $motifannulation;

    /**
     * @var string|null
     *
     * @ORM\Column(name="urlPhoto", type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @var \App\Entity\Participants
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Participants", inversedBy="sortiesOrganisateur", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_participant")
     */
    private $organisateurSortie;

    /**
     * @var \App\Entity\Lieux
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Lieux", inversedBy="sortiesLieu",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_lieu")
     *
     */
    private $lieuSortie;

    /**
     * @var \App\Entity\Etats
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Etats", inversedBy="sortiesEtat",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_etat")
     */
    private $etatSortie;

    /**
     * @var \App\Entity\Sites
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Sites", inversedBy="sortiesSite",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_site")
     */
    private $siteSortie;

    /**
     * @var PersistentCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Inscriptions", mappedBy="sortieInscription", cascade={"remove"})
     */
    private $inscriptionsSortie;

    public function __construct()
    {
        $this->inscriptionsSortie = new ArrayCollection();
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

    public function setDatedebut(\DateTime $datedebut)
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

    public function setDatecloture(\DateTime $datecloture)
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

    public function setOrganisateurSortie(Participants $organisateurSortie): self
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
     * @return PersistentCollection
     */
    public function getInscriptionsSortie(): PersistentCollection
    {
        return $this->inscriptionsSortie;
    }

    /**
     * @param PersistentCollection $inscriptionsSortie
     */
    public function setInscriptionsSortie(PersistentCollection $inscriptionsSortie)
    {
        $this->inscriptionsSortie = $inscriptionsSortie;
    }

    /**
     * @return string|null
     */
    public function getMotifannulation(): string
    {
        return $this->motifannulation;
    }

    /**
     * @param string|null $motifannulation
     */
    public function setMotifannulation(string $motifannulation)
    {
        $this->motifannulation = $motifannulation;
    }
}
