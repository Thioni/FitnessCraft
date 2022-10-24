<?php

namespace App\Repository;

use App\Entity\FeaturesList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FeaturesList>
 *
 * @method FeaturesList|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeaturesList|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeaturesList[]    findAll()
 * @method FeaturesList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeaturesListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeaturesList::class);
    }

    public function save(FeaturesList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FeaturesList $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySearch($search): array
    {
        return $this->createQueryBuilder('fl')
            ->andWhere('fl.structure_id LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('fl.structure_id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
