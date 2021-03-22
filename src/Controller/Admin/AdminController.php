<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/articles/insert",name="insert_article")
     */
    public function insertArticle(EntityManagerInterface $entityManager)
    {
        // je créé un nouvel objet que je stock dans une variable
        $article = new Article();
        //je met toute les valeurs à remplir dans mon INSERT
        $article-> setTitle('admin insert');
        $article->setContent('premier essai');
        $article->setCreatedAt(new \DateTime('NOW'));
        $article->setIsPublished(true);

        //j'enregistre le tout
        $entityManager->persist($article);
        //et j'envoi ma requete
        $entityManager->flush();

        return $this->render('admin_article_insert.html.twig',[
            'insert' => $article
        ]);
    }
}