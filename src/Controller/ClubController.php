<?php

namespace App\Controller;

use App\Entity\Club;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClubController extends AbstractController
{
    /**
     * @Route("/clubs", name="clubs")
     */
    public function clubs(ClubRepository $clubRepository)
    {
        $clubs = $clubRepository->findAll();
        return $this->render('clubs.html.twig', [
            'clubs' => $clubs
        ]);
    }
    /**
     * @Route("/club/{id}", name="club")
     */
    public function club($id, ClubRepository $clubRepository)
    {
        $club = $clubRepository->find($id);
        return $this->render('club.html.twig', [
            'club' => $club
        ]);
    }
}