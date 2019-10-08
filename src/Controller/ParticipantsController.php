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

    /**
     * @Route("/gestion/users", name="gestion_users")
     */
    public function afficherListeParticipant(EntityManagerInterface $em){
        $repoParticipant = $em->getRepository(Participants::class);
        $idUser = $this->getUser()->getNoParticipant();
        $otherParticipants = $repoParticipant->getOtherUsers($idUser);
        return $this->render('Participants/liste.html.twig', [
            "listeUsers" => $otherParticipants
        ]);
    }

    /**
     * @Route("/gestion/users/admin/{idUser}", name="devenir_admin", requirements={"idUser": "\d+"}, options = { "expose" = true })
     */
    public function devenirAdmin(EntityManagerInterface $em,int $idUser){
        $user = $em->getRepository(Participants::class)->find($idUser);
        $estAdmin = 1;

        if($user->getAdministrateur() == 1){
            $estAdmin = 0;
        }
        $user->setAdministrateur($estAdmin);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('gestion_users');
    }

    /**
     * @Route("/gestion/users/actif/{idUser}", name="devenir_actif", requirements={"idUser": "\d+"}, options = { "expose" = true })
     */
    public function devenirActif(EntityManagerInterface $em,int $idUser){
        $user = $em->getRepository(Participants::class)->find($idUser);
        $estActif = 1;

        if($user->getActif() == 1){
            $estActif = 0;
        }
        $user->setActif($estActif);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('gestion_users');
    }

    /**
     * @Route("/gestion/users/supprimer/{idUser}", name="supprimer_user", requirements={"idUser": "\d+"})
     */
    public function supprimerParticipant(EntityManagerInterface $em, int $idUser){
        $user = $em->getRepository(Participants::class)->find($idUser);
        $flashbag = $this->get('session')->getFlashBag();

        $em->remove($user);
        $em->flush();

        $flashbag->add("suppressionUser", "Utilisateur supprimé");
        return $this->redirectToRoute('gestion_users');
    }
}