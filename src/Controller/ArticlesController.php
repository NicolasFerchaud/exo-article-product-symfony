<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function list_articles(ArticleRepository $articleRepository)//ArticleRepository est une class instanciée dans la methode accueil
    {
        $articles = $articleRepository->findAll();//recupère tous les éléments de la table (requète native)
        return $this->render('articles.html.twig',[//fait un rendu de homeController .twig en .html pour être lu par le navigateur
            'articles'=> $articles//je créé une variable qui à pour valeur le contenu de $articles
            ]);
    }

    /**
     * @Route("article/{id}", name="article")
     */
    public function article(ArticleRepository $articleRepository, $id)//ArticleRepository est une class instanciée dans la methode accueil + wildcard
    {
        $article = $articleRepository->find($id);//recupère un éléments de la table grace à son id (requète native)
        return $this->render('article_detail.html.twig',[//fait un rendu de homeController .twig en .html pour être lu par le navigateur
                'article' => $article//je créé une variable qui à pour valeur le contenu de $articles
            ]);
    }

    /**
     * @Route ("/search/articles", name="search")
     */
    public function search(Request $request, ArticleRepository $articleRepository)
    {
        $search = $request->query->get('search');
        $research = $articleRepository->searchByTerm($search);

        return $this->render('search_articles.html.twig',[
            'search' => $research
        ]);
    }
}