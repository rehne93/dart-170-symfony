<?php

namespace App\Controller;

use App\Utility\DartStatsContainer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Dart170StatsController extends AbstractController
{
    /**
     * @Route("/dart/170/stats", name="dart170_stats")
     */
    public function index()
    {
        $dartStatsContainer = new DartStatsContainer();
        $dartStatsContainer->parseFile();

        return $this->render('dart170_stats/index.html.twig',[
            'rounds' => $dartStatsContainer->getNumberOfGames(),
            'total' => $dartStatsContainer->getRoundTotal(),
            'average' => $dartStatsContainer->calculateAverageRounds(),
        ]);
        /* return $this->render('dart170_stats/index.html.twig', [
             'controller_name' => 'Dart170StatsController',
         ]);*/
    }
}


