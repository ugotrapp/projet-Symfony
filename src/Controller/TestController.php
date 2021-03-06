<?php

namespace App\Controller;

use App\Entity\Loan;
use App\Entity\User;
use App\Entity\Book;
use App\Repository\UserRepository;
use App\Repository\BookRepository;
use App\Repository\LoanRepository;
use App\Repository\TypeRepository;
use App\Repository\AuthorRepository;
use App\Repository\BorrowerRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(
        UserRepository $userRepository,
        BorrowerRepository $borrowerRepository,
        BookRepository $bookRepository,
        AuthorRepository $authorRepository,
        TypeRepository $typeRepository,
        LoanRepository $loanRepository
        ): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        ### Les utilisateurs

        // - la liste complète de tous les utilisateurs (de la table `user`)
        $user = $userRepository->findAll();
        dump($user);

        // - les données de l'utilisateur dont l'email est `foo.foo@example.com`
        $user = $userRepository->findOneBy(['email'=>'foo.foo@example.com']);
        dump($user);

        // - les données de l'utilisateur dont l'id est `1`
        $user = $userRepository->find(1);
        dump($user);

        //  les données des utilisateurs dont l'attribut `roles` contient le mot clé `ROLE_EMPRUNTEUR
        $borrowerRole = $userRepository->findByRole('ROLE_BORROWER');
        dump($borrowerRole);
        
        ### Les emprunteurs

        // - la liste complète des emprunteurs
        $borrower = $borrowerRepository->findAll();
        dump($borrower);

        // $borrower = $borrowerRepository->find(3);
        dump($borrower);

        // - les données de l'emprunteur qui est relié au user dont l'id est `3`
        $borrower = $borrowerRepository->findOneByUser(3);
        dump($borrower);

        // - la liste des emprunteurs dont le nom ou le prénom contient le mot clé `foo`
        $borrower = $borrowerRepository->findByFirstnameOrLastname('foo');
        dump($borrower);

        // - la liste des emprunteurs dont le téléphone contient le mot clé `1234`
        $borrower = $borrowerRepository->findByPhone('1234');
        dump($borrower);

        // - la liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit)
        $borrower = $borrowerRepository->findOneByDate('2021-03-01');
        dump($borrower);

        // - la liste des emprunteurs inactifs (c-à-d dont l'attribut `actif` est égal à `false`)
        $borrowerInactif = $borrowerRepository->findByActive(false);
        dump($borrowerInactif);

        ### Les livres

        // - la liste complète de tous les livres
        $book = $bookRepository->findAll();
        dump($book);
        // - les données du livre dont l'id est `1`
        $book = $bookRepository->find(1);
        dump($book);
        // - la liste des livres dont le titre contient le mot clé `lorem`
        $book = $bookRepository->findByTitle('lorem');
        dump($book);
        // - la liste des livres dont l'id de l'auteur est `2`
        $books = $bookRepository->findByAuthor(2);
        dump($books);
        // - la liste des livres dont le genre contient le mot clé `roman`
        $books = $bookRepository->findByType('roman');
        
        foreach($books as $book){
                foreach($book->getTypes() as $type){
                       dump($type);
                }
                dump(null);
        }


        $authors=$authorRepository->findAll();
        $types=$typeRepository->findAll();
        // - ajouter un nouveau livre
        $book = new Book();
        // - titre : Totum autem id externum
        $book->setTitle('Totum autem id externum');
        // - année d'édition : 2020
        $book->setPublishingYear('2020');
        // - nombre de pages : 300
        $book->setNumberOfPages(300);
        // - code ISBN : 9790412882714
        $book->setIsbnCode('9790412882714');    
        // - auteur : Hugues Cartier (id `2`)
        $book->setAuthor($authors[1]);
        

// - genre : science-fiction (id `6`)
        $book->addType($types[5]);
        // - modifier le livre dont l'id est `2`
        $bookIdTwo = $bookRepository->find(2);
        // - titre : Aperiendum est igitur
        $bookIdTwo->setTitle('Aperiendum est igitur');
        // - genre : roman d'aventure (id `5`)
        $bookIdTwo->addType($types[4]);
        $entityManager->persist($bookIdTwo);
        $entityManager->flush();
        dump($bookIdTwo);

        dump($book);

        // - supprimer le livre dont l'id est `123`
        // $removeBook= $bookRepository->findById(123);
        // $entityManager->remove($removeBook[0]);
        // $entityManager->flush();
        // dump($removeBook);

        // emprunteurs dont la date de création est antérieure au 01/03/2021 exclu
        $borrower = $borrowerRepository->findOneByDate('2021-03-01');
        dump($borrower);

        // emprunteurs inactifs
        $borrowerInactif = $borrowerRepository->findByActive(false);
        dump($borrowerInactif);
         // emprunts 
        // la liste des 10 derniers emprunts au niveau chronologique :
        $loans = $loanRepository->findByLoan();
        dump($loans);

        // emprunts de l'emprunteur dont l'id est 2
        $borrowerIdTwo = $loanRepository->findByBorrower(2);
        dump($borrowerIdTwo);

        // emprunts du livre dont l'id est 3
        $bookIdThree = $loanRepository->findByBook(3);
        dump($bookIdThree);

        // emprunts qui ont été retournés avant le 01/01/2021
        $loan = $loanRepository->findByReturnDate('2021-01-01');
        dump($loan);

        // emprunts qui n'ont pas encore été retournés
        // $NotReturnLoan = $loanRepository->findByReturnDate();
        // dump($loan);

        // emprunt du livre dont l'id est 3 et qui n'a pas encore été retournés
        $loan = $loanRepository->findByIdAndReturnDate(3);
        dump($loan);

        // création emprunts 
        
        // récupération de tous les emprunteurs et livres
        $borrowers = $borrowerRepository->findAll();
        $books = $bookRepository->findAll();

        $loan = new Loan();
        $loan->setLoanDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-01 16:00:00'));
        $loan->setBorrower($borrowers[0]);
        $loan->setBook($books[0]);
        $entityManager->persist($loan);
        $entityManager->flush();
        dump($loan);

        // mise à jour emprunt
        $loan = $loanRepository->findOneById(3);
        $loan->setReturnDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2020-05-01 10:00:00'));
        $entityManager->persist($loan);
        $entityManager->flush();
        dump($loan);

        // supprimer l'emprunt dont l'id est 42
        // $loan = $loanRepository->findOneById(3);
        // $entityManager->remove($loan);
        // $entityManager->flush();
        // dump($loan);

        exit();
            

    }
           
}
