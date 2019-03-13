<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Form\Type\PlanetChoiceType;


class ResonanceExportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('csv')
            ->setMethod('POST')
            ->add('planet1', PlanetChoiceType::class, [
                'data' => 'JUPITER',
            ])
            ->add('planet2', PlanetChoiceType::class, [
                'data' => 'SATURN',
            ])
            ->add('twobody', ChoiceType::class, [
                'choices' => [
                    'With Two-Body' => 1,
                    'Without Two-Body' => 0,
                    'Only Two-Body' => -1,
                ],
                'data' => 1,
                'label' => '2-body',
            ])
            ->add('amin', NumberType::class, [
                'label' => "Min a",
                'data' => 2.5,
            ])
            ->add('amax', NumberType::class, [
                'label' => "Max a",
                'data' => 2.6,
            ])
            ->add('emin', NumberType::class, [
                'label' => "Min e",
                'data' => 0.0,
            ])
            ->add('emax', NumberType::class, [
                'label' => "Max e",
                'data' => 0.3,
            ])
            ->add('save', SubmitType::class, ['label' => 'Export CSV'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
