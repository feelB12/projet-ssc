<?php

namespace App\Controller;

use App\Entity\Skatepark;
use App\Form\SkateparkType;
use App\Repository\SkateparkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function createSkatepark(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $skatepark = new Skatepark();
        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $skateparkForm->get('coverFilename')->getData();

            if ($coverFile) {
                // 2 recupérer le nom du fichiers uploadé
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // 3 renommer le fichier avec un nom unique
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();

                // 4 déplacer le fichier dans le dossier publique
                $coverFile->move(
                    $this->getParameter( 'cover_directory'),
                    $newFilename
                );

                // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                $skatepark->setCoverFilename($newFilename);
            }
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
    public function updateSkatepark($id, Request $request, SkateparkRepository $skateparkRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $skatepark = $skateparkRepository->find($id);

        $skateparkForm = $this->createForm(SkateparkType::class, $skatepark);
        $skateparkForm->handleRequest($request);

        if ($skateparkForm->isSubmitted() && $skateparkForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $skateparkForm->get('coverFilename')->getData();

            if ($coverFile) {
                // 2 recupérer le nom du fichiers uploadé
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // 3 renommer le fichier avec un nom unique
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $coverFile->guessExtension();

                // 4 déplacer le fichier dans le dossier publique
                $coverFile->move(
                    $this->getParameter('cover_directory'),
                    $newFilename
                );

                // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                $skatepark->setCoverFilename($newFilename);
            }
            $entityManager->persist($skatepark);
            $entityManager->flush();
        }
        $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le skatepark a bien été modifié !");

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