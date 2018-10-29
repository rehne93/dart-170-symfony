<?php

namespace App\Controller;

use App\Forms\NewUserForm;
use App\model\PlayerForm;
use App\Utility\Authorizer;
use Player;
use PlayerQuery;
use Propel\Runtime\Exception\PropelException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class NewPlayerController extends AbstractController
{
    private $logger;
    private $playerName;
    private $isLoggedIn = false;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("dart/player", name="new_player")
     */
    public function new(Request $request)
    {

        $session = new Session();
        $session->getFlashBag()->clear();

        $player = new PlayerForm();
        $player->setPassword("");
        $player->setName("");

        $form = $this->createForm(NewUserForm::class, $player);
        $form->handleRequest($request);
        $response = $this->render('new_player/index.html.twig', array('form' => $form->createView(), 'loggedIn' => false));
        $redirect = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $redirect = $this->handleForm($form, $response);
        }
        $loggedIn = false;

        if ($redirect) {
            foreach ($response->headers->getCookies() as $cookie) {
                $this->logger->debug("Cookie: " . $cookie->getName() . ":" . $cookie->getValue());
            }
            $loggedIn = true;

            $this->addFlash('success', "Player logged in! Choose a game!");

        }
        $auth = new Authorizer();
        if ($auth->isAuthorized($request)) {
            $loggedIn = true;
        }
        $response = $this->render('new_player/index.html.twig', array('form' => $form->createView(), 'loggedIn' => $loggedIn));
        $response->headers->setCookie(new Cookie('player', $this->playerName));

        return $response;
    }


    private function handleForm($form, $response)
    {
        $player = $form->getData();
        if ($player->getName() === '' || $player->getPassword() == '' || $player->getName() === null) {
            return false;
        }
        $dbPlayer = new Player();
        $dbPlayer->setName($player->getName());
        $dbPlayer->setPassword($player->getPassword());

        $playerQuery = new PlayerQuery();

        if ($playerQuery->findByName($dbPlayer->getName())->isEmpty()) {
            try {
                $dbPlayer->save();
                $this->logger->debug("Player saved succesfully.");
                $this->addFlash('success', "Player saved");

                $response->headers->setCookie(new Cookie("player", $dbPlayer->getName()));

            } catch (PropelException $e) {
            }
        } else {
            $extracted = $playerQuery->findByName($dbPlayer->getName())->getFirst();
            if ($extracted->getPassword() != $dbPlayer->getPassword()) {
                $this->addFlash('error', "Wrong password.");
                return false;
            }
            $this->isLoggedIn = true;
            $this->playerName = $dbPlayer->getName();
            return true;
        }
        return false;
    }


}
