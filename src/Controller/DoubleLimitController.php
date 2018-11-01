<?php

namespace App\Controller;

use App\Forms\DoubleLimitForm;
use App\model\DoubleLimit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DoubleLimitController extends AbstractController
{

    private $currentGame;

    /**
     * @Route("/dart/double", name="double_limit")
     */
    public function new(Request $request)
    {
        $jsonData = $this->loadCookie($request);

        if ($jsonData == null) {
            $this->currentGame = new DoubleLimit();
        } else {
            $this->currentGame = new DoubleLimit();
            $this->currentGame->set($jsonData);
        }
        $form = $this->createForm(DoubleLimitForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $lastEl = array_values(array_slice($this->currentGame->getNumbers(), -1))[0];
            if ($form->get('finished')->isClicked()) {
                $this->currentGame->incrementFinished();
                $this->currentGame->addNumber($lastEl + 10);
            } else if ($form->get('notFinished')->isClicked()) {
                $this->currentGame->incrementNotFinished();
                $this->currentGame->addNumber($lastEl - 1);
            } else if ($form->get('reset')->isClicked()) {
                $this->currentGame = new DoubleLimit();
            }
        }

        $response = $this->render('double_limit/index.html.twig', [
            'form' => $form->createView(),
            'score' => array_values(array_slice($this->currentGame->getNumbers(), -1))[0],
            'finished' => $this->currentGame->getFinished(),
            'notFinished' => $this->currentGame->getNotFinished()
        ]);
        $response->headers->setCookie(new Cookie('score', json_encode($this->currentGame)));
        return $response;
    }


    private function loadCookie(Request $request)
    {
        $splitIt = json_decode($request->cookies->get('score'));
        return $splitIt;
    }
}
