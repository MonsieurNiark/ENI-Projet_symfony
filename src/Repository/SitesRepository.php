<?php


namespace App\Repository;


use Symfony\Bridge\Doctrine\RegistryInterface;

class SitesRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sites::class);
    }


}