<?php

namespace App\Controller;


use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\ShopRepository;
use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class SearchController extends AbstractController
{
    /**
     * @Route("front/home/searchs", name="front_search_all")
     */
    public function FrontSearchs(SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository,  ClubRepository $clubRepository, ShopRepository $shopRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);
        $skateparks = $skateparkRepository->searchByTitle($word);
        $clubs = $clubRepository->searchByTitle($word);
        $shops = $shopRepository->searchByTitle($word);


        return $this->render('front/search.html.twig', [
            'sessions' => $sessions,
            'skateparks' => $skateparks,
            'clubs' => $clubs,
            'shop' => $shops,
        ]);
    }
}
