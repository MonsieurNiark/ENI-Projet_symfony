<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
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
            $participant->setAdministrateur(0);
            $em->persist($participant);
            $em->flush();

            $this->addFlash("success", "The account has been created!");
            return $this->redirectToRoute("register");
        }

        return $this->render("Participants/register.html.twig", ["form" => $form->createView()]);

    }

    /**
     * @Route("/my_account", name="my_account")
     */
    public function myAccount(Request $request, EntityManagerInterface $em){
        $participant = $this->getUser();
        $form = $this->createForm(UpdateAccountType::class,$participant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($participant);
            $em->flush();

            $this->addFlash('succes','Votre compte est bien modifié');
            return $this->redirectToRoute('my_account', ["UpdateForm" => $form->createView()]);
        }

        return $this->render("Participants/my_account.html.twig", ["UpdateForm" => $form->createView()]);
    }



}