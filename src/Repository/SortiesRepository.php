<?php


namespace App\Repository;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\RegistryInterface;
use function Doctrine\ORM\QueryBuilder;

class SortiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sorties::class);
    }

    /**
     * @param int $idSite
     * @param String $nomSortie
     * @param int $estOrga
     * @param int $estInscrit
     * @param int $estPasInscrit
     * @param int $sortiePassees
     * @param int $idUtilisateur
     * @return mixed
     */
    public function getSortieByFiltre(int $idSite, String $nomSortie, int $estOrga, int $estInscrit, int $estPasInscrit, int $sortiePassees, int $idUtilisateur){
        $queryBuilder = $this->getSortiesVisible();

        /* **************** QUERY BUILDER **************** */
        if($idSite != 0){
            $queryBuilder->innerJoin('sortie.siteSortie','site')
                ->addSelect('site')
                ->andWhere('site.no_Site = :id_site');
        }

        if(!is_null($nomSortie) && !empty($nomSortie)){
            $queryBuilder->andWhere('sortie.nom LIKE :nom_sortie');
        }

        if($estInscrit == 1 && $estPasInscrit == 0){
            $queryBuilderInscrit = $this->getEntityManager()->getRepository(Inscriptions::class)
                ->createQueryBuilder('insc')
                ->select('sortie_ins.noSortie')
                ->innerJoin('insc.sortieInscription','sortie_ins')
                ->andWhere('insc.sortieInscription = sortie_ins.noSortie')
                ->andWhere('insc.participantInscription IN (:id_inscrit)');

            $queryBuilder->innerJoin('sortie.inscriptionsSortie','inscrit')
                ->where($queryBuilder->expr()->in('sortie.noSortie',$queryBuilderInscrit->getDQL()));
        }

        if($estPasInscrit == 1 && $estInscrit == 0){
            $queryBuilderInscrit = $this->getEntityManager()->getRepository(Inscriptions::class)
                ->createQueryBuilder('noinsc')
                ->select('sortie_noins.noSortie')
                ->innerJoin('noinsc.sortieInscription','sortie_noins')
                ->andWhere('noinsc.sortieInscription = sortie_noins.noSortie')
                ->andWhere('noinsc.participantInscription IN (:id_noinscrit)');

            $queryBuilder->innerJoin('sortie.inscriptionsSortie','noinscrit')
                ->where($queryBuilder->expr()->notIn('sortie.noSortie',$queryBuilderInscrit->getDQL()));
        }

        if($estOrga == 1){
            $queryBuilder->andWhere('sortie.organisateurSortie = :id_orga');
        }

        if ($sortiePassees == 1){
            $queryBuilder->andWhere('DATE_ADD(sortie.datedebut, sortie.duree, \'minute\') < :today');
        }

        /* **************** SET PARAMETER **************** */
        if($idSite != 0){
            $queryBuilder->setParameter('id_site',$idSite);
        }

        if(!is_null($nomSortie) && !empty($nomSortie)){
            $queryBuilder->setParameter('nom_sortie','%'.$nomSortie.'%');
        }

        if($estOrga == 1){
            $queryBuilder->setParameter('id_orga',$idUtilisateur);
        }

        if($estInscrit == 1 && $estPasInscrit == 0){
            $queryBuilder->setParameter('id_inscrit',$idUtilisateur);
        }

        if($estPasInscrit == 1 && $estInscrit == 0){
            $queryBuilder->setParameter('id_noinscrit',$idUtilisateur);
        }

        if ($sortiePassees == 1){
            $queryBuilder->setParameter('today', new \DateTime("now"));
        }

        return $queryBuilder->getQuery()->getResult();

    }

    public function getSortiesVisible(){
        $queryBuilder = $this->createQueryBuilder('sortie')
            ->innerJoin('sortie.etatSortie', 'etat')
            ->addSelect('etat')
            ->andWhere('etat.libelle NOT IN (\'NON_VISIBLE\')');

        return $queryBuilder;
    }
}