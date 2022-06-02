<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class UserSearchController extends AbstractController
{
    /**
     * @Route("profile/searchs", name="search_all")
     */
    public function profileSearchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);


        return $this->render('profile/clubs_search.html.twig', [
            'clubs' => $clubs
        ]);
    }
}