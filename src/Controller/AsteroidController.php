<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\ProperElement;
use App\Entity\ThreeBodyLibration;
use App\Entity\TwoBodyLibration;

class AsteroidController extends AbstractController
{
    /**
     * @Route("/asteroid/show", name="asteroid_show")
     */
    public function show(Request $request)
    {
        $id = (int)$request->query->get('asteroid');

        $properElements = $this->getDoctrine()->getRepository(ProperElement::class)
            ->findOneBy(['number' => $id])
        ;
        $threeBodyLibrations = $this->getDoctrine()->getRepository(ThreeBodyLibration::class)
            ->findBy(['number' => $id])
        ;

        $twoBodyLibrations = $this->getDoctrine()->getRepository(TwoBodyLibration::class)
            ->findBy(['number' => $id])
        ;

        // dump($threeBodyLibrations);
        // dump($twoBodyLibrations);
        // dump($properElements);
        // exit();
        

        return $this->render('asteroid/show.html.twig', [
            'properElements' => $properElements,
            'threeBodyLibrations' => $threeBodyLibrations,
            'twoBodyLibrations' => $twoBodyLibrations,
            'id' => $id,
        ]);
    }
}
