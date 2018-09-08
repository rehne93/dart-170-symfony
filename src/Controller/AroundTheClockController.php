<?php

namespace App\Controller;

use App\Forms\AroundTheClockForm;
use App\model\AroundTheClockFormClass;
use App\Utility\Authorizer;
use AroundTheClock;
use PlayerQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class AroundTheClockController extends AbstractController
{

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    private $logger;
    private $playerName;

    /**
     * @Route("/dart/around-the-clock", name="around_the_clock")
     */
    public function new(Request $request)
    {
        $auth = new Authorizer();
        $this->playerName = $auth->isAuthorized($request);
        if ($this->playerName === '') {
            return $this->redirectToRoute('new_player');
        }

        $aroundTheClock = new AroundTheClockFormClass();
        $aroundTheClock->setBullIncluded(true);
        $aroundTheClock->setNumDarts(0);

        $form = $this->createForm(AroundTheClockForm::class, $aroundTheClock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // TODO: Handling the data!
            $this->logger->debug("Handling the data, yeah");
            $this->handleForm($form);
        }

        $response = $this->render('around_the_clock/index.html.twig', array('name' => $this->playerName,
            'form' => $form->createView(),
        ));
        return $response;
    }


    private function handleForm($form)
    {
        $aroundTheWorld = $form->getData();
        if ($aroundTheWorld->getNumDarts() < 20) {
            return $this->render('around_the_clock/index.html.twig', array('form' => $form->createView()));
        }

        $dbData = new \AroundTheClock();
        $dbData->setBullincluded($aroundTheWorld->getBullincluded());
        $dbData->setDartsneeded($aroundTheWorld->getNumDarts());

        // TODO Put this in utility method or somewhere else, don't care
        $playerQuery = new PlayerQuery();
        $player = $playerQuery->findByName($this->playerName)->getFirst();
        if ($player === null) {
            $this->logger->debug("Player: " . $this->playerName . " not found.");
            return $this->redirectToRoute('new_player');
        } else {
            $this->logger->debug("Player found.");
        }


        $dbData->setPlayer($player);
        try {
            $dbData->save();
            $this->addFlash('success', "Saved game");
        } catch (PropelException $e) {
        }
    }
}
