<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/articles/insert",name="insert_article")
     */
    public function insertArticle(EntityManagerInterface $entityManager, Request $request)//entityManager est une classe qui gère les entités pour créé ou modifié un article
    {
        // je créé une instance de l'entité Article, afin de la relier
        // à un formulaire de création d'article
        $article = new Article();
        // je récupère le gabarit de formulaire d'Article et je le relie à mon nouvel article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // je récupère les données de POST envoyées par le formulaire grâce
        // à la classe Request, et j'ajoute les données récupérées dans le formulaire
        $articleForm->handleRequest($request);

        // si mon formulaire a été submit et que les données de POST
        // correspondent aux données attendues par l'entité Article
        if ($articleForm -> isSubmitted() && $articleForm -> isValid()){
            // alors je récupère l'entité Article compléter par les données du formulaire
            $article = $articleForm -> getData();

            // et j'enregistre l'article
            $entityManager->persist($article);
            // et je le pousse dans la bdd
            $entityManager->flush();
            
            //si tout ok je redirige vert list_article avec un message flash
            $this->addFlash("success", "L'article ". $article->getTitle() ." à bien était créé.");
            return $this->redirectToRoute('list_article');
        }

        // je récupère (et compile) le fichier twig et je lui envoie le formulaire, transformé
        // en vue (donc exploitable par twig)
        return $this->render('admin/article_insert.html.twig',[
            'articleFormView' => $articleForm->createView()
        ]);

       /* // je créé un nouvel objet que je stock dans une variable
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
        ]);*/
    }

    /**
     * @Route("/admin/articles/update/{id}", name="update")
     */
    public function updateArticle(EntityManagerInterface $entityManager, ArticleRepository $articleRepository, $id)//articleRepository est une classe qui gère les entités pour récupéré un article
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