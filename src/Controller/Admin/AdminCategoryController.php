<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="categories_list")
     */
    public function categoriesList(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();

        return $this->render('admin/category_list.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/category/insert", name="admin_category_insert")
     */
    public function insertCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $category = new Category();
        $categoryForm = $this -> createForm(CategoryType::class);
        $categoryForm->handleRequest($request);

        if($categoryForm -> isSubmitted() && $categoryForm -> isValid()){
            $category = $categoryForm ->getData();

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("success", "La category ". $category->getTitle() . " à bien été créée.");
            return $this->redirectToRoute('categories_list');
        }
        return $this->render('admin/category_insert.html.twig',[
            'categoryFormView' => $categoryForm->createView()
        ]);
    }

    /**
     * @Route("/admin/category/update/{id}", name="admin_category_update")
     */
    public function updateCategory(Request $request,
                                   EntityManagerInterface $entityManager,
                                   CategoryRepository $categoryRepository,
                                   $id)
    {
        $category = $categoryRepository->find($id);

        if (is_null($category)) {
            throw $this->createNotFoundException('Categorie non trouvée');
        }

        $categoryForm = $this -> createForm(CategoryType::class, $category);
        $categoryForm->handleRequest($request);

        if($categoryForm -> isSubmitted() && $categoryForm -> isValid()){
            $category = $categoryForm ->getData();

            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("success", "La category ". $category->getTitle() . " à bien été modifiée.");
            return $this->redirectToRoute('categories_list');
        }
        return $this->render('admin/category_update.html.twig',[
            'categoryFormView' => $categoryForm->createView()
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="admin_category_delete")
     */
    public function deleteCategory(CategoryRepository $categoryRepository,EntityManagerInterface $entityManager, $id)
    {
        $category = $categoryRepository->find($id);

        if (is_null($category)) {
            throw $this->createNotFoundException('Categorie non trouvée');
        }

        $entityManager->remove($category);
        $entityManager->flush();

        $this->addFlash("success", "La category ". $category->getTitle() . " à bien été effacée.");
        return $this->redirectToRoute('categories_list');
    }
}