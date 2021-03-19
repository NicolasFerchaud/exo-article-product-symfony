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
    public function accueil(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            2
        );
        return $this->render('home.html.twig',[
            'articles'=> $articles
        ]);
    }
}