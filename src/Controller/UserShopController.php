<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserShopController extends AbstractController
{
    /**
     * @Route("profile/shops", name="profile_shops")
     */
    public function profileShops(ShopRepository $shopRepository)
    {
        $shops = $shopRepository->findAll();
        return $this->render('profile/shops.html.twig', [
            'shops' => $shops
        ]);
    }
    /**
     * @Route("profile/shop/create", name="profile_shop_create")
     */
    public function UserCreateShop(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
    {
        $shop = new Shop();
        $shopForm = $this->createForm(ShopType::class, $shop);
        $shopForm->handleRequest($request);

        if ($shopForm->isSubmitted() && $shopForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $shopForm->get('coverFilename')->getData();

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
                $shop->setCoverFilename($newFilename);
            }
            $entityManager->persist($shop);
            $entityManager->flush();
        }
        //$this->addFlash('error', "Le shop existe déja ou... !");
        $this->addFlash('success', "Le Shop a bien été créer !");

        return $this->render('profile/shop_create.html.twig',[
            'shopForm' => $shopForm->createView()
        ]);
    }
    /**
     * @Route("profile/shop/update/{id}", name="profile_shop_update")
     */
    public function UserUpdateShop($id, Request $request, ShopRepository $shopRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $shop = $shopRepository->find($id);

        $shopForm = $this->createForm(ShopType::class, $shop);
        $shopForm->handleRequest($request);

        if ($shopForm->isSubmitted() && $shopForm->isValid()) {
            // gestion de l'upload img
            // 1 recupérer les fichiers uploadé
            $coverFile = $shopForm->get('coverFilename')->getData();

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
                $shop->setCoverFilename($newFilename);
            }
            $entityManager->persist($shop);
            $entityManager->flush();
        }

        return $this->render('profile/shop_update.html.twig',[
            'shopForm' => $shopForm->createView()
        ]);
    }
    /**
     * @Route("profile/shop/{id}", name="profile_shop")
     */
    public function profileShop($id, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);
        return $this->render('profile/shop.html.twig', [
            'shop' => $shop
        ]);
    }
    /**
     * @Route("profile/shop/delete/{id}", name="profile_shop_delete")
     */
    public function UserDeleteShop($id, EntityManagerInterface $entityManager, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);

        $entityManager->remove($shop);
        $entityManager->flush();

        return $this->redirectToRoute("profile_shops");
    }
    /**
     * @Route("profile/search", name="profile_search_shops")
     */
    public function searchShops(ShopRepository $shopRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $shops = $shopRepository->searchByTitle($word);

        return $this->render('profile/shops_search.html.twig', [
            'shops' => $shops
        ]);
    }
}