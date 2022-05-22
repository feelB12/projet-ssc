<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ShopRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function dashboard(SkateparkRepository $skateparkRepository, ClubRepository $clubRepository, ShopRepository $shopRepository,SessionRepository $sessionRepository)
    {
        $lastSkateparks = $skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs = $clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions = $sessionRepository->findBy([], ['id' => 'DESC'], 3);

        return $this->render("admin/dashboard.html.twig", [
            'lastSessions'=> $lastSessions,
            'lastShops'=> $lastShops,
            'lastClubs'=> $lastClubs,
            'lastSkateparks' => $lastSkateparks
        ]);

    }

}