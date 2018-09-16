<?php

namespace App\Controller;

use App\Forms\Game170Form;
use App\model\Dart170;
use Critera;
use DateTime;
use Game;
use GameQuery;
use PlayerQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\{Route};
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraints\Date;

// TODO Flash Management

class Dart170FormController extends AbstractController
{
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    private $logger;
    private $playerName = "";

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
        $dateTime = new DateTime();
        $dateTime->format('Y-m-d H:i:s');
        $dartStats->setDate($dateTime);
        $dartStats->setNumRounds("0");

        $form = $this->createForm(Game170Form::class, $dartStats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleData($form);
        }


        $response = $this->render('dart170_form/index.html.twig', array('name' => $this->playerName,
            'form' => $this->createForm(Game170Form::class, $dartStats)->createView(),
            'average' => $this->getAllTimeAverage(),
            'shotList' => $this->getLastShots(),
            'average_week' => $this->getAverageLastWeek(),
            'games_total' => $this->getAllTimeGames(),
            'games_week' => $this->getLastWeekGames()));
        return $response;
    }


    private function secondsLast7Days()
    {
        return 7 * 24 * 60 * 60;
    }

    private function getLastWeekGames()
    {
        return sizeof(GameQuery::create()
            ->filterByDate(array('min' => time() - $this->secondsLast7Days()))
            ->findByPlayerid($this->getPlayer()->getId()));
    }

    private function getAllTimeGames()
    {
        return sizeof(GameQuery::create()->findByPlayerid($this->getPlayer()->getId()));
    }

    // TODO Improve this by not always grabbing  data
    private function getAllTimeAverage()
    {
        $player = $this->getPlayer();
        $gameQuery = new GameQuery();
        $gameValues = $gameQuery->findByPlayerid($player->getId())->getColumnValues('rounds');
        $sum = 0;
        foreach ($gameValues as $val) {
            $sum += $val;
        }
        $this->logger->debug("Sum 2: " . $sum . ", Rounds 2: " . sizeof($gameValues));

        return sizeof($gameValues) === 0 ? 0.0 : round($sum / sizeof($gameValues), 3);

    }


    private function getAverageLastWeek()
    {
        $player = $this->getPlayer();
        $games = GameQuery::create()
            ->filterByDate(array('min' => time() - $this->secondsLast7Days()))
            ->findByPlayerid($player->getId())
            ->getColumnValues('rounds');
        $sum = 0;
        foreach ($games as $g) {
            $sum += $g;
        }


        return sizeof($games) === 0 ? 0.0 : round($sum / sizeof($games), 3);


    }

    private function getLastShots()
    {
        $player = $this->getPlayer();
        $list = "";
        try {
            $gameValues = GameQuery::create()->filterByPlayer($player)
                ->select(array('rounds'))
                ->orderByDate(Criteria::DESC)
                ->limit(10)
                ->find();
            foreach ($gameValues as $game) {
                $list .= $game . " ";
            }
        } catch (PropelException $e) {
        }

        return $list;
    }


    private function getPlayer()
    {
        $playerQuery = new PlayerQuery();
        $player = $playerQuery->findByName($this->playerName)->getFirst();
        return $player;
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
