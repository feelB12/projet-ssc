<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/sessions", name="sessions")
     */

    public function sessions(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('sessions.html.twig', [
            'sessions' => $sessions
        ]);
    }

    /**
     * @Route("/session/{id}", name="session")
     */
    public function session($id, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);
        return $this->render('session.html.twig', [
            'session' => $session
        ]);
    }


}