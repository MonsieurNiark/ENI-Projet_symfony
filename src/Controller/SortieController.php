<?php


namespace App\Controller;

use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Sites;
use App\Entity\Sorties;
use App\Entity\Villes;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class SortieController extends Controller
{

    /**
     * @Route("/sortie/liste", name="liste_sortie")
     */
    public function afficherListe(Request $request, EntityManagerInterface $em)
    {
        $repoSorties = $em->getRepository(Sorties::class);
        $repoSites = $em->getRepository(Sites::class);

        $sorties = $repoSorties->getSortiesVisible()->getQuery()->getResult();
        $sites = $repoSites->findAll();
        $idSite = 0;
        $nomSortie = '';
        $estOrga = 0;
        $estInscrit = 0;
        $estPasInscrit = 0;
        $sortiePassees = 0;
        $dateDebutSortie = null;
        $dateFinSortie = null;

        if ($request->isMethod('POST')) {
            $idSite = $request->request->getInt('nomSite');
            $nomSortie = $request->request->get('nomSortie');
            $estOrga = $request->request->getInt('estOrganisateur');
            $estInscrit = $request->request->getInt('estInscrit');
            $estPasInscrit = $request->request->getInt('estPasInscrit');
            $sortiePassees = $request->request->getInt('sortiesPassees');
            $dateDebutSortie = $request->request->get('debutDate');
            $dateFinSortie = $request->request->get('finDate');

            $idUser = $this->getUser()->getNoParticipant();

            $sorties = $repoSorties->getSortieByFiltre($idSite, $nomSortie, $estOrga, $estInscrit, $estPasInscrit, $sortiePassees, $dateDebutSortie,$dateFinSortie,$idUser);
        }
        return $this->render("Sortie/afficher_liste.html.twig",
            [
                "sorties" => $sorties,
                "sites" => $sites,
                "siteId" => $idSite,
                "nomSortie" => $nomSortie,
                "estOrga" => $estOrga,
                "estInscrit" => $estInscrit,
                "estPasInscrit" => $estPasInscrit,
                "sortiesPassees" => $sortiePassees,
                "dateDebut" => $dateDebutSortie,
                "dateFin" => $dateFinSortie
            ]);
    }

    /**
     * @Route("/sortie/add", name="ajouter_sortie")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $sortie = new Sorties();
        $etat = null;

        $form = $this->createForm(SortieType::class, $sortie);

        $siteUser = $this->getUser()->getSiteParticipant()->getNomSite();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($request->get('btn_enregistrer') == 'enregistrer') {
                $etat = $em->getRepository(Etats::class)->find(4);
                $sortie->setEtatSortie($etat);
            } elseif ($request->get('btn_publier') == 'publier') {
                $etat = $em->getRepository(Etats::class)->find(1);
                $sortie->setEtatSortie($etat);
            }
            $sortie->setOrganisateurSortie($this->getUser());
            $sortie->setSiteSortie($this->getUser()->getSiteParticipant());
            $em->persist($sortie);
            $em->flush();

            $this->addFlash('success', 'Sortie successfully saved!');
            return $this->redirectToRoute('liste_sortie');
        }

        return $this->render('Sortie/creation.html.twig', [
            "SortieForm" => $form->createView(),
            "VilleOrga" => $siteUser,
            "AllVille" => $em->getRepository(Villes::class)->findAll()
        ]);
    }

    public function remplisAction(Request $request)
    {

    }

    /**
     * @Route("/sortie/detail/{id}", name="detail_sortie", requirements={"id": "\d+"})
     */
    public function detailSortie(int $id, EntityManagerInterface $em)
    {
        $repo = $em->getRepository(Sorties::class);
        $sortie = $repo->find($id);
        $repoInscription = $em->getRepository(Inscriptions::class);
        $inscriptions = $repoInscription->createQueryBuilder('pi')
            ->andWhere('pi.sortieInscription = :id')
            ->setParameter('id', $sortie->getNoSortie())
            ->getQuery();
        $inscriptions = $inscriptions->execute();


        if (is_null($sortie) || $sortie->getEtatSortie() == "NON_VISIBLE") {
            throw $this->createNotFoundException("Sortie non trouvée");
        }
        return $this->render("Sortie/detail.html.twig", ["sortie" => $sortie, "inscriptions" => $inscriptions]);
    }
}
