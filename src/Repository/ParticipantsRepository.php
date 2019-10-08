<?php


namespace App\Repository;


use App\Entity\Participants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ParticipantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participants::class);
    }

    public function getOtherUsers(int $idUser){
        $queryBuilder = $this->createQueryBuilder('participant')
            ->andWhere('participant.noParticipant != :idUser')
            ->setParameter('idUser', $idUser);

        return $queryBuilder->getQuery()->execute();
    }
}