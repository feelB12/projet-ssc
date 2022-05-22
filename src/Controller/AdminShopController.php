<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopType;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function createShop(Request $request, EntityManagerInterface $entityManager)
    {
        $shop = new Shop();
        $shopForm = $this->createForm(ShopType::class, $shop);
        $shopForm->handleRequest($request);

        if ($shopForm->isSubmitted() && $shopForm->isValid()) {
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
    public function updateShop($id, Request $request, ShopRepository $shopRepository, EntityManagerInterface $entityManager)
    {
        $shop = $shopRepository->find($id);

        $shopForm = $this->createForm(ShopType::class, $shop);
        $shopForm->handleRequest($request);

        if ($shopForm->isSubmitted() && $shopForm->isValid()) {
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
    public function shop($id, ShopRepository $shopRepository)
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