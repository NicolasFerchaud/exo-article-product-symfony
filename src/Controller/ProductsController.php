<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    public $products = [
                1 => [
                'id' => 1,
                'title' => 'Une machine à laver',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci corporis dolor eum ex exercitationem harum hic inventore iste laboriosam, laborum libero neque nostrum nulla officia porro quod velit voluptatem.',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                2 => [
                'id' => 2,
                'title' => 'Radar',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci corporis dolor eum ex exercitationem harum hic inventore iste laboriosam, laborum libero neque nostrum nulla officia porro quod velit voluptatem.',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                3 => [
                'id' => 3,
                'title' => 'Gobelet',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci corporis dolor eum ex exercitationem harum hic inventore iste laboriosam, laborum libero neque nostrum nulla officia porro quod velit voluptatem.',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                4 => [
                'id' => 4,
                'title' => 'Iphone',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab adipisci corporis dolor eum ex exercitationem harum hic inventore iste laboriosam, laborum libero neque nostrum nulla officia porro quod velit voluptatem.',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                5 => [
                'id' => 5,
                'title' => 'Machine à laver',
                'description' => 'Avec cette machine, vous pourrez nettoyer les pires tâches, même Balkany',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                6 => [
                'id' => 6,
                'title' => 'Radar',
                'description' => 'Retrouvez vos objets perdus, même la fierté de Denis',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                7 => [
                'id' => 7,
                'title' => 'Gobelet',
                'description' => 'blablabla',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ],
                8 => [
                'id' => 8,
                'title' => 'Iphone 12',
                'description' => 'blablabla',
                'image' => 'https://image.darty.com/gros_electromenager/lavage_sechage/lave-linge_hublot/whirlpool_awod4714_t1406074020006A_142108315.jpg'
                ]
                ];
    /**
     * @Route("/products", name="products")
     */
    public function products()
    {
        return $this->render('products.html.twig', [
            'products' => $this->products//$this->product rappel le tableau contenu dans public $products pour éviter la répétition
        ]);
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function product($id)
    {
        $product = $this->products[$id];//$this->product rappel le tableau contenu dans public $products pour éviter la répétition
        return $this->render('product_detail.html.twig',[
            'product' => $product
        ]);
    }
}