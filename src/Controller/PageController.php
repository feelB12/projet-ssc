<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Skatepark;
use App\Entity\Club;
use App\Entity\Shop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig');
    }

     /* public function home(SessionRepository $sessionRepository, ShopRepository $shopRepository, ClubRepository $clubRepository, )
        {

        /**$lastSession =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        /**$lastSkatepark =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);*/
        /**$lastShop =$shopRepository->findBy([], ['id' => 'DESC'], 1);
        /**$lastClub =$clubRepository->findBy([], ['id' => 'DESC'], 1);

        return $this->render("home", [
           /** 'lastSession' => $lastSession,
           /** 'lastSkatepark' => $lastSkatepark,
           /** 'lastShop' => $lastShop,
           /** 'lastClub' => $lastClub*/
       /** ]);*/

    /**
     * @Route("/home", name="accueil")
     */
    public function accueil()
    {
        return $this->render( 'home.html.twig');
    }

}