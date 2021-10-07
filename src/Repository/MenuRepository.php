<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Menu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Menu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Menu[]    findAll()
 * @method Menu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    public function findBySauceAndBaseAndDrinkAndExtra(string $sauce, array $base, string $drink, array $extra)
    {
        $qb = $this->createQueryBuilder('m');
        $qb->andWhere('m.sauce LIKE :sauce');
        $qb->setParameter('sauce', $sauce);
        $orValue = $qb->expr()->andX();
        foreach ($base as $value) {
            $orValue->add(
                $qb->expr()->like('m.base', $qb->expr()->literal('%' . $value . '%'))
            );
        }
        $qb->andWhere($orValue);
        $qb->andWhere('m.drink LIKE :drink');
        $qb->setParameter('drink', $drink);
        $orValue = $qb->expr()->andX();
        foreach ($extra as $value) {
            $orValue->add(
                $qb->expr()->like('m.extra', $qb->expr()->literal('%' . $value . '%'))
            );
        }
        $qb->andWhere($orValue);

        return $qb->getQuery()->getResult();
    }

    public function findAllSauces(): array
    {
        $queryBuilder = $this->createQueryBuilder('m')->select(['m.sauce']);
        return array_column($queryBuilder->getQuery()->getArrayResult(), 'sauce');
    }

    public function findAllBases(): array
    {
        $queryBuilder = $this->createQueryBuilder('m')->select(['m.base']);
        return array_column($queryBuilder->getQuery()->getArrayResult(), 'base');
    }

    public function findAllDrink(): array
    {
        $queryBuilder = $this->createQueryBuilder('m')->select(['m.drink']);
        return array_column($queryBuilder->getQuery()->getArrayResult(), 'drink');
    }

    public function findAllExtra(): array
    {
        $queryBuilder = $this->createQueryBuilder('m')->select(['m.extra']);
        return array_column($queryBuilder->getQuery()->getArrayResult(), 'extra');
    }
}
