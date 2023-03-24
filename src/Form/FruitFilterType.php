<?php

namespace App\Form;

use App\Entity\Family;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FruitFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setRequired(false)
            ->setMethod(Request::METHOD_GET)
            ->add('page', HiddenType::class, [
                'data' => 1,
            ])
            ->add('name')
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
