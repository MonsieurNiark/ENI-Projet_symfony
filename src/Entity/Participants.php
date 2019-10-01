<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipantsRepository")
 */
class Participants implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_participant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $noParticipant;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=30, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=30, nullable=false)
     */
    private $prenom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=15, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=20, nullable=false)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_de_passe", type="string", length=255, nullable=false)
     */
    private $motDePasse;

    /**
     * @var bool
     *
     * @ORM\Column(name="administrateur", type="boolean", nullable=false)
     */
    private $administrateur;

    /**
     * @var bool
     *
     * @ORM\Column(name="actif", type="boolean", nullable=false)
     */
    private $actif;

    /**
     * @var \App\Entity\Sites
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Sites", inversedBy="participantsSite")
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_site")
     */
    private $siteParticipant;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Sorties", mappedBy="organisateurSortie")
     */
    private $sortiesOrganisateur;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Inscriptions", mappedBy="participantInscription")
     */
    private $inscriptionsParticipant;

    public function __construct()
    {
        $this->sortiesOrganisateur = new ArrayCollection();
    }

    public function getNoParticipant()
    {
        return $this->noParticipant;
    }

    public function getUsername()
    {
        return $this->pseudo;
    }

    public function setUsername(string $pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
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

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail()
    {
        return $this->mail;
    }

    public function setEmail(string $mail)
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword()
    {
        return $this->motDePasse;
    }

    public function setPassword(string $motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getAdministrateur()
    {
        return $this->administrateur;
    }

    public function setAdministrateur(bool $administrateur)
    {
        $this->administrateur = $administrateur;

        return $this;
    }

    public function getActif()
    {
        return $this->actif;
    }

    public function setActif(bool $actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Sites
     */
    public function getSiteParticipant()
    {
        return $this->siteParticipant;
    }


    public function setSiteParticipant(Sites $siteParticipant)
    {
        $this->siteParticipant = $siteParticipant;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSortiesOrganisateur(): ArrayCollection
    {
        return $this->sortiesOrganisateur;
    }

    /**
     * @param ArrayCollection $sortiesOrganisateur
     */
    public function setSortiesOrganisateur(ArrayCollection $sortiesOrganisateur)
    {
        $this->sortiesOrganisateur = $sortiesOrganisateur;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    public function getSalt(){return null;}
    public function eraseCredentials(){}
}
