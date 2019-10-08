<?php


namespace App\Repository;


use App\Entity\Lieux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class LieuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lieux::class);
    }

    /**
     * @param int $id
     * @return array
     */
    public function getLieuxByVille(int $id)
    {
        $queryBuilder = $this->createQueryBuilder('lieux')
            ->andWhere('lieux.villeLieu = :idVille')
            ->setParameter('idVille', $id);

        return $queryBuilder->getQuery()->execute();
    }

    public function lieux($id)
    {
        $qb = $this->createQueryBuilder('lieux')
            ->where('lieux.villeLieu = :idville')
            ->setParameter('idville', $id);

        return $qb->getQuery()
            ->getArrayResult();
    }
}