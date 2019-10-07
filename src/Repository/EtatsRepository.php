<?php


namespace App\Repository;

use App\Entity\Etats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class EtatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etats::class);
    }

    public function getEtatByLibelle(string $libelle){
        $queryBuilder = $this->createQueryBuilder('etats')
            ->andWhere('etats.libelle like :libelle')
            ->setParameter('libelle', $libelle);
        return $queryBuilder->getQuery()->getResult();
    }
}