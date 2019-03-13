<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Form\Type\ResonanceExportType;
use App\Resonance\Finder;

/**
 * @Route("/export")
 */
class ExportController extends AbstractController
{
    /**
     * @Route("/", name="export")
     */
    public function index()
    {
        $form = $this->createForm(ResonanceExportType::class);

        return $this->render('export/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/csv", name="export_csv", methods={"POST"})
     */
     public function csv(Request $request, Finder $finder): Response
     {
         $form = $this->createForm(ResonanceExportType::class);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $data = $form->getData();
             $data['includeBackground'] = false;
             $ae = $finder->getResonantAsteroids($data);
             dump($ae);
             die('Stop');

            return $this->redirectToRoute('export');
         }

         return $this->render('export/index.html.twig', [
             'form' => $form->createView(),
         ]);
     }
}
