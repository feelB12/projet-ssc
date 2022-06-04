<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("front/users", name="users")
     */
    public function users(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('front/users.html.twig', [
            'users' => $users
        ]);
    }
    /**
     * @Route("front/user/{id}", name="user")
     */
    public function user($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        return $this->render('front/user.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("front/search", name="search_users")
     */
    public function searchusers(UserRepository $userRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $users = $userRepository->searchByTitle($word);

        return $this->render('users_search.html.twig', [
            'users' => $users
        ]);
    }
}