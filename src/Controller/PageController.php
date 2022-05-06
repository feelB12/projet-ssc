<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);
    }
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);

    }

}