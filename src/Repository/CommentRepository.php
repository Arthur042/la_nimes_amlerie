<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 *
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function add(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLastComments()
    {
        return $this->createQueryBuilder('comment')
            ->select('comment, product, user')
            ->join('comment.product', 'product')
            ->join('comment.user', 'user')
            ->orderBy('comment.creationAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findAllCommentWithUser($product)
    {
        return $this->createQueryBuilder('comment')
            ->join('comment.user', 'user')
            ->where('comment.product = :product')
            ->setParameter(':product', $product)
            ->getQuery()
            ->getResult()
            ;
    }
}
