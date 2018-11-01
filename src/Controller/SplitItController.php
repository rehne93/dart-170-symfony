<?php

namespace App\Controller;

use App\Forms\SplitItForm;
use App\model\SplitIt;
use App\Utility\Authorizer;
use App\Utility\SplitItCircle;
use PlayerQuery;
use Propel\Runtime\Exception\PropelException;
use Psr\Log\LoggerInterface;
use SplitScore;
use SplitScoreQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SplitItController extends AbstractController
{

    private $logger;

    private $currentGame;
    private $playerName = "";
    private $average = -1;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    // TODO Make refresh no submit.
    // TODO Validate Score.

    /**
     * @Route("/dart/splitit", name="split_it")
     */
    public function new(Request $request)
    {
        $auth = new Authorizer();
        $this->playerName = $auth->isAuthorized($request);
        if ($this->playerName === '') {
            return $this->redirectToRoute('new_player');
        }

        $this->average = $this->calculateAverage();


        $jsonData = $this->loadSplitItGame($request);
        if ($jsonData == null) {
            $this->currentGame = new SplitIt();
            $this->currentGame->setCurrentRound(0);
            $this->currentGame->setScore(0);
        } else {
            $game = new SplitIt();
            $game->set($jsonData);
            $this->currentGame = $game;
        }

        $form = $this->createForm(SplitItForm::class, $this->currentGame);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleData($form);
        }

        $response = $this->render('split_it/index.html.twig', array(
            'currentScore' => $this->currentGame->getCurrentScore(),
            'form' => $this->createForm(SplitItForm::class, $this->currentGame)->createView(),
            'currentTarget' => $this->convertRoundToString($this->convertCurrentRound()),
            'name' => $this->playerName,
            'alert' => false,
            'msg' => "",
            'average' => $this->average
        ));


        if ($this->currentGame->getCurrentRound() == 0) {
            $response = $this->render('split_it/index.html.twig', array(
                'currentScore' => 40,
                'form' => $this->createForm(SplitItForm::class, $this->currentGame)->createView(),
                'currentTarget' => $this->convertRoundToString($this->convertCurrentRound()),
                'name' => $this->playerName,
                'alert' => true,
                'msg' => "This games score: " . $this->currentGame->getCurrentScore(),
                'average' => $this->average,
            ));
            $response->headers->clearCookie('splitit');
            return $response;
        } else {
            $response->headers->setCookie(new Cookie('splitit', json_encode($this->currentGame)));
            return $response;
        }
    }


    private function saveToDatabase()
    {
        $dbModel = new SplitScore();
        $dbModel->setFinalscore($this->currentGame->getCurrentScore());
        $dbModel->setPlayer(PlayerQuery::create()->findOneByName($this->playerName));
        try {
            $dbModel->save();
        } catch (PropelException $e) {
            $this->addFlash('error', "Error saving to database.");
        }
    }

    private function loadSplitItGame(Request $request)
    {
        $splitIt = json_decode($request->cookies->get('splitit'));
        return $splitIt;
    }

    /**
     * @param $form
     * Handles the form data.
     */
    private function handleData($form)
    {
        $result = $form->getData();
        if ($result->getScore() != 0) {
            // Validate here
            if (!$this->validateScore($result->getScore())) {
                $this->addFlash('error', 'Ungültiger Score.');
                return;
            }
            $this->currentGame->setCurrentScore($this->currentGame->getCurrentScore() + $result->getScore());
            $this->logger->debug("Not halving");
        } else {
            $score = $this->currentGame->getCurrentScore();
            $score = ceil($score / 2);
            $this->currentGame->setCurrentScore($score);
            $this->addFlash("success", "Halving");
        }
        $this->currentGame->setCurrentRound(($this->currentGame->getCurrentRound() + 1) % 9);
        if ($this->currentGame->getCurrentRound() == 0) {
            $this->saveToDatabase();
        }
    }

    private function validateScore($shotScore)
    {
        if ($shotScore % $this->convertCurrentRound() != 0 || $shotScore > 180 || $shotScore < 0) {
            return false;
        }
        return true;
    }


    private function convertCurrentRound()
    {
        $currentRound = $this->currentGame->getCurrentRound();
        switch ($currentRound) {
            case 0:
                return 15;
            case 1:
                return 16;
            case 2:
                return 2;
            case 3:
                return 17;
            case 4:
                return 18;
            case 5:
                return 3;
            case 6:
                return 19;
            case 7:
                return 20;
            case 8:
                return 25;
            default:
                return 0;
        }
    }

    private function convertRoundToString($round)
    {
        switch ($round) {
            case 2:
                return "Beliebiges Doppel";
            case 3:
                return "Beliebiges Trippel";
            case 25:
                return "Bull";
            default:
                return $round;
        }
    }

    private function calculateAverage()
    {
        $player = PlayerQuery::create()->findOneByName($this->playerName);
        $splitGames = SplitScoreQuery::create()->findByPlayerid($player->getId())->getColumnValues('finalScore');
        $score = 0;
        foreach ($splitGames as $game) {
            $score += $game;
        }
        if (sizeof($splitGames) == 0) return 0;
        return round($score / sizeof($splitGames), 0);
    }

}
