<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscriptions
 *
 * @ORM\Table(name="inscriptions", indexes={@ORM\Index(name="inscriptions_participants_fk", columns={"participants_no_participant"})})
 * @ORM\Entity
 */
class Inscriptions
{
    /**
     * @var int
     *
     * @ORM\Column(name="sorties_no_sortie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $sortiesNoSortie;

    /**
     * @var int
     *
     * @ORM\Column(name="participants_no_participant", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $participantsNoParticipant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_inscription", type="datetime", nullable=false)
     */
    private $dateInscription;

    public function getSortiesNoSortie()
    {
        return $this->sortiesNoSortie;
    }

    public function getParticipantsNoParticipant()
    {
        return $this->participantsNoParticipant;
    }

    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    public function setDateInscription(string $dateInscription)
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }


}
