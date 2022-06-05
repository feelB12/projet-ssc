<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("front/users", name="front_users")
     */
    public function Users(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('front/users.html.twig', [
            'users' => $users
        ]);
    }
    /**
     * @Route("front/user/create", name="front_user_create")
     */
    public function CreateUser(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $user = new user();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $userForm->get('coverFilename')->getData();

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

                // 5 enregistrer le nom du fichier dan sla colonne coverFilename
                $user->setCoverFilename($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le user existe déja ou... !");
        $this->addFlash('success', "L'utilisateur a bien été créer !");

        return $this->render('front/user_create.html.twig',[
            'userForm' => $userForm->createView()
        ]);
    }
    /**
     * @Route("front/user/update/{id}", name="front_user_update")
     */
    public function UpdateUser($id, Request $request, UserRepository $userRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $user = $userRepository->find($id);

        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $userForm->get('coverFilename')->getData();

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
                $user->setCoverFilename($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();

        }
        // $this->addFlash('error', "les champ n'ont pas tous été modifié!");
        $this->addFlash('success', "Le user a bien été modifié !");

        return $this->render('front/user_update.html.twig',[
            'userForm' => $userForm->createView()
        ]);
    }
    /**
     * @Route("front/user/{id}", name="front_user")
     */
    public function user($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        return $this->render('front/user.html.twig', [
            'user' => $user
        ]);
    }
    /**
     * @Route("front/user/delete/{id}", name="front_user_delete")
     */
    public function DeleteUser($id, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute("front_users");
    }
    /**
     * @Route("front/search", name="search_users")
     */
    public function SearchUsers(UserRepository $userRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $users = $userRepository->searchByTitle($word);

        return $this->render('front/users_search.html.twig', [
            'users' => $users
        ]);
    }
}