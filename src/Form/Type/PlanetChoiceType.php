<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PlanetChoiceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices'  => [
                'all' => 'all',
                'Mercury' => 'MERCURY',
                'Venus' => 'VENUS',
                'Earth & Moon' => 'EARTHMOO',
                'Mars' => 'MARS',
                'Jupiter' => 'JUPITER',
                'Saturn' => 'SATURN',
                'Uranus' => 'URANUS',
                'Neptune' => 'Neptune',
            ],
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}