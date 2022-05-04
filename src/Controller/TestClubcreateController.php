<?php

namespace App\Controller;

use App\Repository\ClubRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Club;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestClubcreateController extends AbstractController
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
    //**
    //* @Route("/club/create", name="club_create")
    //*/
    // public function createClub(EntityManagerInterface $entityManager)
    //{
    // je créé une nouvelle instance de la class Club (de l'entité Club)
    // dans le but de l'enregistrer en bdd
    // Doctrine prendra l'entité avec less valeurs de chacunes des propriétés
    // et créera un enregistreent dans la table Club

    //$club = new Club();$club->setTitle(title:"Rollerbug");
    //$club->setDescription(description: "Rollerbug le club de saint médard en Jalles roller skateboard et street hokey");
    //$club->setAddress(address: "29 Rue William Chaumet,  ");
    //$club->setZippcode(zippcode: "33160");
    //$club->setTown(town: "Saint-Médard-en-Jalles");
    //$club->setArea(area: "Skatepark du Cosec");

    // Une fois l'entité créeé, j'utilise la classe EntityManager
    // je demande à Symfony de l'instancier pour moi (grace au système d'autowire)
    // cette classe me permet de persister mon entité  (de préparer sa sauvegarde
    // en bdd puis d'éffectuer l'enregistrement(génère et execute une requête SQL)
    // $entityManager->persist($club);
    //$entityManager->flush();

    //$entityManager->persist($club);
    //$entityManager->flush();

    //
    //   return $this->render('club_create.html.twig');
    //
    // }
    //
    /// /**
    //
    // * @Route("/club/update/{id}", name="club_update")
    //
    // */
    //
    //public function updateClub($id, ClubRepository $clubRepository, EntityManagerInterface $entityManager)
    //
    //{
    // aller chercher un club (doctrine va me donné un objet une instance de la class book)
    ///$club = $clubRepository->find($id);

    // modifier les valeurs via les setters
    //$club->setTitle(title:'La Brigade');

    // enregistrer en bdd avec entity manager
    //$entityManager->persist($club);
    // $entityManager->flush();
    //dump($club); die;
    //return $this->render('club_update.html.twig');
    //
    //}

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