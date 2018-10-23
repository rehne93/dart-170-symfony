<?php

namespace App\Controller;

use App\Forms\StatsForm;
use App\model\Stats;
use Fpdf\Fpdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsGenerationController extends AbstractController
{
    /**
     * @Route("/dart/stats", name="stats_generation")
     */
    public function new(Request $request)
    {
        $stats = new Stats();

        $form = $this->createForm(StatsForm::class, $stats);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $result = $form->getData();
            return $this->redirectToRoute('stats_generation_name', array('name' => $result->getUser()));
        }


        $response = $this->render('stats_generation/index.html.twig', array('form' => $form->createView()));
        return $response;
    }

    /**
     * @Route("/dart/stats/generate/{name}", name="stats_generation_name")
     */
    public function generate($name)
    {
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Hello ' . $name . '!');

        return new Response($pdf->Output(), 200, array('Content-type' => 'application/pdf'));
    }
}
