<?php

namespace App\Controller;

use App\Forms\StatsForm;
use App\model\Stats;
use App\Service\Dart170Service;
use App\Service\PlayerService;
use App\Service\SplitItService;
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
        $d170Service = new Dart170Service($name);
        $splitService = new SplitItService($name);
        $pdf = $this->initializePdf();
        $pdf->SetX($pdf->GetPageWidth() / 2);
        $pdf->Cell(0, 5, $name);
        $pdf->Line(40, $pdf->GetY() + 10, $pdf->GetPageWidth() - 40, $pdf->GetY() + 10);
        $pdf->SetX(10);
        $pdf->SetY($pdf->GetY() + 15);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 5, "Anzahl Runden (170):\t\t\t\t " . $d170Service->getAllTimeAverage());
        $pdf->SetY($pdf->GetY() + 5);
        $pdf->Cell(0, 5, "Durchschnitt Split-Score: \t\t\t\t" . $splitService->getSplitScoreAverage());

        return new Response($pdf->Output(), 200, array('Content-type' => 'application/pdf'));
    }

    private function initializePdf()
    {
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        return $pdf;
    }
}
