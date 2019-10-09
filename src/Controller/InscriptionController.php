<?php

namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Participants;
use App\Entity\Sorties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class InscriptionController extends Controller
{
    /**
     * @Route("/sortie/inscription/{id_sortie}", name="inscription", requirements={"id_sortie": "\d+"})
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function inscrireSortie(Request $request,EntityManagerInterface $em, int $id_sortie)
    {
        $sortie = $em->getRepository(Sorties::class)->find($id_sortie);
        $participant = $this->getUser();
        $flashbag = $this->get('session')->getFlashBag();
        $inscriptionsRepo = $em->getRepository(Inscriptions::class)->createQueryBuilder('pi')
            ->andWhere('pi.sortieInscription = :id')
            ->setParameter('id',$sortie->getNoSortie())
            ->getQuery();
        foreach($inscriptionsRepo->execute() as $inscriptions){

            if($inscriptions->getParticipantInscription()->getNoParticipant() == $participant->getNoParticipant()){
                $flashbag->add("already_inscrit", "Vous êtes déjà inscrit.");
                return $this->redirect($request->headers->get('referer'));
            }
        }
        $inscription = new Inscriptions();
        $inscription->setParticipantInscription($participant);
        $inscription->setSortieInscription($sortie);
        $inscription->setDateInscription(new \DateTime("now"));
        $em->persist($inscription);
        $em->flush();
        if(count($sortie->getInscriptionsSortie()) >= $sortie->getNbinscriptionsmax()){
            $etatSortie = $em->getRepository(Etats::class)->getEtatByLibelle('FERMEE');
            $sortie->setEtatSortie($etatSortie[0]);
            $em->persist($sortie);
            $em->flush();
        }



        $flashbag->add("inscrire", "Vous êtes inscrit à la sortie");
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/sortie/desinscription/{id_sortie}", name="desinscription", requirements={"id_sortie": "\d+"})
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function desinscrireSortie(EntityManagerInterface $em, int $id_sortie, Request $request)
    {
        $participant = $this->getUser();
        $id_participant = $participant->getNoParticipant();
        $flashbag = $this->get('session')->getFlashBag();
        $repoInscription = $em->getRepository(Inscriptions::class);
        $inscription = $repoInscription->getInscriptionBySortieParticipantId($id_sortie,$id_participant);

        $em->remove($inscription);
        $em->flush();

        $flashbag->add("desinscrire", "Vous êtes désincrit de la sortie");

        return $this->redirect($request->headers->get('referer'));
    }
}
