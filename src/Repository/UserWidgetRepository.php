<?php

namespace MorgenBord\Core\Repository;

use MorgenBord\Core\Entity\User;
use MorgenBord\Core\Entity\UserWidget;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserWidget|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserWidget|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserWidget[]    findAll()
 * @method UserWidget[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserWidgetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserWidget::class);
    }

    /**
     * Find all user widgets for a user, ordered by position
     *
     * @param User $user
     * @return void
     */
    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.owner = :user')
            ->setParameter('user', $user)
            // ->orderBy('u.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?UserWidget
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
