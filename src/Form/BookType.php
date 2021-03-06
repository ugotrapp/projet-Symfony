<?php

namespace App\Form;

use App\Entity\Book;
 use App\Entity\Author;
 use App\Entity\Type;
 use Doctrine\ORM\EntityRepository;
 use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('publishing_year')
            ->add('number_of_pages')
            ->add('isbn_code')
            ->add('author', EntityType::class, [
                 
                 'class' => Author::class,
                 
                 'choice_label' => function(Author $author) {
                     return "{$author->getFirstname()} {$author->getLastname()}";
                 },
                 
                 'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('a')
                         ->orderBy('a.firstname', 'ASC')
                         ->orderBy('a.lastname', 'ASC')
                     ;
                 },
             ])

                         
                         ->add('types', EntityType::class, [
                             // On précise que ce champ permet de gérer la relation avec une entité SchoolYear
                                'class' => Type::class,
                             // Le label qui est affiché utilisera le nom de la school year
                                'choice_label' => function(Type $type) {
                                 return "{$type->getName()}";
                             },
                             // Les school years sont triés par ordre croissant (c-à-d alphabétique) du champ name
                                'query_builder' => function (EntityRepository $er) {
                                 return $er->createQueryBuilder('t')
                                     ->orderBy('t.name', 'ASC')
                                 ;
                             },
                             'multiple' => true,
                         ])
             
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
