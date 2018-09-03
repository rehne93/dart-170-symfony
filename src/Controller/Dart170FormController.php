<?php

namespace App\Controller;

use App\Forms\Game170Form;
use App\model\Dart170;
use DateTime;
use Game;
use Map\GameTableMap;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Propel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;


class Dart170FormController extends AbstractController
{

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private $logger;

    /**
     * @Route("/dart/170", name="dart170_form")
     */
    public function new(Request $request)
    {
        $dartStats = new Dart170();
        $dartStats->setDate(new DateTime('today'));

        $dartStats->setNumRounds(0);

        $form = $this->createForm(Game170Form::class, $dartStats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dartStats = $form->getData();
            if ($dartStats->getNumRounds() == 0) {
                return $this->render('dart170_form/index.html.twig', array('form' => $form->createView()));
            }
            $this->logger->info("Form Rounds: " . $dartStats->getNumRounds());
            $game = new Game();
            $game->setGametype("170");
            $game->setRounds($dartStats->getNumRounds());
            $game->setDate($dartStats->getDate());
            try {
                $game->save();
                $this->addFlash('success', "Saved game");
            } catch (PropelException $e) {
            }

        }

        return $this->render('dart170_form/index.html.twig', array('form' => $form->createView()));
    }
}
