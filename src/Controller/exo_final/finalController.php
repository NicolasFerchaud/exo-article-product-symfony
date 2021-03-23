<?php


namespace App\Controller\exo_final;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class finalController extends AbstractController
{
    /**
     * @Route ("/admin/list_article", name="list_article")
     */
    public function list_article(ArticleRepository $articleRepository)
    {
        $article = $articleRepository->findAll();
        return $this->render('exo_final/list_article.html.twig',[
            'LIST' => $article
        ]);
    }

    /**
     * @Route ("/admin/insert", name="insert")
     */
    public function insert(EntityManagerInterface $entityManager)
    {
        $article = new Article();
        $article->setTitle('title exo FINAL');
        $article->setContent('content exo FINAL');
        $article->setCreatedAt(new \DateTime('NOW'));
        $article->setIsPublished(true);

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->render('exo_final/INSERT.html.twig',[
            'INSERT' => $article
        ]);
    }

    /**
     * @Route ("/admin/update/{id}", name="update")
     */
    public function update(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, $id)
    {
        $article = $articleRepository->find($id);
        if (is_null($article)){
            throw $this->createNotFoundException('article non trouvé');
        }

        $article->setTitle('NEW title FINAL');

        $entityManager->flush();

        return $this->render('exo_final/UPDATE.html.twig',[
            'UPDATE' => $article
        ]);
    }

    /**
     * @Route ("/admin/delete/{id}", name="delete")
     */
    public function delete(ArticleRepository $articleRepository, EntityManagerInterface $entityManager, $id)
    {
        $article = $articleRepository->find($id);
        if (is_null($article)){
            throw $this->createNotFoundException('article non trouvé');
        }

        $entityManager->remove($article);
        $entityManager->flush();

        // après suppression d'un article, j'ajoute un message flash (dans la session)
        // pour l'afficher sur la prochaine page
        $this->addFlash("success", "L'article ". $article->getTitle() ." à bien était supprimé.");
        return $this->redirectToRoute('list_article');
    }
}