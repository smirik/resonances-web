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
                 $num = $libration['number'];
                 if (isset($properElements[$num])) {
                     $s = $libration['m1'].$libration['planet1'][0].sprintf("%+d",$libration['m2']).$libration['planet2'][0].sprintf("%+d",$libration['m']);
                     $csv[] = [
                         'number' => $num,
                         'resonance' => $s,
                         'planet1' => $libration['planet1'],
                         'planet2' => $libration['planet2'],
                         'semimajor_axis' => $properElements[$num]['semiAxis'],
                         'eccentricity' => $properElements[$num]['eccentricity'],
                         'sinI' => $properElements[$num]['sini'],
                         'm1' => $libration['m1'],
                         'm2' => $libration['m2'],
                         'm' => $libration['m'],
                         'pure' => $libration['pure'],
                     ];
                 }
             }
             foreach ($res['twoBodyLibrations'] as $libration) {
                 $num = $libration['number'];
                 if (isset($properElements[$num])) {
                     $s = $libration['m1'].$libration['planet1'][0].sprintf("%+d",$libration['m']);
                     $csv[] = [
                         'number' => $num,
                         'resonance' => $s,
                         'planet1' => $libration['planet1'],
                         'planet2' => '',
                         'semimajor_axis' => $properElements[$num]['semiAxis'],
                         'eccentricity' => $properElements[$num]['eccentricity'],
                         'sinI' => $properElements[$num]['sini'],
                         'm1' => $libration['m1'],
                         'm2' => '',
                         'm' => $libration['m'],
                         'pure' => $libration['pure'],
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
