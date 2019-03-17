<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

use App\Form\Type\ResonanceExportType;
use App\Resonance\Finder;

use Symfony\Component\HttpFoundation\StreamedResponse;

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
     public function csv(Request $request, Finder $finder, SerializerInterface $serializer): Response
     {
         $form = $this->createForm(ResonanceExportType::class);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
             $data = $form->getData();
             $data['includeBackground'] = false;

             $res = $finder->getResonantAsteroids($data);
             $properElements = $res['properElements'];

             $csv = [];
             foreach ($res['librations'] as $libration) {
                 $num = $libration->getNumber();
                 if (isset($properElements[$num])) {
                     $csv[] = [
                         'number' => $num,
                         'resonance' => $libration->resonanceToString(),
                         'planet1' => $libration->getPlanet1(),
                         'planet2' => $libration->getPlanet2(),
                         'semimajor_axis' => $properElements[$num]->getSemiAxis(),
                         'eccentricity' => $properElements[$num]->getEccentricity(),
                         'sinI' => $properElements[$num]->getSini(),
                         'm1' => $libration->getM1(),
                         'm2' => $libration->getM2(),
                         'm' => $libration->getM(),
                         'pure' => $libration->getPure(),
                     ];
                 }
             }
             foreach ($res['twoBodyLibrations'] as $libration) {
                 $num = $libration->getNumber();
                 if (isset($properElements[$num])) {
                     $csv[] = [
                         'number' => $num,
                         'resonance' => $libration->resonanceToString(),
                         'planet1' => $libration->getPlanet1(),
                         'planet2' => '',
                         'semimajor_axis' => $properElements[$num]->getSemiAxis(),
                         'eccentricity' => $properElements[$num]->getEccentricity(),
                         'sinI' => $properElements[$num]->getSini(),
                         'm1' => $libration->getM1(),
                         'm2' => '',
                         'm' => $libration->getM(),
                         'pure' => $libration->getPure(),
                     ];
                 }
             }

             $response = new StreamedResponse(function () use ( &$csv) {
                 $csvFile = fopen('php://output', 'w+');
                 if (isset($csv[0])) {
                     fputcsv($csvFile,array_keys($csv[0]),';');
                     flush();
                     foreach ($csv as $row) {
                         fputcsv($csvFile, $row, ';');
                         flush();
                     }
                 }
                 fclose($csvFile);
             });

             $response->headers->set('Content-Type', 'text/csv');
             $response->headers->set('Content-Disposition', 'attachment; filename="catalog-'.$data['planet1'].'-'.$data['planet2'].'.csv"');

             return $response;
         }

         return $this->render('export/index.html.twig', [
             'form' => $form->createView(),
         ]);
     }
}
