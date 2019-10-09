<?php


namespace App\DataFixtures;

use App\Entity\Etats;
use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function load(EntityManager $em, UserPasswordEncoderInterface $passwordEncoder){
        //Creation des etats
        $ouvert = new Etats();
        $ouvert->setLibelle("OUVERT");
        $ferme = new Etats();
        $ferme->setLibelle("FERMEE");
        $non_visible = new Etats();
        $non_visible->setLibelle("NON_VISIBLE");
        $en_creation = new Etats();
        $en_creation->setLibelle("EN_CREATION");
        $en_cours = new Etats();
        $en_cours->setLibelle("EN_COURS");
        $terminee = new Etats();
        $terminee->setLibelle("TERMINEE");
        $annulee = new Etats();
        $annulee->setLibelle("ANNULEE");

        $em->persist($ouvert);
        $em->persist($ferme);
        $em->persist($non_visible);
        $em->persist($en_creation);
        $em->persist($en_cours);
        $em->persist($terminee);
        $em->persist($annulee);

        $em->flush();

        //Creation des sites
        $site1 = new Sites();
        $site1->setNom_Site("Saint-Herblain");
        $site2 = new Sites();
        $site2->setNom_Site("Quimper");
        $site3 = new Sites();
        $site3->setNom_Site("Rennes");
        $em->persist($site1);
        $em->persist($site2);
        $em->persist($site3);

        $em->flush();

        //Creation des villes
        $ville1 = new Villes();
        $ville1->setNomVille("Nantes");
        $ville1->setCodePostal("44000");
        $ville2 = new Villes();
        $ville2->setNomVille("Carquefou");
        $ville2->setCodePostal("44470");
        $ville3 = new Villes();
        $ville3->setNomVille("Vertou");
        $ville3->setCodePostal("44120");

        $ville4 = new Villes();
        $ville4->setNomVille("Rennes");
        $ville4->setCodePostal("35000");
        $ville5 = new Villes();
        $ville5->setNomVille("Quimper");
        $ville5->setCodePostal("29000");
        $ville6 = new Villes();
        $ville6->setNomVille("Pluguffan");
        $ville6->setCodePostal("29700");

        $em->persist($ville1);
        $em->persist($ville2);
        $em->persist($ville3);
        $em->persist($ville4);
        $em->persist($ville5);
        $em->persist($ville6);

        $em->flush();

        //Creation utilisateurs Nantes
        //Admin
        $user1 = new Participants();
        $user1->setActif(1);
        $user1->setAdministrateur(1);
        $user1->setEmail('test@test.test');
        $user1->setTelephone("0123456789");
        $user1->setPrenom('prenomTest1');
        $user1->setNom('nomTest1');
        $user1->setSiteParticipant($site1);
        $user1->setUsername('admin');
        $user1->setPassword('admin');
        $password = $passwordEncoder->encodePassword($user1, $user1->getPassword());
        $user1->setPassword($password);
        $em->persist($user1);
        for($c=2;$c<7;$c++){
            //mdp = 'test'
            $user = new Participants();
            $user->setActif(1);
            $user->setAdministrateur(1);
            $user->setEmail('test'.$c.'@test.test');
            $user->setTelephone("0123456789");
            $user->setPrenom('prenomTest'.$c);
            $user->setNom('nomTest'.$c);
            $user->setSiteParticipant($site1);
            $user->setUsername('user'.$c);
            $user->setPassword('test');
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
        }

        $em->flush();







    }
}