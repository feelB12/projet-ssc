<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\SkateparkRepository;
use App\Repository\ClubRepository;
use App\Repository\ShopRepository;
use symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("front/home", name="home")
     */
    public function home(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "front/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'shops' => $lastShops,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'lastShops' =>$lastShops
        ]);
    }
    /**
     * @Route("front/", name="accueil")
     */
    public function accueil(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "front/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);

        }
        /**
         * @Route("front/searchs", name="search_all")
         */
        public function searchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
        {
            // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
            $word = $request->query->get('query');

            // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
            $clubs = $clubRepository->searchByTitle($word);


            return $this->render('clubs_search.html.twig', [
                'clubs' => $clubs
            ]);
        }
    /**
     * @Route("admin/home", name="admin_home")
     */
    public function adminHome(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "admin/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'shops' => $lastShops,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'lastShops' =>$lastShops
        ]);
    }
    /**
     * @Route("admin/", name="admin_accueil")
     */
    public function adminAccueil(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "admin/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);

    }
    /**
     * @Route("admin/searchs", name="admin_search_all")
     */
    public function adminSearchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);


        return $this->render('admin_clubs_search.html.twig', [
            'clubs' => $clubs
        ]);
    }
    /**
     * @Route("profile/home", name="profile_home")
     */
    public function profileHome(ShopRepository $shopRepository, SessionRepository $sessionRepository, SkateparkRepository $skateparkRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 3);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 3);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 3);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 3);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "profile/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'shops' => $lastShops,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'lastShops' =>$lastShops
        ]);
    }
    /**
     * @Route("profile/", name="profile_accueil")
     */
    public function profileAccueil(SkateparkRepository $skateparkRepository, ShopRepository $shopRepository, SessionRepository $sessionRepository, ClubRepository $clubRepository )
    {
        $lastSkateparks =$skateparkRepository->findBy([], ['id' => 'DESC'], 1);
        $lastSessions =$sessionRepository->findBy([], ['id' => 'DESC'], 1);
        $lastClubs =$clubRepository->findBy([], ['id' => 'DESC'], 1);
        $lastShops = $shopRepository->findBy([], ['id' => 'DESC'], 1);

        $skateparks = $skateparkRepository->findAll();
        $sessions = $sessionRepository->findAll();
        $clubs = $clubRepository->findAll();
        $shops = $shopRepository->findAll();

        return $this->render( "profile/home.html.twig", [
            'clubs' => $clubs,
            'skateparks' => $skateparks,
            'sessions' => $sessions,
            'lastClubs' => $lastClubs,
            'lastSkateparks' => $lastSkateparks,
            'lastSessions' => $lastSessions,
            'shops' => $lastShops,
            'lastShops' =>$lastShops
        ]);

    }
    /**
     * @Route("profile/searchs", name="profile_search_all")
     */
    public function profileSearchs(SessionRepository $sessionRepository,ClubRepository $clubRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $clubs = $clubRepository->searchByTitle($word);


        return $this->render('profile_clubs_search.html.twig', [
            'clubs' => $clubs
        ]);
    }
}