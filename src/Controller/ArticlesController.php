<?php


namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function list_articles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();
        return $this->render('articles.html.twig',[
            'articles'=> $articles
            ]);
    }

    /**
     * @Route("article/{id}", name="article")
     */
    public function article(ArticleRepository $articleRepository, $id)
    {
        $article = $articleRepository->find($id);
        return $this->render('article_detail.html.twig',[
                'article' => $article
            ]);
    }
}