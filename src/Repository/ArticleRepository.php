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
        $queryBuilder = $this->createQueryBuilder('a');
        $query = $queryBuilder
            ->select('a')
            ->where('a.content LIKE :search')
            ->orWhere('a.title LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->getQuery();

        return $query -> getResult();
    }

}
