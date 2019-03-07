<?php

namespace App\Controller;

use App\Entity\ThreeBodyLibration;
use App\Form\ThreeBodyLibrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $stats = $repository->getResonancesStats();

        return $this->render('three_body_libration/index.html.twig', [
            'three_body_librations' => $threeBodyLibrations,
            'stats' => $stats,
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
