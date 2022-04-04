<?php

namespace App\Controller;
use App\Entity\Calculation;
use App\Repository\CalculationRepository;
use App\Form\CalcType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->redirect('/');
      }





      return $this->render('vat/index.html.twig', [
         'form' => $form->createView(),
         'calculations' => $calculations
      ]);
    }
}
