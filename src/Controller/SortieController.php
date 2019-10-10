<?php


namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Etats;
use App\Entity\Inscriptions;
use App\Entity\Lieux;
use App\Entity\Sites;
use App\Entity\Sorties;
use App\Entity\Villes;
use App\Form\LieuType;
use App\Form\SortieType;
use App\Form\UpdateSortieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;


class SortieController extends Controller
{

    /**
     * @Route("/sortie/liste", name="liste_sortie")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function afficherListe(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator)
    {
        if ($this->getUser() == null) {
            return $this->redirectToRoute('login');
        } else {
            $repoSorties = $em->getRepository(Sorties::class);
            $repoSites = $em->getRepository(Sites::class);

//            $sortiesTmp = $repoSorties->getSortiesVisible()->getQuery()->getResult();
            $sortiesTmp = $repoSorties->getSortiesVisible()->getQuery();
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

                $sortiesTmp = $repoSorties->getSortieByFiltre($idSite, $nomSortie, $estOrga, $estInscrit, $estPasInscrit, $sortiePassees, $dateDebutSortie, $dateFinSortie, $idUser);
            }

            $sorties = $paginator->paginate(
                $sortiesTmp,
                $request->query->getInt('page', 1),
                5
            );

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
    }

    /**
     * @Route("/sortie/add", name="ajouter_sortie")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $sortie = new Sorties();
        $lieux = new Lieux();
        $etat = null;
        $check_publi = false;

        $form1 = $this->createForm(SortieType::class, $sortie);
        $form2 = $this->createForm(LieuType::class, $lieux);
        $siteUser = $this->getUser()->getSiteParticipant()->getNomSite();

        $form1->handleRequest($request);
        $form2->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $img_sortie = $form1['urlphoto']->getData();
            if ($img_sortie) {
                $originalFilename = pathinfo($img_sortie->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $img_sortie->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $img_sortie->move(
                        $this->getParameter('sortie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $sortie->setUrlphoto($newFilename);
            }

            if ($request->get('btn_enregistrer') == 'enregistrer') {
                $etat = $em->getRepository(Etats::class)->find(4);
                $sortie->setEtatSortie($etat);
            } elseif ($request->get('btn_publier') == 'publier') {
                $etat = $em->getRepository(Etats::class)->find(1);
                $sortie->setEtatSortie($etat);
                $check_publi = true;
            }
            $sortie->setOrganisateurSortie($this->getUser());
            $sortie->setSiteSortie($this->getUser()->getSiteParticipant());
            $em->persist($sortie);
            $em->flush();

            $id = $sortie->getNoSortie();

            if ($check_publi == true) {
                $inscription = new Inscriptions();
                $inscription->setSortieInscription($sortie);
                $inscription->setParticipantInscription($this->getUser());
                $inscription->setDateInscription(new \DateTime('now'));
                $em->persist($inscription);
                $em->flush();
            }
            $this->addFlash('success', 'Sortie successfully saved!');
            return $this->redirectToRoute('detail_sortie', ['id' => $id]);
        }

        if ($request->get('btn_ajouter') == 'Ajouter') {
            if ($form2->isSubmitted() && $form2->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($lieux);
                $em->flush();
                $this->addFlash('success', 'Lieux successfully saved!');
            } else {
                $this->addFlash('error', 'Lieux fail saved!');
            }
        }
        return $this->render('Sortie/creation.html.twig', [
            "SortieForm" => $form1->createView(),
            "LieuxForm" => $form2->createView(),
            "VilleOrga" => $siteUser,
            "AllVille" => $em->getRepository(Villes::class)->findAll()
        ]);
    }

    /**
     * @Route("/sortie/add/change", name="ajax_sortie")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function ajaxSortie(Request $request, EntityManagerInterface $em)
    {
        if ($request->isXmlHttpRequest()) // pour vérifier la présence d'une requete Ajax
        {
            $id = $request->request->get('id');
            $selecteur = $request->request->get('select');

            if ($id != null) {
                $data = $em->getRepository(Lieux::class)->$selecteur($id);
                return new JsonResponse($data);
            }
        }
        $this->addFlash('error', 'NOOOOOOOOOOOOO..........');
        return $this->redirectToRoute('liste_sortie');
    }

    /**
     * @Route("/sortie/update/{id}", name="modifier_sortie", requirements={"id": "\d+"})
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     *
     */
    public function update(Request $request, EntityManagerInterface $em, int $id)
    {
        $sortie = $em->getRepository(Sorties::class)->find($id);
        $lieux = new Lieux();
        $etat = null;
        $check_publi = false;

        $form_up = $this->createForm(UpdateSortieType::class, $sortie);
        $form_down = $this->createForm(LieuType::class, $lieux);

        $form_up->handleRequest($request);
        $form_down->handleRequest($request);

        if ($form_up->isSubmitted() && $form_up->isValid()) {
            $img_sortie = $form_up['urlphoto']->getData();
            if ($img_sortie) {
                $originalFilename = pathinfo($img_sortie->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $img_sortie->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $img_sortie->move(
                        $this->getParameter('sortie_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $sortie->setUrlphoto($newFilename);
            }

            if ($request->get('btn_enregistrer') == 'enregistrer') {
                $etat = $em->getRepository(Etats::class)->find(4);
                $sortie->setEtatSortie($etat);
            } elseif ($request->get('btn_publier') == 'publier') {
                $etat = $em->getRepository(Etats::class)->find(1);
                $sortie->setEtatSortie($etat);
                $check_publi = true;
            }
            $sortie->setOrganisateurSortie($this->getUser());
            $sortie->setSiteSortie($this->getUser()->getSiteParticipant());
            $em->persist($sortie);
            $em->flush();
            if ($check_publi == true) {
                $inscription = new Inscriptions();
                $inscription->setSortieInscription($sortie);
                $inscription->setParticipantInscription($this->getUser());
                $inscription->setDateInscription(new \DateTime('now'));
                $em->persist($inscription);
                $em->flush();
            }
            $this->addFlash('success', 'Sortie successfully saved!');
            return $this->redirectToRoute('detail_sortie', ['id' => $id]);
        }
        if ($request->get('btn_ajouter') == 'Ajouter') {
            if ($form_down->isSubmitted() && $form_down->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($lieux);
                $em->flush();
                $this->addFlash('success', 'Lieux successfully saved!');
            } else {
                $this->addFlash('error', 'Lieux fail saved!');
            }
        }
        return $this->render('Sortie/modification_sortie.html.twig', [
            "SortieForm" => $form_up->createView(),
            "LieuxForm" => $form_down->createView(),
            "AllVille" => $em->getRepository(Villes::class)->findAll(),
            "sortie" => $sortie
        ]);

    }

    /**
     * @Route("/sortie/detail/{id}", name="detail_sortie", requirements={"id": "\d+"})
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
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

    /**
     * @Route("/sortie/annuler/{id}", name="annuler_sortie", requirements={"id": "\d+"})
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function annnulerSortie(EntityManagerInterface $em, Request $request, int $id)
    {
        $sortie = $em->getRepository(Sorties::class)->find($id);
        $etatAnnule = $em->getRepository(Etats::class)->find(7);

        $motifAnnule = $request->request->get('motifAnnuleSortie');

        $sortie->setMotifannulation($motifAnnule);
        $sortie->setEtatSortie($etatAnnule);

        $em->persist($sortie);
        $em->flush();

        return $this->redirectToRoute('detail_sortie', ['id' => $id]);
    }

    /**
     * @Route("/sortie/delete/{id}", name="supprimer_sortie", requirements={"id": "\d+"})
     */
    public function supprimerSortie(EntityManagerInterface $em, Request $request, int $id)
    {
        $sortie = $em->getRepository(Sorties::class)->find($id);

        $em->remove($sortie);
        $em->flush();

        return $this->redirectToRoute('liste_sortie');
    }
}
