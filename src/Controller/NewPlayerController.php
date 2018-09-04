<?php

namespace App\Controller;

use App\Forms\NewUserForm;
use App\model\PlayerForm;
use Player;
use PlayerQuery;
use Propel\Runtime\Exception\PropelException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewPlayerController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("dart/player/new", name="new_player")
     */
    public function new(Request $request)
    {


        $player = new PlayerForm();
        $player->setPassword("");
        $player->setName("");

        $form = $this->createForm(NewUserForm::class, $player);
        $form->handleRequest($request);
        $response = $this->render('new_player/index.html.twig', array('form' => $form->createView()));
        $redirect = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $redirect = $this->handleForm($form, $response);
        }
        if ($redirect) {
            foreach ($response->headers->getCookies() as $cookie) {
                $this->logger->debug("Cookie: " . $cookie->getName() . ":" . $cookie->getValue());
            }
            $response->send();
            return $this->redirectToRoute('dart170_form');

        }

        return $response;
    }

    /**
     * @param $form
     * @param $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private
    function handleForm($form, $response)
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
            $response->headers->setCookie(new Cookie('player', $dbPlayer->getName()));
            $this->addFlash('error', "Player already exists. Logged in.");
            return true;
        }
        return false;
    }


}
