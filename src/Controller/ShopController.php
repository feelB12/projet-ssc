<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Repository\ShopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="shops")
     */
    public function shops(ShopRepository $shopRepository)
    {
        $shops = $shopRepository->findAll();
        return $this->render('shops.html.twig', [
            'shops' => $shops
        ]);
    }

    /**
     * @Route("/shop/{id}", name="shop")
     */
    public function shop($id, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);
        return $this->render('shop.html.twig', [
            'shop' => $shop
        ]);
    }
}