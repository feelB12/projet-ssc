<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Entity\Skatepark;
use App\Repository\SkateparkRepository;
use App\Entity\Club;
use App\Repository\ClubRepository;
use App\Entity\Shop;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render( 'home.html.twig');
    }
    /**
     * @Route("/home", name="accueil")
     */
    public function accueil()
    {
        return $this->render( 'home.html.twig');
    }

}