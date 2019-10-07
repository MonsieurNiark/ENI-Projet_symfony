<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionsRepository")
 */
class Inscriptions
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_inscription", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $noInscription;

    /**
     * @var \App\Entity\Sorties
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Sorties", inversedBy="inscriptionsSortie", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_sortie")
     */
    private $sortieInscription;

    /**
     * @var \App\Entity\Participants
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Participants", inversedBy="inscriptionsParticipant", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,referencedColumnName="no_participant")
     */
    private $participantInscription;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="datetime", nullable=false)
     */
    private $dateInscription;

    /**
     * @return int
     */
    public function getNoInscription(): int
    {
        return $this->noInscription;
    }

    /**
     * @param int $noInscription
     */
    public function setNoInscription(int $noInscription)
    {
        $this->noInscription = $noInscription;
    }

    public function getSortieInscription()
    {
        return $this->sortieInscription;
    }

    public function getParticipantInscription()
    {
        return $this->participantInscription;
    }

    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTime $dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @param Sorties $sortieInscription
     */
    public function setSortieInscription(Sorties $sortieInscription)
    {
        $this->sortieInscription = $sortieInscription;
    }

    /**
     * @param Participants $participantInscription
     */
    public function setParticipantInscription(Participants $participantInscription)
    {
        $this->participantInscription = $participantInscription;
    }

}
