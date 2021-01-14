<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    /**
    * @return Commande[] Returns an array of Commande objects
    */
    public function findByUser($user)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.User = :user')
            ->setParameter('user', $user)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    
    public function findCurrentCommandeByUser($user): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.User = :user')
            ->andWhere('c.etat = :notPurchased')
            ->setParameter('user', $user)
            ->setParameter('notPurchased',1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
