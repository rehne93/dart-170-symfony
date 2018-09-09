<?php

namespace App\Controller;

use App\Forms\Game170Form;
use App\model\Dart170;
use DateTime;
use Game;
use GameQuery;
use PlayerQuery;
use Propel\Runtime\Exception\PropelException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\{Route};
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

// TODO Flash Management

class Dart170FormController extends AbstractController
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    private $logger;
    private $playerName="";

    /**
     * @Route("/dart/170", name="dart170_form")
     */
    public function new(Request $request)
    {
        $cookie = $request->cookies;
        if ($cookie->has('player')) {
            $this->logger->debug("Found Player");
            $this->playerName = $cookie->get('player');
        } else {
            return $this->redirectToRoute('new_player');
        }
        $dartStats = new Dart170();
        $dartStats->setDate(new DateTime('today'));
        $dartStats->setNumRounds("0");

        $form = $this->createForm(Game170Form::class, $dartStats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleData($form);
        }


        $response = $this->render('dart170_form/index.html.twig', array('name' => $this->playerName,
            'form' => $this->createForm(Game170Form::class,$dartStats)->createView(),
            'average' => $this->calculateAverage()));
        return $response;
    }


    // TODO Improve this by not always grabbing  data
    private function calculateAverage()
    {
        $playerQuery = new PlayerQuery();
        $player = $playerQuery->findByName($this->playerName)->getFirst();
        $gameQuery = new GameQuery();
        $gameValues = $gameQuery->findByPlayerid($player->getId())->getColumnValues('rounds');
        $sum = 0;
        foreach ($gameValues as $val) {
            $sum += $val;
        }
        $this->logger->debug("Sum 2: " .$sum.", Rounds 2: ".sizeof($gameValues));

        return sizeof($gameValues ) === 0 ? 0.0 : round($sum / sizeof($gameValues), 3);

    }

    private function handleData($form)
    {
        $dartStats = $form->getData();
        if ($dartStats->getNumRounds() == 0) {
            return $this->render('dart170_form/index.html.twig', array('form' => $form->createView()));
        }
        $this->logger->info("Form Rounds: " . $dartStats->getNumRounds());
        $playerQuery = new PlayerQuery();
        $player = $playerQuery->findByName($this->playerName)->getFirst();
        if ($player === null) {
            $this->logger->debug("Player: " . $this->playerName . " not found.");
            return $this->redirectToRoute('new_player');
        } else {
            $this->logger->debug("Player found.");
        }
        $game = new Game();
        $game->setGametype("170");
        $game->setRounds($dartStats->getNumRounds());
        $game->setDate($dartStats->getDate());
        $game->setPlayer($player);
        try {
            $game->save();
            $this->addFlash('success', "Saved game");
        } catch (PropelException $e) {
        }
    }
}
