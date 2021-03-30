<?php


namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminArticleController extends AbstractController
{
    /**
     * @Route ("/admin/articles_list", name="articles_list")
     */
    //j'utilise l'auto-wire pour que symfony instancie le repository dans une variable généralement du même nom
    public function list_article(ArticleRepository $articleRepository)
    {
        $article = $articleRepository->findAll();//je récupère les articles grace au repository et je les selectionne tous grace au findALL
        // je récupère (et compile) le fichier twig et je lui envoie le formulaire, transformé en vue
        return $this->render('admin/articles_list.html.twig',[
            'LIST' => $article
        ]);
    }

    /**
     * @Route("/admin/articles/insert",name="admin_article_insert")
     */
    public function insertArticle(
        EntityManagerInterface $entityManager, //entityManager est une classe qui gère les entités pour créé ou modifié un article
        Request $request,//recupère les données en POST
        SluggerInterface $slugger)//SluggerInterface est une classe pour géré les images
    {
        // j'instancie une nouvelle entité Article, afin de la relier
        // à un formulaire de création d'article
        $article = new Article();
        // je récupère le gabarit de formulaire d'Article et je le relie à mon nouvel article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // je récupère les données de POST envoyées par le formulaire grâce
        // à la classe Request, et j'ajoute les données récupérées dans le formulaire
        $articleForm->handleRequest($request);

        // si mon formulaire a été submit et que les données de POST
        // correspondent aux données attendues par l'entité Article
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // alors je récupère l'entité Article compléter par les données du formulaire
            $article = $articleForm->getData();

            //je récupère les donnée de mon images
            $imageFile = $articleForm->get('image')->getData();
            //si j'ai une image
            if ($imageFile) {
                //$imageFilename est un chemin vers le dossier temporaire de l'image
                //je récupère son nom d'origine
                $originalImage = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                //J'enlève les caractère spéciaux avec slug et je la renomme de facon unique grace à une extension
                $safeFilename = $slugger->slug($originalImage);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {//verifie que tout ce passe bien (image bien renommé, bien déplacé etc...)
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {//sinon on retourne une erreur
                    throw $this->createNotFoundException("erreur lors de l'envoi de l'image");
                }
                //j'enregistre mon image avec le nouveau nom dans une variable
                $article->setImage($newFilename);

            }
            // et j'enregistre l'article
            $entityManager->persist($article);
            // et je le pousse dans la bdd
            $entityManager->flush();

            //si tout ok je redirige vers articles_list avec un message flash
            $this->addFlash("success", "L'article " . $article->getTitle() . " à bien était créé.");
            return $this->redirectToRoute('articles_list');
        }
            // je récupère (et compile) le fichier twig et je lui envoie le formulaire, transformé
            // en vue (donc exploitable par twig)
            return $this->render('admin/article_insert.html.twig', [
                'articleFormView' => $articleForm->createView()
            ]);

    }

    /**
     * @Route("/admin/articles/update/{id}", name="admin_article_update")
     */
    //le {id} est une wild-card qui me permet de recuperer facilement un id dans mon URL
    public function updateArticle(EntityManagerInterface $entityManager,
                                  ArticleRepository $articleRepository,
                                  Request $request,
                                  SluggerInterface $slugger,
                                  $id)//articleRepository est une classe qui gère les entités pour récupéré un article
    {
        $article = $articleRepository->find($id);//j'enregistre dans une variable l'id d'un article que je recupère en bdd

        // je récupère le gabarit de formulaire d'Article et je le relie à mon nouvel article
        $articleForm = $this->createForm(ArticleType::class, $article);

        // je récupère les données de POST envoyées par le formulaire grâce
        // à la classe Request, et j'ajoute les données récupérées dans le formulaire
        $articleForm->handleRequest($request);

        // si mon formulaire a été submit et que les données de POST
        // correspondent aux données attendues par l'entité Article
        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            // alors je récupère l'entité Article compléter par les données du formulaire
            $article = $articleForm->getData();

            //récupère les images
            $imageFile = $articleForm->get('image')->getData();
            //Si j'ai une image je récupère son nom d'origine
            if ($imageFile) {
                $originalImage = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                //J'enlève les caractère spéciaux avec slug et je la renomme de facon unique grace à une extension
                $safeFilename = $slugger->slug($originalImage);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {//verifie que tout ce passe bien
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {//sinon on retourne une erreur
                    throw $this->createNotFoundException("erreur lors de l'envoi de l'image");
                }

                $article->setImage($newFilename);

            }
            // et j'enregistre l'article
            $entityManager->persist($article);
            // et je le pousse dans la bdd
            $entityManager->flush();

            //si tout ok je redirige vert list_article avec un message flash
            $this->addFlash("success", "L'article " . $article->getTitle() . " à bien était modifié.");
            return $this->redirectToRoute('articles_list');
        }

        // je récupère (et compile) le fichier twig et je lui envoie le formulaire, transformé
        // en vue (donc exploitable par twig)
        return $this->render('admin/article_update.html.twig', [
            'articleFormView' => $articleForm->createView(),
            'article' => $article//variable article pour recupéré $article ci dessus pour afficher image dans le form update
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

        $this->addFlash("success", "L'article ". $article->getTitle() ." à bien était supprimé.");
        return $this->redirectToRoute('articles_list');
    }
}