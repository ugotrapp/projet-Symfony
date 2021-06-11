<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Borrower;
use App\Entity\Loan;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = FakerFactory::create('fr_FR');
    }
    
    public function load(ObjectManager $manager)
    
    {
        $this->loadAdmins($manager);
        
        $books = $this->loadBooks($manager, 1000);
        $this->loadAuthors($manager);
        $manager->flush();
    }
    public function loadAdmins(ObjectManager $manager)
    {
        
        $user = new User();
        $user->setEmail('admin@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
    }
    public function loadBooks(ObjectManager $manager, int $count)
    {
        $books = [];

        $book = new Book();
        $book->setTitle('Lorem ipsum dolor sit amet');
        $book->setPublishingYear('2010');
        $book->setNumberOfPages('100');
        $book->setIsbnCode('9785786930024');

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Consectetur adipiscing elit');
        $book->setPublishingYear('2011');
        $book->setNumberOfPages('150');
        $book->setIsbnCode('9783817260935');

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Mihi quidem Antiochum');
        $book->setPublishingYear('2012');
        $book->setNumberOfPages('200');
        $book->setIsbnCode('9782020493727');

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Quem audis satis belle');
        $book->setPublishingYear('2013');
        $book->setNumberOfPages('250');
        $book->setIsbnCode('9794059561353');

        $manager->persist($book);
        $books[] = $book;

        for ($i = 4; $i < $count; $i++) {

        $book = new Book();
        $book->setTitle($this->faker->sentence($nbWords = 5, $variableNbWords = true));
        $book->setPublishingYear($this->faker->year($max = 'now'));
        $book->setNumberOfPages($this->faker->numberBetween($min = 50, $max = 800));
        $book->setIsbnCode($this->faker->isbn13());
        
        $manager->persist($book);
        $books[] = $book;

        }
        return $books;
    }

    public function loadAuthors(Objectmanager $manager){

        $authors = [];

        $author = new Author();
        $author->setLastname('auteur inconnu');
        $author->setFirstname('');

        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Cartier');
        $author->setFirstname('Hugues');

        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Lambert');
        $author->setFirstname('Armand');

        $manager->persist($author);
        $authors[] = $author;

        $author = new Author();
        $author->setLastname('Moitessier');
        $author->setFirstname('Thomas');

        $manager->persist($author);
        $authors[] = $author;
       

    }
      

}
    