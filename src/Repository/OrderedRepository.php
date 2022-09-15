<?php

namespace App\Repository;

use App\Entity\Contain;
use App\Entity\Ordered;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ordered>
 *
 * @method Ordered|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ordered|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ordered[]    findAll()
 * @method Ordered[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ordered::class);
    }

    public function add(Ordered $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Ordered $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Ordered[] Returns an array of Ordered objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ordered
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function getQbAll(): QueryBuilder
    {
        return $this->createQueryBuilder('ordered')
            ->select('ordered, bag, payment, status, sum(contain.unitPrice*contain.quantity)')
            ->join('ordered.payment', 'payment')
            ->join('ordered.status', 'status')
            ->join('ordered.bag', 'bag')
            ->join('bag.user', 'user')
            ->join(Contain::class, 'contain', Join::WITH, 'contain.bag = bag')
            ->groupBy('ordered')
            ->orderBy('bag.user', 'asc')
            ;
    }

    public function findOneDetail(int $id)
    {
        return $this->createQueryBuilder('ordered')
            ->select('ordered, bag, payment, status, contain, adress, product')
            ->join('ordered.payment', 'payment')
            ->join('ordered.status', 'status')
            ->join('ordered.bag', 'bag')
            ->join('bag.user', 'user')
            ->leftJoin('ordered.billingAdress', 'adress')
            ->join(Contain::class, 'contain', Join::WITH, 'contain.bag = bag')
            ->join('contain.products', 'product')
            ->where('ordered.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findLastOrderOfClient($getId)
    {
        return $this->createQueryBuilder('ordered')
            ->join('ordered.bag', 'bag')
            ->join('bag.user', 'user')
            ->join('ordered.status', 'status')
            ->join('bag.contains', 'contains')
            ->leftJoin('contains.products', 'products')
            ->where('user.id = :id')
            ->setParameter('id', $getId)
            ->orderBy('ordered.creationAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }
}
