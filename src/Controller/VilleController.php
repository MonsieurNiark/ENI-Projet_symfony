<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Villes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends Controller
{
    /**
     * @Route("/villes/list", name="villes_list")
     * @IsGranted("ROLE_ADMIN")
     */
    public function list(EntityManagerInterface $em){

        $villes = $em->getRepository(Villes::class)->findAll();


        return $this->render('Villes/list_villes.html.twig',[
            'arrayVilles' => $villes
        ]);
    }


    /**
     * @Route("/villes/add", name="villes_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(EntityManagerInterface $em, Request $request){
        $ville = new Villes();
        var_dump($request->request->get('libelle_ville'));
        $ville->setNomVille($request->request->get('libelle_ville'));
        $ville->setCodePostal($request->request->get('code_postal_ville'));
        $em->persist($ville);
        $em->flush();
        return $this->redirectToRoute('villes_list');
    }

    /**
     * @Route("/villes/delete/{id}", name="villes_delete", requirements={"id"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(EntityManagerInterface $em, String $id){
        $repo = $em->getRepository(Villes::class);
        $ville = $repo->find($id);
        $em->remove($ville);
        $em->flush();
        return $this->redirectToRoute('villes_list');
    }

    /**
     * @Route("/villes/update", name="villes_update")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(EntityManagerInterface $em, Request $request){
        $repo = $em->getRepository(Villes::class);
        $ville = $repo->getVilleByNameAndCP($request->request->get('old_name'),$request->request->get('old_cp') );
        $ville->setNomVille($request->request->get('libelle_ville'));
        $ville->setCodePostal($request->request->get('code_postal_ville'));
        $em->persist($ville);
        $em->flush();
        return $this->redirectToRoute('villes_list');
    }
}