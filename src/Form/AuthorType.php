<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname')
            ->add('firstname')
                       
            ->add('books', EntityType::class, [
                 // On précise que ce champ permet de gérer la relation avec des entités Student
                 'class' => Book::class,
                 // Le label qui est affiché utilisera le prénom et le nom du student
                 'choice_label' => function(Book $book) {
                     return "{$book->getTitle()}";
                 },
                 // Nécessaire du côté inverse sinon la relation n'est pas enregitrée après mise à jour.
                 'by_reference' => false,
                 // Les students sont triés par ordre croissant (c-à-d alphabétique) des champs firstname puis lastname.
                 // Si vous voulez trier par lastname puis firstname, inversez les deux lignes orderBy().
                 'query_builder' => function (EntityRepository $er) {
                     return $er->createQueryBuilder('b')
                         ->orderBy('b.title', 'ASC')
                         
                     ;
                 },
                 'multiple' => true,
                 
             ]);

        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
