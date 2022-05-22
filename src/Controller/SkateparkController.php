<?php

namespace App\Controller;

use App\Entity\Skatepark;
use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SkateparkController extends AbstractController
{
    /**
     * @Route("/skateparks", name="skateparks")
     */
    public function skateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
    /**
     * @Route("/skatepark/{id}", name="skatepark")
     */
    public function skatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);
        return $this->render('skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
    /**
     * @Route("/search", name="search_skateparks")
     */
    public function searchSkateparks(SkateparkRepository $skateparkRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $skateparks = $skateparkRepository->searchByTitle($word);

        return $this->render('skateparks_search.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
}