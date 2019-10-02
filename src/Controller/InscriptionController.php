<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Participants;
use App\Entity\Sorties;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends Controller
{
    /**
     * @Route("/sortie/inscription/{id_participant}/{id_sortie}", name="inscription", requirements={"id_participant": "\d+","id_sortie": "\d+"})
     */
    public function inscrireSortie(Request $request,EntityManagerInterface $em, int $id_participant, int $id_sortie)
    {
        $sortie = $em->getRepository(Sorties::class)->find($id_sortie);
        $participant = $em->getRepository(Participants::class)->find($id_participant);

        $inscription = new Inscriptions();
        $inscription->setParticipantInscription($participant);
        $inscription->setSortieInscription($sortie);
        $inscription->setDateInscription(new \DateTime("now"));

        $em->persist($inscription);
        $em->flush();

        $this->addFlash("success", "Vous êtes inscrit à la sortie");
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/sortie/desinscription/{id_participant}/{id_sortie}", name="desinscription", requirements={"id_participant": "\d+","id_sortie": "\d+"})
     */
    public function desinscrireSortie(EntityManagerInterface $em, int $id_participant, int $id_sortie)
    {
        $sortie = $em->getRepository(Sorties::class)->find($id_sortie);
        $participant = $em->getRepository(Participants::class)->find($id_participant);

        $inscription = new Inscriptions();
        $inscription->setParticipantInscription($participant);
        $inscription->setSortieInscription($sortie);

        $em->remove($inscription);
        $em->flush();

        $this->addFlash("success", "Vous êtes désincrit de la sortie");
        return $this->redirectToRoute("liste_sortie");
    }
}
