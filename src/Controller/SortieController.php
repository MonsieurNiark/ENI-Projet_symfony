<?php


namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortieType;
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

    /**
     * @Route("/sortie/add", name="ajouter_sortie")
     */
    public function add(Request $request, EntityManagerInterface $em) {
        $sortie = new Sorties();

        $form = $this->createForm(SortieType::class,$sortie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($sortie);
            $em->flush();

            $this->addFlash('success', 'Sortie successfully saved!');
            return $this->redirectToRoute('liste_sortie');
        }

        return $this->render('Sortie/creation.html.twig', [
            "SortieForm" => $form->createView()
        ]);
    }

    /**
     * @Route("/sortie/detail/{id}", name="detail_sortie", requirements={"id": "\d+"})
     */
    public function detailSortie(int $id, EntityManagerInterface $em){
        $repo = $em->getRepository(Sorties::class);
        $sortie = $repo->find($id);

        if(is_null($sortie) || $sortie->getEtatSortie() == "NON_VISIBLE"){
            throw $this->createNotFoundException("Sortie non trouvée");
        }
        return $this->render("Sortie/detail.html.twig", ["sortie" => $sortie]);
    }
}