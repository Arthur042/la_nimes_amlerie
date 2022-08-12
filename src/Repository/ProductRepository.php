<?php

namespace App\Repository;

use App\Entity\Contain;
use App\Entity\Ordered;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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
            ->select('products', 'comments')
            ->leftJoin('products.comments', 'comments')
            ->setMaxResults(21)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBestSellingProducts()
    {
        return $this->createQueryBuilder('product')
            ->join(Contain::class, 'contain', Join::WITH, 'contain.products = product')
            ->join('contain.bag', 'bag')
            ->join(Ordered::class, 'ordered', Join::WITH, 'ordered.bag = bag')
            ->groupBy('product')
            ->orderBy('SUM(contain.quantity)', 'DESC')
            ->setMaxResults(21)
            ->getQuery()
            ->getResult();
    }
}
