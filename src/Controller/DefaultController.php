<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\Type\ResonanceFinderType;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $form = $this->createForm(ResonanceFinderType::class);

        $planets = ['Mercury', 'Venus', 'Earthmoo', 'Mars', 'Jupiter', 'Saturn', 'Uranus', 'Neptune'];

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'planets' => $planets,
        ]);
    }
}
