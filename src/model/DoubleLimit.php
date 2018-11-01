<?php
/**
 * Created by PhpStorm.
 * User: René
 * Date: 01.11.2018
 * Time: 19:34
 */

namespace App\model;


use JsonSerializable;

class DoubleLimit implements JsonSerializable
{
    private $numbers = array();
    private $finished;
    private $notFinished;

    /**
     * DoubleLimit constructor.
     * @param array $numbers
     */
    public function __construct()
    {
        array_push($this->numbers, 120);
    }


    /**
     * @return array
     */
    public function getNumbers(): array
    {
        return $this->numbers;
    }

    /**
     * @param array $numbers
     */
    public function setNumbers(array $numbers): void
    {
        $this->numbers = $numbers;
    }


    public function addNumber(int $number)
    {
        array_push($this->numbers, $number);
    }

    public function incrementFinished()
    {
        $this->finished++;
    }

    public function incrementNotFinished()
    {
        $this->notFinished++;
    }

    /**
     * @return mixed
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * @return mixed
     */
    public function getNotFinished()
    {
        return $this->notFinished;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'numbers' => $this->numbers,
            'finished' => $this->finished,
            'notFinished' => $this->notFinished
        ];
    }

    public function set($jsonData)
    {
        foreach ($jsonData AS $key => $value) $this->{$key} = $value;
    }
}
