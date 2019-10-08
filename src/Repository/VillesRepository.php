<?php


namespace App\Repository;


use App\Entity\Villes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class VillesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Villes::class);
    }

    public function getVilleByNameAndCP(String $name, String $cp){
        $queryBuilder = $this->getEntityManager()->getRepository(Villes::class)
            ->createQueryBuilder('villes')
            ->andWhere('villes.nomVille like :nomVille')
            ->andWhere('villes.codePostal like :codePostal')
            ->setParameter('codePostal', $cp)
            ->setParameter('nomVille', $name)
            ->getQuery()
            ->getResult();
        return $queryBuilder[0];
    }


}