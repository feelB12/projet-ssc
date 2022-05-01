<?php

namespace App\Controller;

use App\Entity\Club;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminClubController extends AbstractController
{
    /**
     * @Route("/club/create", name="club_create")
     */
    public function createClub(EntityManagerInterface $entityManager)
    {
        // je créé une nouvelle instance de la class Club (de l'entité Club)
        // dans le but de l'enregistrer en bdd
        // Doctrine prendra l'entité avec less valeurs de chacunes des propriétés
        // et créera un enregistreent dans la table Club

       // $club = new Club();
      // $club->setTitle(title:"Rollerbug");
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

        return $this->render('club_create.html.twig');
       // return $this->render('clubs_create.html.twig');

    }
}
