<?php

namespace App\Controller;

use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SkateparkController extends AbstractController
{
    /**
     * @Route("front/skateparks", name="skateparks")
     */
    public function skateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('front/skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
    /**
     * @Route("front/skatepark/{id}", name="skatepark")
     */
    public function skatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);
        return $this->render('front/skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
    /**
     * @Route("front/search", name="search_skateparks")
     */
    public function searchSkateparks(SkateparkRepository $skateparkRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $skateparks = $skateparkRepository->searchByTitle($word);

        return $this->render('front/skateparks_search.html.twig', [
            'skateparks' => $skateparks
        ]);
    }
}