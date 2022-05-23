<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("front/clubs", name="clubs")
     */
    public function clubs(ClubRepository $clubRepository)
    {
        $clubs = $clubRepository->findAll();
        return $this->render('front/clubs.html.twig', [
            'clubs' => $clubs
        ]);
    }
    /**
     * @Route("front/club/{id}", name="club")
     */
    public function club($id, ClubRepository $clubRepository)
    {
        $club = $clubRepository->find($id);
        return $this->render('front/club.html.twig', [
            'club' => $club
        ]);
    }
    /**
     * @Route("front/search", name="search_clubs")
     */
    public function searchClubs(ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);

        return $this->render('clubs_search.html.twig', [
            'clubs' => $clubs
        ]);
    }
}