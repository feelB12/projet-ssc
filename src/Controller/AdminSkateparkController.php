<?php

namespace App\Controller;

use App\Entity\Skatepark;
use App\Form\SkateparkType;
use App\Repository\SkateparkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminSkateparkController extends AbstractController
{
    /**
     * @Route("admin/skateparks", name="admin_skateparks")
     */
    public function skateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('admin/skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
    /**
     * @Route("admin/skatepark/create", name="admin_skatepark_create")
     */
    public function createSkatepark(Request $request, EntityManagerInterface $entityManager)
    {
        $skatepark = new Skatepark();
        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            $entityManager->persist($skatepark);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le skatepark existe déja ou... !");
        $this->addFlash('success', "Le Skatepark a bien été créer !");

        return $this->render('admin/skatepark_create.html.twig',[
            'skateparkForm' => $skateparkForm->createView()
        ]);
    }
    /**
     * @Route("admin/skatepark/update/{id}", name="admin_skatepark_update")
     */
    public function updateSkatepark($id, Request $request, SkateparkRepository $skateparkRepository, EntityManagerInterface $entityManager)
    {
        $skatepark = $skateparkRepository->find($id);

        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            $entityManager->persist($skatepark);
            $entityManager->flush();
        }

        return $this->render('admin/skatepark_update.html.twig',[
            'skateparkForm' => $skateparkForm->createView()
        ]);
    }
    /**
     * @Route("admin/skatepark/{id}", name="admin_skatepark")
     */
    public function skatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);
        return $this->render('admin/skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
    /**
     * @Route("admin/skatepark/delete/{id}", name="admin_skatepark_delete")
     */
    public function deleteSkatepark($id, EntityManagerInterface $entityManager, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);

        $entityManager->remove($skatepark);
        $entityManager->flush();

        return $this->redirectToRoute("admin_skateparks");
    }
    /**
     * @Route("admin/search", name="admin_search_skateparks")
     */
    public function searchSkateparks(SkateparkRepository $skateparkRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $skateparks = $skateparkRepository->searchByTitle($word);

        return $this->render('admin/skateparks_search.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
}