<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("front/sessions", name="sessions")
     */

    public function sessions(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('front/sessions.html.twig', [
            'sessions' => $sessions
        ]);
    }
    /**
     * @Route("front/session/{id}", name="session")
     */
    public function session($id, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);

        // si la session n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($session)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'session' => $session
            ]);
        }
        $session = $sessionRepository->find($id);
        return $this->render('front/session.html.twig', [
            'session' => $session
        ]);
    }
    /**
     * @Route("front/sessions/search", name="search_sessions")
     */
    public function searchSessions(SessionRepository $sessionRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);

        return $this->render('front/sessions_search.html.twig', [
            'sessions' => $sessions
        ]);
    }

}