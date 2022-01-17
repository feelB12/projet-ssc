<?php

namespace App\Controller;

use App\Entity\Skatepark;
use App\Repository\SkateparkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SkateparkController extends AbstractController
{
    /**
     * @Route("/skateparks", name="skateparks")
     */
    public function skateparks(SkateparkRepository $skateparkRepository)
    {
        $skateparks = $skateparkRepository->findAll();
        return $this->render('skateparks.html.twig', [
            'skateparks' => $skateparks
        ]);
    }

    /**
     * @Route("/skatepark/{id}", name="skatepark")
     */
    public function skatepark($id, SkateparkRepository $skateparkRepository)
    {
        $skatepark = $skateparkRepository->find($id);
        return $this->render('skatepark.html.twig', [
            'skatepark' => $skatepark
        ]);
    }
}