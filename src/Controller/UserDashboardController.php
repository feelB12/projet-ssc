<?php

namespace App\Controller;


use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\ShopRepository;
use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class UserDashboardController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_dashboard")
     */
    public function userDashboard(SkateparkRepository $skateparkRepository, ClubRepository $clubRepository, ShopRepository $shopRepository,SessionRepository $sessionRepository)
    {
        $lastSkateparks = $skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs = $clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions = $sessionRepository->findBy([], ['id' => 'DESC'], 3);

        return $this->render("profile/dashboard.html.twig", [
            'lastSessions'=> $lastSessions,
            'lastShops'=> $lastShops,
            'lastClubs'=> $lastClubs,
            'lastSkateparks' => $lastSkateparks
        ]);

    }
}