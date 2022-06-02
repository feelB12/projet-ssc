<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserSessionController extends AbstractController
{
    /**
     * @Route("profile/sessions", name="profile_sessions")
     */

    public function profileSessions(SessionRepository $sessionRepository)
    {
        $sessions = $sessionRepository->findAll();
        return $this->render('profile/sessions.html.twig', [
            'sessions' => $sessions
        ]);
    }
    /**
     * @Route("profile/session/create", name="profile_session_create")
     */
    public function UserCreateSession(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $session = new Session();
        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $sessionForm->get('coverFilename')->getData();

            if ($coverFile) {
                // 2 recupérer le nom du fichiers uploadé
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // 3 renommer le fichier avec un nom unique
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$coverFile->guessExtension();

                // 4 déplacer le fichier dans le dossier publique
                $coverFile->move(
                    $this->getParameter( 'cover_directory'),
                    $newFilename
                );

                // 5 enregistrer le nom du fichier dans la colonne coverFilename
                $session->setCoverFilename($newFilename);
            }
            $entityManager->persist($session);
            $entityManager->flush();
        }
        //$this->addFlash('error', "La session blabla existe déja ou... !");
        $this->addFlash('success', "Le Session a bien été créer !");

        return $this->render('profile/session_create.html.twig',[
            'sessionForm' => $sessionForm->createView()
        ]);
    }
    /**
     * @Route("profile/session/update/{id}", name="profile_session_update")
     */
    public function UserUpdateSession($id, Request $request, SessionRepository $sessionRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $session = $sessionRepository->find($id);

        $sessionForm = $this->createForm(SessionType::class, $session);
        $sessionForm->handleRequest($request);

        if ($sessionForm->isSubmitted() && $sessionForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $sessionForm->get('coverFilename')->getData();

            if ($coverFile) {
                // 2 recupérer le nom du fichiers uploadé
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);

                // 3 renommer le fichier avec un nom unique
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $coverFile->guessExtension();

                // 4 déplacer le fichier dans le dossier publique
                $coverFile->move(
                    $this->getParameter('cover_directory'),
                    $newFilename
                );

                // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                $session->setCoverFilename($newFilename);
            }
            $entityManager->persist($session);
            $entityManager->flush();
        }

        return $this->render('profile/session_update.html.twig',[
            'sessionForm' => $sessionForm->createView()
        ]);
    }
    /**
     * @Route("profile/session/{id}", name="profile_session")
     */
    public function profileSession($id, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);
        return $this->render('profile/session.html.twig', [
            'session' => $session
        ]);
    }
    /**
     * @Route("profile/session/delete/{id}", name="profile_session_delete")
     */
    public function UserDeleteSession($id, EntityManagerInterface $entityManager, SessionRepository $sessionRepository)
    {
        $session = $sessionRepository->find($id);

        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute("profile_sessions");
    }
    /**
     * @Route("profile/search", name="profile_search_sessions")
     */
    public function profileSearchSessions(SessionRepository $sessionRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $sessions = $sessionRepository->searchByTitle($word);

        return $this->render('profile/sessions_search.html.twig', [
            'sessions' => $sessions
        ]);
    }
}