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
     * @Route("/club/create", name="club_create")
     */
    public function createClub(EntityManagerInterface $entityManager)
    {
        return $this->render('club_create.html.twig');
    }
    /**
     * @Route("/club/update/{id}", name="club_update")
     */
    public function updateClub($id, ClubRepository $clubRepository)
    {
        // aller chercher un club (doctrine va me donné un objet une instance de la class book)
        $club = $clubRepository->find($id);
        // modifier les valeurs via les setters

        // enregistrer en bdd avec entity manager
        
        dump($club); die;
        //return $this->render('club_update.html.twig');
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