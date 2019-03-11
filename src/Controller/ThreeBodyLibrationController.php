<?php

namespace App\Controller;

use App\Entity\ThreeBodyLibration;
use App\Entity\ProperElement;
use App\Form\ThreeBodyLibrationType;
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
        $repository = $threeBodyLibrations = $this->getDoctrine()->getRepository(ThreeBodyLibration::class);

        $threeBodyLibrations = $repository->find100();
        $stats = $repository->getLibrationsStats();

        return $this->render('three_body_libration/index.html.twig', [
            'three_body_librations' => $threeBodyLibrations,
            'stats' => $stats,
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

            $ae = $finder->getResonantAsteroids($data);

            return $this->render('three_body_libration/find.html.twig', [
                'form' => $form->createView(),
                'ae' => json_encode($ae),
            ]);

        }
    
        return $this->render('three_body_libration/find.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/charts", name="three_body_libration_charts", methods={"GET"})
     */
    public function charts(): Response
    {
        $repository = $threeBodyLibrations = $this->getDoctrine()->getRepository(ThreeBodyLibration::class);

        $aMin = 2.5;
        $aMax = 2.55;
        $librations = $repository->getLibrations(['amin' => $aMin, 'amax' => $aMax, 'planet1' => 'all', 'planet2' => 'all']);

        $resonances = [];
        $properElementsNumbers = [];
        foreach ($librations as $libration) {
            $s = $libration->resonanceToString();
            if (!isset($resonances[$s])) {
                $resonances[$s] = [];
            }
            $resonances[$s][] = $libration->getNumber();
            $properElementsNumbers[] = $libration->getNumber();
        }
        $properElementsNumbers = array_unique($properElementsNumbers);

        $properElementsObjects = $this->getDoctrine()->getRepository(ProperElement::class)
            ->findBy(['number' => $properElementsNumbers]);

        $properElements = [];
        foreach ($properElementsObjects as $properElementObject) {
            $properElements[$properElementObject->getNumber()] = $properElementObject;
        }

        $ae = [];

        $backgroundProperElements = $this->getDoctrine()->getRepository(ProperElement::class)
            ->createQueryBuilder('p')
            ->where('p.semiAxis >= :amin')
            ->andWhere('p.semiAxis <= :amax')
            ->setParameter('amin', $aMin)
            ->setParameter('amax', $aMax)
            ->getQuery()
            ->getResult()
        ;

        $arr = [];
        foreach ($backgroundProperElements as $elem) {
            // $arr[] = ['x' => $elem->getSemiAxis(), 'y' => $elem->getEccentricity()];
            $arr[] = [$elem->getSemiAxis(), $elem->getEccentricity()];
        }
        $ae[] = ['name' => 'background', 'color' => 'rgba(230,230,230,.5)', 'data' => $arr];

        foreach ($resonances as $key => $asteroidsInResonance) {
            $arr = [];
            foreach ($asteroidsInResonance as $asteroidNumber) {
                if (isset($properElements[$asteroidNumber])) {
                    $arr[] = [$properElements[$asteroidNumber]->getSemiAxis(), $properElements[$asteroidNumber]->getEccentricity()];
                }
            }
            $a = rand(0, 255);
            $b = rand(0, 255);
            $c = rand(0, 255);
            $ae[] = ['name' => $key, 'color' => 'rgba('.$a.', '.$b.', '.$c.', .5)', 'data' => $arr];
        }

        return $this->render('three_body_libration/charts.html.twig', [
            'resonances' => $resonances,
            'properElements' => $properElements,
            'ae' => json_encode($ae, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
        ]);
    }

    /**
     * @Route("/charts3d", name="three_body_libration_charts3d", methods={"GET"})
     */
    public function charts3d(): Response
    {
        $repository = $threeBodyLibrations = $this->getDoctrine()->getRepository(ThreeBodyLibration::class);

        $aMin = 2.5;
        $aMax = 2.6;
        $librations = $repository->getLibrations($aMin, $aMax);

        $resonances = [];
        $properElementsNumbers = [];
        foreach ($librations as $libration) {
            $s = $libration->resonanceToString();
            if (!isset($resonances[$s])) {
                $resonances[$s] = [];
            }
            $resonances[$s][] = $libration->getNumber();
            $properElementsNumbers[] = $libration->getNumber();
        }
        $properElementsNumbers = array_unique($properElementsNumbers);

        $properElementsObjects = $this->getDoctrine()->getRepository(ProperElement::class)
            ->findBy(['number' => $properElementsNumbers]);

        $properElements = [];
        foreach ($properElementsObjects as $properElementObject) {
            $properElements[$properElementObject->getNumber()] = $properElementObject;
        }

        $aei = [];

        foreach ($resonances as $key => $asteroidsInResonance) {
            $arr = [];
            foreach ($asteroidsInResonance as $asteroidNumber) {
                if (isset($properElements[$asteroidNumber])) {
                    $arr[] = [$properElements[$asteroidNumber]->getSemiAxis(), $properElements[$asteroidNumber]->getEccentricity(), $properElements[$asteroidNumber]->getSini()];
                }
            }
            $a = rand(0, 200);
            $b = rand(0, 200);
            $c = rand(0, 200);
            $aei[] = ['name' => $key, 'color' => 'rgba('.$a.', '.$b.', '.$c.', .5)', 'data' => $arr];
        }

        return $this->render('three_body_libration/charts3d.html.twig', [
            'resonances' => $resonances,
            'properElements' => $properElements,
            'aei' => json_encode($aei),
        ]);
    }

    /**
     * @Route("/new", name="three_body_libration_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $threeBodyLibration = new ThreeBodyLibration();
        $form = $this->createForm(ThreeBodyLibrationType::class, $threeBodyLibration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($threeBodyLibration);
            $entityManager->flush();

            return $this->redirectToRoute('three_body_libration_index');
        }

        return $this->render('three_body_libration/new.html.twig', [
            'three_body_libration' => $threeBodyLibration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="three_body_libration_show", methods={"GET"})
     */
    public function show(ThreeBodyLibration $threeBodyLibration): Response
    {
        return $this->render('three_body_libration/show.html.twig', [
            'three_body_libration' => $threeBodyLibration,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="three_body_libration_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ThreeBodyLibration $threeBodyLibration): Response
    {
        $form = $this->createForm(ThreeBodyLibrationType::class, $threeBodyLibration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('three_body_libration_index', [
                'id' => $threeBodyLibration->getId(),
            ]);
        }

        return $this->render('three_body_libration/edit.html.twig', [
            'three_body_libration' => $threeBodyLibration,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="three_body_libration_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ThreeBodyLibration $threeBodyLibration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$threeBodyLibration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($threeBodyLibration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('three_body_libration_index');
    }
}
