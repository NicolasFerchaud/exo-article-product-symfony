<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function accueil(ArticleRepository $articleRepository)//ArticleRepository est une class instanciée dans la methode accueil
    {
        $articles = $articleRepository->findBy(//recupère tous les éléments de la table enfonction de certain paramètre (requète native)
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            2
        );
        return $this->render('home.html.twig',[//fait un rendu de homeController .twig en .html pour être lu par le navigateur
            'articles'=> $articles//je créé une variable qui à pour valkeur le contenu de $articles
        ]);
    }
}