<?php


namespace App\Controller;


use App\Entity\Villes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends Controller
{
    /**
     * @Route("/villes/list", name="villes_list")
     */
    public function list(EntityManagerInterface $em){

        $villes = $em->getRepository(Villes::class)->findAll();


        return $this->render('Villes/list_villes.html.twig',[
            'arrayVilles' => $villes
        ]);
    }


}