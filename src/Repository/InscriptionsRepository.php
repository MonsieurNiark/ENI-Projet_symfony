<?php


namespace App\Repository;

use App\Entity\Inscriptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class InscriptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Inscriptions::class);
    }

    /**
     * @param int $idSortie
     * @param int $idParticipant
     * @return array
     */
    public function getInscriptionBySortieParticipantId(int $idSortie, int $idParticipant){
        $query = $this->createQueryBuilder('i')
            ->andWhere('i.sortieInscription = :id_sortie')
            ->andWhere('i.participantInscription = :id_participant')
            ->setParameter('id_sortie',$idSortie)
            ->setParameter('id_participant',$idParticipant);

        return $query->getQuery()->getResult();
    }
}