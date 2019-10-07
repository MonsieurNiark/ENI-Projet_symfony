<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Form\LieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LieuxController extends Controller
{
//    /**
//     * @Route("/sortie/add", name="ajout_lieux")
//     */
//    public function add(Request $request, EntityManagerInterface $em)
//    {
//        $lieux = new Lieux();
//
//        $form = $this->createForm(LieuType::class, $lieux);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $em->persist($lieux);
//            $em->flush();
//
//            $this->addFlash('success', 'Lieux successfully saved!');
//            return $this->redirectToRoute('ajouter_sortie');
//        }
//
//        return $this->render('Sortie/creation.html.twig', [
//            "LieuxForm" => $form->createView(),
//        ]);
//    }
}
