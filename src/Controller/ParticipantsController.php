<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\RegistrationType;
use App\Form\UpdateAccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ParticipantsController extends Controller
{


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
    public function myAccount(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $participant = $this->getUser();
        $form = $this->createForm(UpdateAccountType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form['photoProfil']->getData();
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('photo_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $participant->setPhotoProfil($newFilename);
            }
            $password = $passwordEncoder->encodePassword($participant, $participant->getPassword());
            $participant->setPassword($password);
            $em->persist($participant);
            $em->flush();

            $this->addFlash('succes', 'Votre compte est bien modifié');
            return $this->redirectToRoute('my_account');
        }

        return $this->render("Participants/my_account.html.twig", ["UpdateForm" => $form->createView()]);
    }


    /**
     * @Route("/user/{pseudo}",name="user_profile", requirements={"pseudo"})
     */
    public function detailParticipant(String $pseudo, EntityManagerInterface $em){
        $repo = $em->getRepository(Participants::class);
        $participant = $repo->createQueryBuilder('p')
            ->andWhere('p.pseudo like :pseudo')
            ->setParameter('pseudo',$pseudo)
            ->getQuery();
        $participant = $participant->execute();

        if(is_null($participant[0]) || !$participant[0]->getActif()){
            throw $this->createNotFoundException("L'utilisateur n'existe pas");
        }
        return $this->render("Participants/user_detail.html.twig", ["user" => $participant[0]]);
    }
}