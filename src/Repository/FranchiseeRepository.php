<?php

namespace App\Repository;

use App\Entity\Franchisee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Franchisee>
 *
 * @method Franchisee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Franchisee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Franchisee[]    findAll()
 * @method Franchisee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FranchiseeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Franchisee::class);
    }

    public function save(Franchisee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Franchisee $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
