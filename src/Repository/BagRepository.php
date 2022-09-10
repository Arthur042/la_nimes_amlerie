<?php

namespace App\Repository;

use App\Entity\Bag;
use App\Enum\PanierStatusEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bag>
 *
 * @method Bag|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bag|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bag[]    findAll()
 * @method Bag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bag::class);
    }

    public function add(Bag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Bag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Bag[] Returns an array of Bag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bag
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findBagIfNotExpired($user)
    {
        return $this->createQueryBuilder('bag')
            ->where('bag.user = :user')
            ->andWhere('bag.status = :status')
            ->setParameter(':user', $user)
            ->setParameter(':status', PanierStatusEnum::ENCOURS)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBagAndContain(mixed $get)
    {
        return $this->createQueryBuilder('bag')
            ->leftJoin('bag.contains', 'contains')
            ->join('contains.products', 'products')
            ->join('products.mark', 'mark')
            ->where('bag.id = :id')
            ->setParameter(':id', $get)
            ->getQuery()
            ->getResult()
            ;
    }
}