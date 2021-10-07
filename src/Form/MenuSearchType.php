<?php


namespace App\Form;

use App\Entity\Menu;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class MenuSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sauce', ChoiceType::class, [
                'expanded' => true,
                'choices' => $this->generateChoiceList($options['sauce'])])

            ->add('base', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => $this->generateChoiceList($options['base'])])

            ->add('drink', ChoiceType::class, [
                'expanded' => true,
                'choices' => $this->generateChoiceList($options['drink'])])

            ->add('extra', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => $this->generateChoiceList($options['extra'])]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'sauce' => null,
            'base' => null,
            'drink' => null,
            'extra' => null
        ]);
    }

    public function generateChoiceList(array $list): array // fonction qui transforme les index en valeurs (pour affichage du form)
    {
        $choiceList = [];
        foreach ($list as $value) {
            $choiceList[$value] = $value;
        }
        return $choiceList;
    }

}