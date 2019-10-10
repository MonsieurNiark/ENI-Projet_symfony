<?php


namespace App\DataFixtures;

use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Lieux;
use App\Entity\Participants;
use App\Entity\Sites;
use App\Entity\Sorties;
use App\Entity\Villes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $em){

        $rawSql = "ALTER TABLE etats AUTO_INCREMENT = 1;";
        $em->getConnection()->exec($rawSql);
        $em->flush();
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


        //Creation utilisateurs Nantes
        //admin:admin
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
        $user1->setPhotoProfil("tenor-5d9b52f91012c.gif");
        $password = $this->encoder->encodePassword($user1, $user1->getPassword());
        $user1->setPassword($password);
        $em->persist($user1);
        for($c=2;$c<7;$c++){
            //mdp = 'test'
            $user = new Participants();
            $user->setActif(1);
            $user->setAdministrateur(0);
            $user->setEmail('test'.$c.'@test.test');
            $user->setTelephone("0123456789");
            $user->setPrenom('prenomTest'.$c);
            $user->setNom('nomTest'.$c);
            $user->setSiteParticipant($site1);
            $user->setPhotoProfil("tenor-5d9b52f91012c.gif");
            $user->setUsername('user'.$c);
            $user->setPassword('test');
            $password = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em->persist($user);
        }


        //Creation lieux
        $lieu1 = new Lieux();
        $lieu1->setNomLieu("Melocotton");
        $lieu1->setRue("9 Rue de l'Héronnière");
        $lieu1->setVilleLieu($ville1);
        $lieu1->setLatitude("47.211986");
        $lieu1->setLongitude("-1.561777");
        $lieu2 = new Lieux();
        $lieu2->setNomLieu("Meltdown");
        $lieu2->setVilleLieu($ville1);
        $lieu2->setRue("15 Allée des Tanneurs");
        $lieu2->setLatitude("47.2198");
        $lieu2->setLongitude("-1.55624");
        $lieu3 = new Lieux();
        $lieu3->setNomLieu("Sur-mesure");
        $lieu3->setVilleLieu($ville1);
        $lieu3->setRue("15 Rue Beauregard");
        $lieu3->setLatitude("47.2148");
        $lieu3->setLongitude("-1.55536");

        $em->persist($lieu1);
        $em->persist($lieu2);
        $em->persist($lieu3);

        //Sortie
        $sortie1 = new Sorties();
        $sortie1->setNom("Sortie au Melo");
        $sortie1->setEtatSortie($ouvert);
        $sortie1->setNbinscriptionsmax(10);
        $sortie1->setDatedebut(new \DateTime("2019-10-15 19:00:00"));
        $sortie1->setDatecloture(new \DateTime("2019-10-15 16:00:00"));
        $sortie1->setDescriptioninfos("Jam de Blues");
        $sortie1->setOrganisateurSortie($user1);
        $sortie1->setDuree(60);
        $sortie1->setLieuSortie($lieu1);
        $sortie1->setSiteSortie($site1);

        $sortie2 = new Sorties();
        $sortie2->setNom("Sortie au Meltdown");
        $sortie2->setEtatSortie($ouvert);
        $sortie2->setNbinscriptionsmax(10);
        $sortie2->setDatedebut(new \DateTime("2019-10-15 19:00:00"));
        $sortie2->setDatecloture(new \DateTime("2019-10-15 16:00:00"));
        $sortie2->setDescriptioninfos("Soirée Beer-Pong");
        $sortie2->setOrganisateurSortie($user1);
        $sortie2->setDuree(60);
        $sortie2->setLieuSortie($lieu2);
        $sortie2->setSiteSortie($site1);

        $sortie3 = new Sorties();
        $sortie3->setNom("Sortie au Sur-Mesure");
        $sortie3->setEtatSortie($ouvert);
        $sortie3->setNbinscriptionsmax(10);
        $sortie3->setDatedebut(new \DateTime("2019-10-15 19:00:00"));
        $sortie3->setDatecloture(new \DateTime("2019-10-15 16:00:00"));
        $sortie3->setDescriptioninfos("Biere au sur-mesure");
        $sortie3->setOrganisateurSortie($user1);
        $sortie3->setDuree(60);
        $sortie3->setLieuSortie($lieu3);
        $sortie3->setSiteSortie($site1);

        $em->persist($sortie1);
        $em->persist($sortie2);
        $em->persist($sortie3);

        $em->flush();
        //Inscription

        $inscr1 = new Inscriptions();
        $inscr1->setSortieInscription($sortie1);
        $inscr1->setParticipantInscription($user1);
        $inscr1->setDateInscription(new \DateTime("2019-10-15 15:00:00"));

        $inscr2 = new Inscriptions();
        $inscr2->setSortieInscription($sortie1);
        $inscr2->setParticipantInscription($em->getRepository(Participants::class)->findOneBy(array('pseudo' => 'user2')));
        $inscr2->setDateInscription(new \DateTime("2019-10-15 15:00:00"));
        $inscr3 = new Inscriptions();
        $inscr3->setSortieInscription($sortie1);
        $inscr3->setParticipantInscription($em->getRepository(Participants::class)->findOneBy(array('pseudo' => 'user3')));
        $inscr3->setDateInscription(new \DateTime("2019-10-15 15:00:00"));
        $inscr4 = new Inscriptions();
        $inscr4->setSortieInscription($sortie1);
        $inscr4->setParticipantInscription($em->getRepository(Participants::class)->findOneBy(array('pseudo' => 'user4')));
        $inscr4->setDateInscription(new \DateTime("2019-10-15 15:00:00"));
        $inscr5 = new Inscriptions();
        $inscr5->setSortieInscription($sortie1);
        $inscr5->setParticipantInscription($em->getRepository(Participants::class)->findOneBy(array('pseudo' => 'user5')));
        $inscr5->setDateInscription(new \DateTime("2019-10-15 15:00:00"));

        $inscr6 = new Inscriptions();
        $inscr6->setSortieInscription($sortie2);
        $inscr6->setParticipantInscription($user1);
        $inscr6->setDateInscription(new \DateTime("2019-10-15 15:00:00"));

        $em->persist($inscr1);
        $em->persist($inscr2);
        $em->persist($inscr3);
        $em->persist($inscr4);
        $em->persist($inscr5);
        $em->persist($inscr6);


        //Events
        $rawSql = "SET GLOBAL event_scheduler = 1;";
        $em->getConnection()->exec($rawSql);

         try{
             $rawSql= "DROP EVENT IF EXISTS `ENCOURS_TO_TERMINEE`";
             $em->getConnection()->exec($rawSql);
             $rawSql = "CREATE DEFINER=`root`@`localhost` EVENT `ENCOURS_TO_TERMINEE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 6 WHERE DATE_ADD(`datedebut`, INTERVAL `duree` MINUTE) <=  NOW() AND `etat_sortie_id`=5$$";
             $em->getConnection()->exec($rawSql);
        } catch (Exception $e){

        }
       try{
           $rawSql= "DROP EVENT IF EXISTS `OUVERT_TO_FERMETURE`";
           $em->getConnection()->exec($rawSql);
           $rawSql = "CREATE DEFINER=`root`@`localhost` EVENT `OUVERT_TO_FERMETURE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 10:18:40' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 2 WHERE `datecloture` <=  NOW() AND `etat_sortie_id`=1$$";
           $em->getConnection()->exec($rawSql);
        } catch (Exception $e){

        }
        try{
            $rawSql= "DROP EVENT IF EXISTS `FERMETURE_TO_ENCOURS`";
            $em->getConnection()->exec($rawSql);
            $rawSql = "CREATE DEFINER=`root`@`localhost` EVENT `FERMETURE_TO_ENCOURS` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 5 WHERE `datedebut` <= NOW() AND `etat_sortie_id`=2$$";
            $em->getConnection()->exec($rawSql);
        } catch (Exception $e){

        }
        try{

            $rawSql= "DROP EVENT IF EXISTS `TERMINEE_TO_NONVISIBLE`";
            $em->getConnection()->exec($rawSql);
            $rawSql = "CREATE DEFINER=`root`@`localhost` EVENT `TERMINEE_TO_NONVISIBLE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 3 WHERE DATE_ADD(DATE_ADD(`datedebut`, INTERVAL `duree` MINUTE),INTERVAL 1 MONTH) <= NOW() AND `etat_sortie_id`=6$$";
            $em->getConnection()->exec($rawSql);
        } catch (Exception $e){

        }
        try{
            $rawSql= "DROP EVENT IF EXISTS `OUVERT_TO_ENCOURS`";
            $em->getConnection()->exec($rawSql);
            $rawSql = "CREATE DEFINER=`root`@`localhost` EVENT `OUVERT_TO_ENCOURS` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 10:18:32' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 5 WHERE `datedebut` <= NOW() AND `etat_sortie_id`=1$$";
            $em->getConnection()->exec($rawSql);
        } catch (Exception $e){

        }
        try{
            $rawSql= "DROP EVENT IF EXISTS `ANNULEE_TO_NONVISIBLE`";
            $em->getConnection()->exec($rawSql);
            $rawSql = "CREATE DEFINER=`root`@`localhost` EVENT `ANNULEE_TO_NONVISIBLE` ON SCHEDULE EVERY 5 SECOND STARTS '2019-10-07 10:18:25' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `sorties` SET etat_sortie_id = 3 WHERE DATE_ADD(`datedebut`, INTERVAL 1 MONTH) <= NOW() AND `etat_sortie_id`=7$$";
            $em->getConnection()->exec($rawSql);

        } catch (Exception $e){

        }
        $em->flush();
    }

    public function getEma(){
        return $this->ema;
    }
}