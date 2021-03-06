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

class AdminShopController extends AbstractController
{
    /**
     * @Route("admin/shops", name="admin_shops")
     */
    public function adminShops(ShopRepository $shopRepository)
    {
        $shops = $shopRepository->findAll();
        return $this->render('admin/shops.html.twig', [
            'shops' => $shops
        ]);
    }
    /**
     * @Route("admin/shop/create", name="admin_shop_create")
     */
    public function createShop(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger)
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

        return $this->render('admin/shop_create.html.twig',[
            'shopForm' => $shopForm->createView()
        ]);
    }
    /**
     * @Route("admin/shop/update/{id}", name="admin_shop_update")
     */
    public function updateShop($id, Request $request, ShopRepository $shopRepository, SluggerInterface $slugger, EntityManagerInterface $entityManager)
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

        return $this->render('admin/shop_update.html.twig',[
            'shopForm' => $shopForm->createView()
        ]);
    }
    /**
     * @Route("admin/shop/{id}", name="admin_shop")
     */
    public function adminShop($id, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);
        return $this->render('admin/shop.html.twig', [
            'shop' => $shop
        ]);
    }
    /**
     * @Route("admin/shop/delete/{id}", name="admin_shop_delete")
     */
    public function deleteShop($id, EntityManagerInterface $entityManager, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);

        $entityManager->remove($shop);
        $entityManager->flush();

        return $this->redirectToRoute("admin_shops");
    }
    /**
     * @Route("admin/search", name="admin_search_shops")
     */
    public function searchShops(ShopRepository $shopRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $shops = $shopRepository->searchByTitle($word);

        return $this->render('admin/shops_search.html.twig', [
            'shops' => $shops
        ]);
    }
}