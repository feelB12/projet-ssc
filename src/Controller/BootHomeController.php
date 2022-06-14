<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\ShopRepository;
use App\Repository\SkateparkRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BootHomeController extends AbstractController
{
    /**
     * @Route("/boothome", name="boot_home")
     */
    public function BootHome(UserRepository $userRepository, SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $last_username =$userRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $users = $userRepository->findAll();
        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "index.html.twig", [
            'clubs' => $clubs,
            'users' => $users,
            'last_username' => $last_username,
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