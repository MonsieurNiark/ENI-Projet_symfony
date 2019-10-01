<?php


namespace App\Controller;

use App\Entity\Sorties;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class SortieController extends Controller
{

    /**
     * @Route("/sortie/liste", name="liste_sortie")
     */
    public function afficherListe(EntityManagerInterface $em){
        $sorties = $em->getRepository(Sorties::class);

        return $this->render("Sortie/afficher_liste.html.twig",
            [
                "sorties" => $sorties
            ]);
    }

}