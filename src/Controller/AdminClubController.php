<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminClubController extends AbstractController
{
    /**
     * @Route("admin/clubs", name="admin_clubs")
     */
    public function clubs(ClubRepository $clubRepository)
    {
        $clubs = $clubRepository->findAll();
        return $this->render('admin/clubs.html.twig', [
            'clubs' => $clubs
        ]);
    }

    /**
     * @Route("admin/club/create", name="admin_club_create")
     */
    public function createClub(Request $request, EntityManagerInterface $entityManager)
    {
        $club = new Club();
        $clubForm = $this->createForm(ClubType::class, $club);
        $clubForm->handleRequest($request);

        if ($clubForm->isSubmitted() && $clubForm->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le club existe déja ou... !");
        $this->addFlash('success', "Le Club a bien été créer !");

        return $this->render('admin/club_create.html.twig',[
            'clubForm' => $clubForm->createView()
        ]);
    }
    /**
     * @Route("admin/club/update/{id}", name="admin_club_update")
     */
    public function updateClub($id, Request $request, ClubRepository $clubRepository, EntityManagerInterface $entityManager)
    {
        $club = $clubRepository->find($id);

        $clubForm = $this->createForm(ClubType::class, $club);
        $clubForm->handleRequest($request);

        if ($clubForm->isSubmitted() && $clubForm->isValid()) {
            $entityManager->persist($club);
            $entityManager->flush();
        }

        return $this->render('admin/club_update.html.twig',[
            'clubForm' => $clubForm->createView()
        ]);
    }
    /**
     * @Route("admin/club/{id}", name="admin_club")
     */
    public function club($id, ClubRepository $clubRepository)
    {
        $club = $clubRepository->find($id);
        return $this->render('admin/club.html.twig', [
            'club' => $club
        ]);
    }
    /**
     * @Route("admin/club/delete/{id}", name="admin_club_delete")
     */
    public function deleteClub($id, EntityManagerInterface $entityManager, ClubRepository $clubRepository)
    {
        $club = $clubRepository->find($id);

        $entityManager->remove($club);
        $entityManager->flush();

        return $this->redirectToRoute("admin_clubs");
    }
    /**
     * @Route("admin/search", name="admin_search_clubs")
     */
    public function searchClubs(ClubRepository $clubRepository, Request $request)
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