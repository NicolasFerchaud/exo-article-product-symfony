<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/articles/insert",name="insert_article")
     */
    public function insertArticle(EntityManagerInterface $entityManager)//entityManager gère les entités pour créé ou modifié un article
    {
        // je créé un nouvel objet que je stock dans une variable
        $article = new Article();
        //je met toute les valeurs à remplir dans mon INSERT
        $article-> setTitle('super article');
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

    /**
     * @Route("/admin/articles/update/{id}", name="update")
     */
    public function updateArticle(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, $id)
    {
        $article = $articleRepository->find($id);//j'enregistre dans une variable l'id d'un article que je recupère en bdd

        if (is_null($article)) {
            throw $this->createNotFoundException('article non trouvée');//si l'id correspond a rien je retourne un message d'erreur
        }

        $article->setContent('première modif');//je fais la MAJ que je souhaite sur mon article

        $entityManager->flush();//j'envoi la requête

        return $this->render('admin_article_update.html.twig',[//je retourne le tout sur une vue html dédié
            'update' => $article
        ]);
    }

    /**
     * @Route("/admin/articles/delete/{id}", name="delete")
     */
    public function deleteArticle($id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);//j'enregistre dans une variable l'id d'un article que je recupère en bdd
        if (is_null($article)) {
            throw $this->createNotFoundException('article non trouvée');//si l'id correspond a rien je retourne un message d'erreur
        }
        $entityManager->remove($article);//je surveille les fichier à effacer
        $entityManager->flush();//j'envoi la requete

        return $this->render('admin_article_delete.html.twig',[
            'delete' => $article
        ]);
    }
}