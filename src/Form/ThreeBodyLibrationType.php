<?php

namespace App\Form;

use App\Entity\ThreeBodyLibration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThreeBodyLibrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('properSemiaxis')
            ->add('problem')
            ->add('pure')
            ->add('planet1')
            ->add('planet2')
            ->add('m1')
            ->add('m2')
            ->add('m')
            ->add('p1')
            ->add('p2')
            ->add('p')
            ->add('resonantSemiaxis')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ThreeBodyLibration::class,
        ]);
    }
}
