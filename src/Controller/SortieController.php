<?php


namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortieFiltreType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class SortieController extends Controller
{

    /**
     * @Route("/sortie/liste", name="liste_sortie")
     */
    public function afficherListe(Request $request, EntityManagerInterface $em){
        $sorties = $em->getRepository(Sorties::class);

        $sortieFiltreForm = $this->createForm(SortieFiltreType::class);
        $sortieFiltreForm->handleRequest($request);

        if($sortieFiltreForm->isSubmitted() && $sortieFiltreForm->isValid()){

            return $this->render("Sortie/afficher_liste.html.twig",
                [
                    "sorties" => $sorties,
                    "sortieFiltreForm" => $sortieFiltreForm->createView()
                ]);
        }

        return $this->render("Sortie/afficher_liste.html.twig",
            [
                "sorties" => $sorties,
                "sortieFiltreForm" => $sortieFiltreForm->createView()
            ]);
    }

}