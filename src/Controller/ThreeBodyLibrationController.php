<?php

namespace App\Controller;

use App\Entity\ThreeBodyLibration;
use App\Entity\ProperElement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\Type\ResonanceFinderType;

use App\Resonance\Finder;

/**
 * @Route("/librations/threebody")
 */
class ThreeBodyLibrationController extends AbstractController
{
    /**
     * @Route("/", name="three_body_libration_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('three_body_libration/index.html.twig', [
        ]);
    }

    /**
     * @Route("/{planet1}/{planet2}", name="three_body_libration_list", methods={"GET"}, requirements={"planet1": "Mercury|Venus|Earthmoo|Mars|Jupiter|Saturn|Uranus|Neptune","planet2": "Mercury|Venus|Earthmoo|Mars|Jupiter|Saturn|Uranus|Neptune"})
     */
    public function list($planet1, $planet2): Response
    {
        $repository = $this->getDoctrine()->getRepository(ThreeBodyLibration::class);
        $resonances = $repository->getLibrationsForPlanets($planet1, $planet2);

        return $this->render('three_body_libration/list.html.twig', [
            'resonances' => $resonances,
            'planet1' => $planet1,
            'planet2' => $planet2,
        ]);
    }

    /**
     * @Route("/{planet1}/{planet2}/{m1}/{m2}/{m}", name="three_body_libration_show", methods={"GET"}, requirements={"planet1": "Mercury|Venus|Earthmoo|Mars|Jupiter|Saturn|Uranus|Neptune","planet2": "Mercury|Venus|Earthmoo|Mars|Jupiter|Saturn|Uranus|Neptune"})
     */
    public function show($planet1, $planet2, int $m1, int $m2, int $m): Response
    {
        $repository = $this->getDoctrine()->getRepository(ThreeBodyLibration::class);
        $resonances = $repository->getAsteroidsForResonance($planet1, $planet2, $m1, $m2, $m);

        return $this->render('three_body_libration/show.html.twig', [
            'resonances' => $resonances,
            'planet1' => $planet1,
            'planet2' => $planet2,
            'm1' => $m1,
            'm2' => $m2,
            'm' => $m,
        ]);
    }

    /**
     * @Route("/find", name="three_body_libration_find", methods={"GET","POST"})
     */
    public function find(Request $request, Finder $finder): Response
    {
        $form = $this->createForm(ResonanceFinderType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $ae = $finder->getResonantAsteroidsForChart($data);

            return $this->render('three_body_libration/find.html.twig', [
                'form' => $form->createView(),
                'ae' => json_encode($ae),
                'xMin' => $data['amin'],
                'xMax' => $data['amax'],
            ]);

        }

        return $this->render('three_body_libration/find.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
