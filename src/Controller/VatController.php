<?php

namespace App\Controller;
use App\Entity\Calculation;
use App\Repository\CalculationRepository;
use App\Form\CalcType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response,Request,StreamedResponse};

use Symfony\Component\Routing\Annotation\Route;

class VatController extends AbstractController
{
    /**
     * @Route("/somethingsy ", name="app_vat")
     */
    public function index(CalculationRepository $calculationRepository): Response
    {
        $calculations = $calculationRepository->findAll();
        return $this->render('vat/index.html.twig', [
            'controller_name' => 'VatController',
            'calculations' => $calculations
        ]);
    }
    /**
     * @Route("/", name="vat_calc")
     */
    public function create(Request $request, CalculationRepository $calculationRepository): Response
    {
      $calculations = $calculationRepository->findAll();
      //new calculation object
      $calc = new Calculation();
      //form object for calculation
      $form = $this->createForm(CalcType::class, $calc);
      //
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $cost = $calc->getCost();
        $rate = $calc->getRate();
        //entity manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($calc);
        $vat = ($cost/100) * $rate;
        $total = $cost + $vat;
        $calc->setVat($vat);
        $calc->setTotal($total);
        $em->flush();
        $this->addFlash('success','You will pay £'.number_format($vat,2).' on £'.number_format($cost,2).' at a rate of '.$rate.'%, total including VAT £'.number_format($total,2).'.');
        return $this->redirect('/');
      }





      return $this->render('vat/index.html.twig', [
         'form' => $form->createView(),
         'calculations' => $calculations
      ]);
    }
    /**
     * @Route("/export", name="export")
     */
    public function exportCSV(CalculationRepository $calculationRepository): Response
    {
      $results = $calculationRepository->findAll();
      $response = new StreamedResponse();
         $response->setCallback(
             function () use ($results) {
                 $handle = fopen('php://output', 'r+');
                 foreach ($results as $row) {
                     //array list fields you need to export
                     $data = array(
                         $row->getId(),
                         $row->getCost(),
                         $row->getRate(),
                         $row->getVat(),
                         $row->getTotal()
                     );
                     fputcsv($handle, $data);
                 }
                 fclose($handle);
             }
         );
         $response->headers->set('Content-Type', 'application/force-download');
         $response->headers->set('Content-Disposition', 'attachment; filename="past_calculations.csv"');

         return $response;
     }
}
