<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use App\Repository\ShopRepository;
use App\Repository\SkateparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;

class AdminSearchController extends AbstractController
{
    /**
     * @Route("admin/searchs", name="search_all")
     */
    public function searchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);


        return $this->render('admin/clubs_search.html.twig', [
            'clubs' => $clubs
        ]);
    }
}