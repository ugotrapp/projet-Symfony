<?php

namespace App\Form;

use App\Entity\Loan;
use App\Entity\Borrower;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Book;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('loan_date')
            ->add('return_date')
                       
            ->add('Book', EntityType::class, [
                
                 'class' => Book::class,
                 
                 'choice_label' => function(Book $book) {
                     return "{$book->getTitle()}";
                 },
                 
                 'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('b')
                         ->orderBy('b.title', 'ASC')
                     ;
                 },
             ])

                          // Déclaration d'un champ EntityType
            ->add('borrower', EntityType::class, [
                // On précise que ce champ permet de gérer la relation avec une entité SchoolYear
                'class' => Borrower::class,
                // Le label qui est affiché utilisera le nom de la school year
                'choice_label' => function(Borrower $borrower) {
                    return "{$borrower->getFirstname()} {$borrower->getLastname()}";
                },
                // Les school years sont triés par ordre croissant (c-à-d alphabétique) du champ name
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.lastname', 'ASC')
                    ;
                },
            ])
             
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
