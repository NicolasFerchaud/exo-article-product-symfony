<?php


namespace App\Controller\exo_final;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function categoriesList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findBY(
            ['published' => true]
        );

        return $this->render('exo_final/category_list.html.twig',[
            'categories' => $categories
        ]);
    }
}