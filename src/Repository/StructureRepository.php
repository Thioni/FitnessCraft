<?php

namespace App\Repository;

use App\Entity\Structure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Structure>
 *
 * @method Structure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Structure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Structure[]    findAll()
 * @method Structure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structure::class);
    }

    public function save(Structure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Structure $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySearch($search): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :search 
            OR s.manager_firstname LIKE :search 
            OR s.manager_lastname LIKE :search
            OR s.manager_email LIKE :search
            OR s.adress LIKE :search
            OR s.city LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('s.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    // Le DQL ayant apparement un problème avec update utilisé avec un join, j'utilise ici du SQL
     public function changeStatus() 
     {
        $this->getEntityManager()
        ->getConnection()
        ->executeStatement(
          "UPDATE structure
           JOIN franchisee
           ON structure.managed_by_id = franchisee.id
           SET structure.active = 0
           WHERE franchisee.active = 0",

        );
     }

}
