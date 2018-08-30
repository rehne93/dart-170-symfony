<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 25.08.2018
 * Time: 14:20
 */

namespace App\Utility;

use Symfony\Component\Finder\Finder;

class DartStatsContainer
{
    private $numberOfGames;
    private $roundTotal;


    public function calculateAverageRounds()
    {
        return $this->roundTotal / $this->numberOfGames;
    }

    // TODO Add specific file.
    public function parseFile()
    {
        $finder = new Finder();
        $finder->files()->in(__DIR__)->name("*.txt");
        $foundFiles = "";
        foreach($finder as $files){
            $foundFiles .= $files;
            $statFile = fopen($files->getRealPath(), "r");
            $content = fread($statFile, filesize($files->getRealPath()));
            $this->getNumbers($content);
        }

        return $this;
    }


    private function getNumbers($content){
        $breaks = array("\r\n","\r","\n");
        $content = str_replace($breaks, "\n", $content);
        $splitedByLine = explode("\n",$content);
        foreach($splitedByLine as $string){
            $splitedByDate = explode(":",$string);
            $numbers = $splitedByDate[1];
            $numbersSplited = explode(",",$numbers);
            foreach($numbersSplited as $num){
                $this->roundTotal+=$num;
                $this->numberOfGames++;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getNumberOfGames()
    {
        return $this->numberOfGames;
    }

    /**
     * @return mixed
     */
    public function getRoundTotal()
    {
        return $this->roundTotal;
    }


}