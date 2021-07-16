<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // public function findAllAdmins()
    // {
    //     // return $this->findByRole('ROLE_ADMIN');
    // }

//     /**
//      * @param $role string nom d'un rôle comme 'ROLE_ADMIN', 'ROLE_STUDENT', etc
//      * @return User[] Returns an array of User objects
//      */
    public function findByRole()
    {
        
        return $this->createQueryBuilder('u')
            
            ->andWhere('u.roles LIKE :role')
            ->setParameter('role', "%ROLE_EMPRUNTEUR%")
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
 }
