<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function searchByTerm($search)/*je créé une fonction qui va rechercher des mots rentrée par l'utilisateur*/
    {
        /*
         * je stock dans une variable le resultat de createQueryBuilder sur la table alias 'a'(pour article)
         * query builder traduit une requete php en sql, pour créer ses propres requetes
        */
        $queryBuilder = $this->createQueryBuilder('a');
        $query = $queryBuilder
            //je fais un SELECT sur l'alias 'a'(table article)
            ->select('a')
            //si le content
            ->where('a.content LIKE :search')
            //ou le title contiennent un équivalent de la recherche dans 'search'
            ->orWhere('a.title LIKE :search')
            // j'indique que search correspond à la variable $search (donc la recherche du user) entre deux '%' pour rechercher
            // une similitude n'importe ou dans le contenu ou le title (LIKE SQL)
            ->setParameter('search', '%'.$search.'%')
            //je récupère ma requête
            ->getQuery();
            //et je retourne le résultat
        return $query -> getResult();
    }

}
