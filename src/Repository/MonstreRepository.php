<?php

namespace App\Repository;

use App\Entity\Monstre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Monstre>
 *
 * @method Monstre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monstre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monstre[]    findAll()
 * @method Monstre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonstreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Monstre::class);
    }

//    /**
//     * @return Monstre[] Returns an array of Monstre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Monstre
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    // ACTION 13
    public function listType(){
        $query = $this->getEntityManager()->createQuery("SELECT distinct(m.type) FROM App\Entity\Monstre m");
        return $query->getResult();
    }

    // ACTION 15
    public function listeAll(){
        $query = $this->getEntityManager()->createQuery("SELECT m.id,m.nom,m.type,m.puissance,m.taille,r.nom as nomRoyaume FROM App\Entity\Monstre m, App\Entity\Royaume r WHERE m.royaume=r.id");
        return $query->getResult();
    }

    // ACTION 16
    public function rechercherNom($nom){
        $query = $this->getEntityManager()->createQuery("SELECT m FROM App\Entity\Monstre m WHERE m.nom LIKE '%$nom%'");
        return $query->getResult();
    }

    // ACTION 17
    public function plusFort(){
        $query = $this->getEntityManager()->createQuery("SELECT m FROM App\Entity\Monstre m WHERE m.puissance>=ALL(SELECT m1.puissance FROM App\Entity\Monstre m1 WHERE m1.royaume=m.royaume)");
        return $query->getResult();
    }
}
