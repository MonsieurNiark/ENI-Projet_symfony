<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Sites;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SitesController extends Controller
{

    /**
     * @Route("/sites/list", name="sites_list")
     * @IsGranted("ROLE_ADMIN")
     */
    public function list(EntityManagerInterface $em){

        $sites = $em->getRepository(Sites::class)->findAll();


        return $this->render('Sites/list_villes.html.twig',[
            'arraySites' => $sites
        ]);
    }
}