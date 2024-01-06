<?php

namespace App\Repository;

use App\Entity\Royaume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Royaume>
 *
 * @method Royaume|null find($id, $lockMode = null, $lockVersion = null)
 * @method Royaume|null findOneBy(array $criteria, array $orderBy = null)
 * @method Royaume[]    findAll()
 * @method Royaume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoyaumeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Royaume::class);
    }

//    /**
//     * @return Royaume[] Returns an array of Royaume objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Royaume
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    // ACTION 13
    public function countByType($type,$idR){
        $query = $this->getEntityManager()->createQuery("SELECT COUNT(m.id) as compte FROM App\Entity\Monstre m WHERE m.royaume=$idR AND m.type LIKE '$type'");
        return $query->getResult();
    }
}
