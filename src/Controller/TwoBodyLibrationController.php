<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\TwoBodyLibration;

/**
 * @Route("/librations/twobody")
 */
class TwoBodyLibrationController extends AbstractController
{
    /**
     * @Route("/{planet1}", name="two_body_libration_list", requirements={"planet1": "Mercury|Venus|Earthmoo|Mars|Jupiter|Saturn|Uranus|Neptune"})
     */
    public function list($planet1) : Response
    {
        $repository = $this->getDoctrine()->getRepository(TwoBodyLibration::class);
        $resonances = $repository->getLibrationsForPlanets($planet1);

        return $this->render('two_body_libration/list.html.twig', [
            'resonances' => $resonances,
            'planet1' => $planet1,
        ]);
    }

    /**
     * @Route("/{planet1}/{m1}/{m}", name="two_body_libration_show", methods={"GET"}, requirements={"planet1": "Mercury|Venus|Earthmoo|Mars|Jupiter|Saturn|Uranus|Neptune"})
     */
    public function show($planet1, int $m1, int $m): Response
    {
        $repository = $this->getDoctrine()->getRepository(TwoBodyLibration::class);
        $resonances = $repository->getAsteroidsForResonance($planet1, $m1, $m);

        return $this->render('two_body_libration/show.html.twig', [
            'resonances' => $resonances,
            'planet1' => $planet1,
            'm1' => $m1,
            'm' => $m,
        ]);
    }

}
