<?php

namespace App\Controller;

use App\Forms\SplitItForm;
use App\model\SplitIt;
use App\Utility\Authorizer;
use App\Utility\SplitItCircle;
use Propel\Runtime\Exception\PropelException;
use Psr\Log\LoggerInterface;
use SplitScore;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SplitItController extends AbstractController
{
    // TODO Implement game logic

    private $logger;

    private $currentGame;
    private $currentTarget = "";
    private $playerName = "";
    private $round = 0;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

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

        $this->currentGame = new SplitIt();
        $this->currentGame->setScore(0);

        $this->handleCookiesOnLoad($request);


        $form = $this->createForm(SplitItForm::class, $this->currentGame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleData($form);
        }


        $response = $this->render('split_it/index.html.twig', array(
            'currentScore' => $this->currentGame->getCurrentScore(),
            'form' => $this->createForm(SplitItForm::class, $this->currentGame)->createView(),
            'currentTarget' => $this->currentTarget,
            'name' => $this->playerName
        ));
        $this->handleCookiesOnEnd($response);
        return $response;
    }

    /**
     * @param $form
     * Handles the form data.
     */
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

    private function handleCookiesOnLoad(Request $request)
    {
        if ($request->cookies->has('score')) {
            $this->currentGame->setCurrentScore($request->cookies->get('score'));
        } else {
            $this->currentGame->setCurrentScore(40);
        }
        if ($request->cookies->has('round')) {
            $this->round = $request->cookies->get('round');
            $this->currentTarget = SplitItCircle::getCurrentRound($this->round);
        } else {
            $this->currentTarget = SplitItCircle::getCurrentRound(0);
        }
    }

    private function handleCookiesOnEnd(Response $response)
    {
        // Win Condition
        if ($this->currentTarget == '') {
            $splitScore = new SplitScore();
            try {
                $splitScore->setPlayer(\PlayerQuery::create()->findOneByName($this->playerName));
            } catch (PropelException $e) {
            }
            $splitScore->setFinalscore($this->currentGame->getCurrentScore());
            $this->logger->debug("Saving game:" . $splitScore);
            try {
                $splitScore->save();
            } catch (PropelException $e) {
            }
            $this->deleteCookies($response);
            $this->currentGame->setCurrentScore(80); // HACK, has to be fixed.
            $this->round = -1;
        }
        $response->headers->setCookie(new Cookie('score', $this->currentGame->getCurrentScore()));
        $this->round++;
        $this->logger->debug("Round " . $this->round);
        $response->headers->setCookie(new Cookie('round', $this->round));
    }

    private function deleteCookies(Response $response)
    {
        $response->headers->removeCookie('score');
        $response->headers->removeCookie('round');
    }


}
