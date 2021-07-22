<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    // /**
    //   * @return Book[] Returns an array of Book objects
    //   */
    
    public function findByType($value)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.types', 't')
            ->andWhere('t.name LIKE :type')
            ->setParameter('type', "%{$value}%")
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAuthor($id)
    {
        return $this->createQueryBuilder('b')
        ->innerJoin('b.author', 'a')
        ->andWhere('a.lastname = :author')
        ->setParameter('author', $id)
        ->orderBy('b.title', 'ASC')
        ->getQuery()
        ->getResult()
        ; 
    }
        // ->innerJoin('p.user', 'u')
        //     ->andWhere('p.user = :user')
        //      ->andWhere('u.roles LIKE :role')
        //      ->setParameter('user', $user)
        //      ->setParameter('role', "%{$role}%")
        //     ->getQuery()
        //     ->getOneOrNullResult()
        //  ;
    

    public function findByTitle($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title LIKE :title')
            ->setParameter('title', "%{$value}%")
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByRole(string $role)
     {
         return $this->createQueryBuilder('u')
             ->andWhere('u.roles LIKE :role')
             ->setParameter('role', "%{$role}%")
             ->orderBy('u.email', 'ASC')
             ->getQuery()
             ->getResult()
        ;
    }

    public function findByTitleOrAuthorLastnameAndFirstname($value)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.author', 'a')
            ->andWhere('a.lastname LIKE :author')
            ->orWhere('b.title LIKE :title')
            ->orWhere('a.firstname LIKE :author')
            ->orWhere('b.publishing_year LIKE :publishing_year')
            ->setParameter('title', "%{$value}%")
            ->setParameter('author', "%{$value}%")
            ->setParameter('publishing_year', "%{$value}%")
            ->orderBy('b.title', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
 }
    
    

