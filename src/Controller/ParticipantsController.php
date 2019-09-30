<?php

namespace App\Controller;

use App\Entity\Participants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ParticipantsController extends Controller{


    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request,
                             UserPasswordEncoderInterface $passwordEncoder,
                             EntityManagerInterface $em)
    {
        $participant = new Participants();
        $form = $this->createForm(RegistrationType::class, $participant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($password);
            $participant->setRoles(['ROLE_USER']);
            $em->persist($participant);
            $em->flush();

            $this->addFlash("success", "The account has been created!");
            return $this->redirectToRoute("login");
        }

        return $this->render("user/register.html.twig", ["form" => $form->createView()]);
    }


}