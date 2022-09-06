<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Contain;
use App\Entity\Mark;
use App\Entity\Ordered;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findForHomePage()
    {
        return $this->createQueryBuilder('products')
            ->select('products', 'AVG(comments.note) AS average')
            ->join('products.comments', 'comments')
            ->groupBy('products')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBestSellingProducts()
    {
        return $this->createQueryBuilder('product')
            ->select('product', 'AVG(comments.note) AS average')
            ->join(Contain::class, 'contain', Join::WITH, 'contain.products = product')
            ->join('contain.bag', 'bag')
            ->join(Ordered::class, 'ordered', Join::WITH, 'ordered.bag = bag')
            ->join('product.comments', 'comments')
            ->groupBy('product')
            ->orderBy('SUM(contain.quantity)', 'DESC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult();
    }

    public function findLastReleased()
    {
        return $this->createQueryBuilder('product')
            ->select('product, AVG(comments.note) AS average')
            ->join('product.comments', 'comments')
            ->groupBy('product')
            ->orderBy('product.createdAt', 'DESC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult();
    }

    public function getQbAll(): QueryBuilder
    {
        return $this->createQueryBuilder('product')
            ;
    }

    public function getDetailProduct(int $id)
    {
        return $this->createQueryBuilder('product')
            ->select('product, AVG(comments.note) AS average, count(ordered) as totalSell')
            ->leftJoin('product.comments', 'comments')
            ->leftJoin(Contain::class, 'contain', Join::WITH, 'contain.products = product')
            ->leftJoin('contain.bag', 'bag')
            ->leftJoin(Ordered::class, 'ordered', Join::WITH, 'ordered.bag = bag')
            ->leftJoin('product.category', 'category')
            ->leftJoin('category.parentCategory', 'parentCategory')
            ->where('product.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }
}
