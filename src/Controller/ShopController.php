<?php

namespace App\Controller;

use App\Entity\Shop;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ShopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ShopController extends AbstractController
{
    /**
     * @Route("front/shops", name="shops")
     */
    public function shops(ShopRepository $shopRepository)
    {
        $shops = $shopRepository->findAll();
        return $this->render('front/shops.html.twig', [
            'shops' => $shops
        ]);
    }

    /**
     * @Route("front/shop/{id}", name="shop")
     */
    public function shop($id, ShopRepository $shopRepository)
    {
        $shop = $shopRepository->find($id);

        // si le shop n'a pas été trouvé je renvoi une exception (erreur)
        // pour afficher une erreur 404
        if (is_null($shop)){
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig', [
                'shop' => $shop
            ]);
        }
        $shop = $shopRepository->find($id);
        return $this->render('front/shop.html.twig', [
            'shop' => $shop
        ]);
    }
    /**
     * @Route("front/shops/search", name="search_shops")
     */
    public function searchShops(ShopRepository $shopRepository, Request $request)
    {
        // je récupère ce que tu l'utilisateur a recherché grâce à la classe Request
        $word = $request->query->get('query');

        // je fais ma requête en BDD grâce à la méthode que j'ai créée searchByTitle
        $shops = $shopRepository->searchByTitle($word);

        return $this->render('front/shops_search.html.twig', [
            'shops' => $shops
        ]);
    }
}