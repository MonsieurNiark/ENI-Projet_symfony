<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sites
 *
 * @ORM\Table(name="sites")
 * @ORM\Entity
 */
class Sites
{
    /**
     * @var int
     *
     * @ORM\Column(name="no_site", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $no_Site;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_site", type="string", length=30, nullable=false)
     */
    private $nom_Site;


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


}
