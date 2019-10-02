<?php


namespace App\Repository;

use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\RegistryInterface;

class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     * @param Integer $idSite
     * @param String $nomSortie
     * @param int $estOrga
     * @param int $estInscrit
     * @param int $estPasInscrit
     * @param int $sortiePassees
     *
     * @return array
     */
    public function getSortieByFiltre(int $idSite, String $nomSortie, int $estOrga, int $estInscrit, int $estPasInscrit, int $sortiePassees, int $idUtilisateur){
        $query = $this->createQueryBuilder('sortie');

        if($idSite != 0){
            $query->innerJoin('sortie.siteSortie','site')
                ->addSelect('site')
                ->andWhere('site.no_Site = :id_site')
                ->setParameter('id_site',$idSite);
        }

        if(!is_null($nomSortie) && !empty($nomSortie)){
            $query->andWhere('sortie.nom LIKE :nom_sortie')
                ->setParameter('nom_sortie','%'.$nomSortie.'%');
        }

        if($estOrga == 1){
            $query->orWhere('sortie.organisateurSortie = :id_orga')
                ->setParameter('id_orga',$idUtilisateur);
        }

        if($estInscrit == 1){
            $query->innerJoin('sortie.inscriptionsSortie','inscrit')
                ->addSelect('inscrit')
                ->orWhere('inscrit.sortieInscription = sortie.noSortie')
                ->orWhere('inscrit.participantInscription = :id_inscrit')
                ->setParameter(':id_inscrit',$idUtilisateur);
        }

        if($estPasInscrit == 1){
            $query->innerJoin('sortie.inscriptionsSortie','non_inscrit')
                ->addSelect('non_inscrit')
                ->orWhere('non_inscrit.sortieInscription = sortie.noSortie')
                ->orWhere('non_inscrit.participantInscription != :id_non_inscrit')
                ->setParameter(':id_non_inscrit',$idUtilisateur);
        }

        if ($sortiePassees == 1){
            $query->andWhere('sortie.datecloture < SYSDATE');
        }

        return $query->getQuery()->getResult();

    }
}