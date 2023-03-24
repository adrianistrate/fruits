<?php

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    public function save(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllSourceIds(): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb->select('f.sourceId');
        $qb->distinct();

        return $qb->getQuery()->getSingleColumnResult();
    }

    public function prepareForPagination(array $filterData): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb->select('f');

        if ($filterData['name']) {
            $qb->andWhere('f.name LIKE :name');
            $qb->setParameter('name', '%'.$filterData['name'].'%');
        }

        if ($filterData['family']) {
            $qb->andWhere('f.family = :family');
            $qb->setParameter('family', $filterData['family']);
        }

        return $qb->getQuery()->getResult();
    }

    public function findFavorites(array $favorites): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->select('f')
            ->where('f.id IN (:favorites)')
            ->setParameter('favorites', $favorites);

        return $qb->getQuery()->getResult();
    }

    public function getNutritionStats(array $favorites): array
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->select('IFNULL(SUM(f.nutritionsCalories), 0) AS calories, IFNULL(SUM(f.nutritionsCarbohydrates), 0) AS carbohydrates, IFNULL(SUM(f.nutritionsProtein), 0) AS protein, IFNULL(SUM(f.nutritionsFat), 0) AS fat, IFNULL(SUM(f.nutritionsSugar), 0) as sugar')
            ->where('f.id IN (:favorites)')
            ->setParameter('favorites', $favorites);

        return $qb->getQuery()->getSingleResult();
    }
}
