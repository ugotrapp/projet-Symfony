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

        $authorPerBooks = 2;
        
        
        $authors = $this->loadAuthors($manager, 500);
        $types = $this->loadTypes($manager);
        $books = $this->loadBooks($manager,$authors,$authorPerBooks,$types, 1000);
        
        $borrowers = $this->loadBorrowers($manager,100);
        $loans = $this->loadLoans($manager, $borrowers, $books, 203);
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

    public function loadAuthors(Objectmanager $manager, int $count){

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
       
        for ($i = 4; $i < $count; $i++) {

            $author = new Author();
            $author->setLastname($this->faker->lastName);
            $author->setFirstname($this->faker->firstNameMale);
           
            
            $manager->persist($author);
            $authors[] = $author;
    
            }
            return $authors;
    }
    public function loadBooks(ObjectManager $manager, array $authors, int $authorPerBooks, array $types, int $count)
    {
        $books = [];
        $authorIndex = 0;
        $typeIndex = 0;
        $type = $types[$typeIndex];
        $booksPertype = 10;

        $book = new Book();
        $book->setTitle('Lorem ipsum dolor sit amet');
        $book->setPublishingYear('2010');
        $book->setNumberOfPages('100');
        $book->setIsbnCode('9785786930024');
        $book->addType($type);
        $author = $authors[0];
        $type = $types[1] ;
        $book->setAuthor($author);

        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Consectetur adipiscing elit');
        $book->setPublishingYear('2011');
        $book->setNumberOfPages('150');
        $book->setIsbnCode('9783817260935');
        $book->addType($type);
        $author = $authors[1];
        $book->setAuthor($author);
        $type = $types[2];
        $manager->persist($book);
        $books[] = $book;

        $book = new Book();
        $book->setTitle('Mihi quidem Antiochum');
        $book->setPublishingYear('2012');
        $book->setNumberOfPages('200');
        $book->setIsbnCode('9782020493727');
        $book->addType($type);
        $author = $authors[2];
        $type = $types[3];
        $book->setAuthor($author);

        $manager->persist($book);
        $books[] = $book;
        

        $book = new Book();
        $book->setTitle('Quem audis satis belle');
        $book->setPublishingYear('2013');
        $book->setNumberOfPages('250');
        $book->setIsbnCode('9794059561353');
        $book->setAuthor($author);
        $book->addType($type);
        $author = $authors[3];
        $type = $types[4];
        $book->setAuthor($author);
        

        $manager->persist($book);
        $books[] = $book;
        

        

        for ($i = 4; $i < $count; $i++) {
            $author = $authors[$authorIndex];
            
            
             if ($i % $authorPerBooks == 0) {
                $authorIndex ++;
            }

        $book = new Book();
        $book->setTitle($this->faker->sentence($nbWords = 5, $variableNbWords = true));
        $book->setPublishingYear($this->faker->year($max = 'now'));
        $book->setNumberOfPages($this->faker->numberBetween($min = 50, $max = 800));
        $book->setIsbnCode($this->faker->isbn13());
        $book->setAuthor($author);
        
        $manager->persist($book);
        $books[] = $book;

        $typesCount = random_int(1, 2);
        $randomTypes = $this->faker->randomElements($types, $typesCount);
        foreach ($randomTypes as $randomType) {
        $book->addType($randomType);

        $manager->persist($book);
        $books[] = $book;
            
        }

        
            }
        return $books;
    }

    

    public function loadTypes(Objectmanager $manager) {

        $types = [];

        $type = new Type();
        $type->setName('poésie');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('nouvelle');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('roman historique');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName("roman d'amour");
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName("roman d'aventure");
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('science fiction');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('fantasy');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('biographie');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('conte');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('temoignages');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('theatre');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('essai');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        $type = new Type();
        $type->setName('journal intime');
        $type->setDescription(NULL);

        $manager->persist($type);
        $types[] = $type;

        return $types;
        
    }
    
    public function loadBorrowers(Objectmanager $manager, int $count){

        $borrowers = [];

        $user = new User();
        $user->setEmail('foo.foo@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname('foo');
        $borrower->setFirstname('foo');
        $borrower->setPhone('123456789');
        $borrower->setActive(true);
        $borrower->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00'));
        $borrower->setModificationDate(NULL);
        $borrower->setUser($user);
        $manager->persist($borrower);
        $borrowers[] = $borrower;

        $user = new User();
        $user->setEmail('bar.bar@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname('bar');
        $borrower->setFirstname('bar');
        $borrower->setPhone('123456789');
        $borrower->setActive(true);
        $borrower->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00'));
        $borrower->setModificationDate(NULL);
        $borrower->setUser($user);
        $manager->persist($borrower);
        $borrowers[] = $borrower;

        $user = new User();
        $user->setEmail('baz.baz@example.com');
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname('baz');
        $borrower->setFirstname('baz');
        $borrower->setPhone('123456789');
        $borrower->setActive(true);
        $borrower->setCreationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2010-01-01 00:00:00'));
        $borrower->setModificationDate(NULL);
        $borrower->setUser($user);
        $manager->persist($borrower);
        $borrowers[] = $borrower;


        for ($i = 3; $i < $count; $i++) {

        $user = new User();
        $user->setEmail($this->faker->email);
        $password = $this->encoder->encodePassword($user, '123');
        $user->setPassword($password);
        $user->setRoles(['ROLE_BORROWER']);
        $manager->persist($user);

        $borrower = new Borrower();
        $borrower->setLastname($this->faker->lastName);
        $borrower->setFirstname($this->faker->firstNameFemale);
        $borrower->setPhone($this->faker->e164PhoneNumber);
        $borrower->setActive($this->faker->boolean);
        $borrower->setCreationDate($this->faker->dateTimeThisYear($max = 'now', $timezone = null));
        $borrower->setModificationDate(NULL);
        $borrower->setUser($user);
        $manager->persist($borrower);
        $borrowers[] = $borrower;
            }
            return $borrowers;
    }

    public function loadLoans(Objectmanager $manager, array $borrowers, array $books, int $count){
        $loan = [];
        $borrowerIndex = 0;
        

        $loan = new Loan();
        $loan->setLoanDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-02-01 10:00:00'));
        $loan->setReturnDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-03-01 10:00:00'));
        $borrower = $borrowers[0];
        $book = $books[0];
            
        $loan->setBorrower($borrower);
        $loan->setBook($book);

        $manager->persist($loan);
        $loans[] = $loan;

        $loan = new Loan(); 
        $loan->setLoanDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-03-01 10:00:00'));
        $loan->setReturnDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-04-01 10:00:00'));
        $borrower = $borrowers[1];
        $book = $books[1];
            
        $loan->setBorrower($borrower);
        $loan->setBook($book);

        $manager->persist($loan);
        $loans[] = $loan;

        $loan = new Loan();
        $loan->setLoanDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-04-01 10:00:00'));
        $loan->setReturnDate(NULL);
        $borrower = $borrowers[2];
        $book = $books[2];
            
        $loan->setBorrower($borrower);
        $loan->setBook($book);

        $manager->persist($loan);
        $loans[] = $loan;

        //$bookIndex = 0;
        //$borrower = 0;

        for ($i = 3; $i < $count; $i++) {
            
            $randomBooks = $this->faker->randomElements($books);
            foreach ($randomBooks as $randomBook) {
                $loan->setBook($randomBook);
                $manager->persist($loan);
                $loans[] = $loan;
                
            }

            $borrowersCount = random_int(1, 5);
            $randomBorrowers = $this->faker->randomElements($borrowers, $borrowersCount);
            foreach ($randomBorrowers as $randomBorrower) {
                $loan->setBorrower($randomBorrower);
                $manager->persist($loan);
                $loans[] = $loan;
                
            }
        
        $loan = new Loan();
        $loan->setLoanDate($this->faker->dateTimeThisYear($max = 'now', $timezone = null));
        $loan_date = $loan->getLoanDate();
        $return_date = \DateTime::createFromFormat('Y-m-d H:i:s', $loan_date->format('Y-m-d H:i:s'));
        $return_date->add(new \DateInterval('P1M'));
        
        $loan->setReturnDate($return_date);
        
        
        $manager->persist($loan);
        $loans[] = $loan;
        }

        return $loans;  
    }


}


    