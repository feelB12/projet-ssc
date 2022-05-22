<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminSessionController extends AbstractController
{
    /**
     * @Route("admin/sessions", name="admin_sessions")
     */

    public function adminSessions(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('admin/sessions.html.twig', [
            'sessions' => $sessions
        ]);
    }
    /**
     * @Route("admin/session/create", name="admin_session_create")
     */
    public function createSession(Request $request, EntityManagerInterface $entityManager)
    {
        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();
        }
        //$this->addFlash('error', "La session blabla existe déja ou... !");
        $this->addFlash('success', "Le Session a bien été créer !");

        return $this->render('admin/session_create.html.twig',[
            'sessionForm' => $sessionForm->createView()
        ]);
    }
    /**
     * @Route("admin/session/update/{id}", name="admin_session_update")
     */
    public function updateSession($id, Request $request, SessionRepository $sessionRepository, EntityManagerInterface $entityManager)
    {
        $session = $sessionRepository->find($id);

        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();
        }

        return $this->render('admin/session_update.html.twig',[
            'sessionForm' => $sessionForm->createView()
        ]);
    }
    /**
     * @Route("admin/session/{id}", name="admin_session")
     */
    public function adminSession($id, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);
        return $this->render('admin/session.html.twig', [
            'session' => $session
        ]);
    }
    /**
     * @Route("admin/session/delete/{id}", name="admin_session_delete")
     */
    public function deleteSession($id, EntityManagerInterface $entityManager, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);

        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute("admin_sessions");
    }
    /**
     * @Route("admin/search", name="admin_search_sessions")
     */
    public function searchSessions(SessionRepository $sessionRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);

        return $this->render('admin/sessions_search.html.twig', [
            'sessions' => $sessions
        ]);
    }
}