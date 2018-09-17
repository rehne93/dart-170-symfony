<?php

namespace App\Controller;

use App\Forms\SplitItForm;
use App\model\SplitIt;
use App\Utility\SplitItCircle;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SplitItController extends AbstractController
{

    // TODO Handle game ending, save into database and create table
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    private $logger;
    private $currentGame;

    /**
     * @Route("/dart/splitit", name="split_it")
     */
    public function new(Request $request)
    {

        $round = 0;
        $currentTarget = "";
        $this->currentGame = new SplitIt();
        $this->currentGame->setScore(0);

        // TODO Add to new method handling Cookies
        if ($request->cookies->has('score')) {
            $this->currentGame->setCurrentScore($request->cookies->get('score'));
        }
        if ($request->cookies->has('round')) {
            $round = $request->cookies->get('round');
            $currentTarget = SplitItCircle::getCurrentRound($round);
        } else {
            $currentTarget = SplitItCircle::getCurrentRound(0);
        }


        $form = $this->createForm(SplitItForm::class, $this->currentGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleData($form);
        }


        $response = $this->render('split_it/index.html.twig', array(
            'currentScore' => $this->currentGame->getCurrentScore(),
            'form' => $this->createForm(SplitItForm::class, $this->currentGame)->createView(),
            'currentTarget' => $currentTarget
        ));


        // TODO Add to new method handling cookie data
        $response->headers->setCookie(new Cookie('score', $this->currentGame->getCurrentScore()));
        $round++;
        $this->logger->debug("Round " . $round);
        $response->headers->setCookie(new Cookie('round', $round));

        return $response;
    }

    private function handleData($form)
    {
        $result = $form->getData();

        if ($result->getScore() == 0) {
            $this->logger->info("Halve it");
            $this->currentGame->setCurrentScore($this->currentGame->getCurrentScore() * 0.5);
        } else {
            $this->currentGame->setCurrentScore($this->currentGame->getCurrentScore() + $result->getScore());
        }
        $this->logger->info("Calculated score as " . $this->currentGame->getCurrentScore());
    }

}
